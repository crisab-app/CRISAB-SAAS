<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupProduct;
use App\Models\GroupTransaction;
use Illuminate\Http\Request;

class GroupStoreController extends Controller
{
    // --- PANEL PRINCIPAL (Dashboard 2x2) ---
    public function index(Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id || !$group->has_sales) abort(403);
        $ingresos = $group->transactions()->where('type', 'venta')->sum('total');
        $egresos = $group->transactions()->where('type', 'compra')->sum('total');
        return view('groups.store.index', compact('group', 'ingresos', 'egresos'));
    }

    // --- MÓDULO 1: VENTAS (POS) ---
    public function pos(Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id || !$group->has_sales) abort(403);
        $products = $group->products()->where('stock', '>', 0)->get();
        return view('groups.store.pos', compact('group', 'products'));
    }

public function storeSale(Request $request, Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id) abort(403);

        $cart = json_decode($request->cart_data, true);
        if (!$cart || count($cart) === 0) return back()->with('error', 'El carrito está vacío.');

        $total = 0;
        $transaction = $group->transactions()->create([
            'user_id' => auth()->id(),
            'type' => 'venta',
            'total' => 0
        ]);

        foreach ($cart as $item) {
            $product = GroupProduct::find($item['id']);
            // AQUI ESTABA EL ERROR: Cambiamos 'quantity' por 'qty' para que coincida con el Javascript
            if ($product && $product->stock >= $item['qty']) {
                $transaction->items()->create([
                    'group_product_id' => $product->id,
                    'quantity' => $item['qty'], // Javascript lo manda como 'qty'
                    'price' => $product->sale_price
                ]);
                $product->decrement('stock', $item['qty']);
                $total += ($product->sale_price * $item['qty']);
            }
        }

        $transaction->update(['total' => $total]);
        return back()->with('success', '¡Venta registrada exitosamente! Total: $' . number_format($total, 2));
    }

    // --- MÓDULO 2: COMPRAS E INSUMOS ---
    public function purchases(Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id || !$group->has_sales) abort(403);
        
        $products = $group->products()->orderBy('name')->get();
        $purchases = $group->transactions()->where('type', 'compra')->with('items.product', 'user')->latest()->take(15)->get();
        
        return view('groups.store.purchases', compact('group', 'products', 'purchases'));
    }

    public function storePurchase(Request $request, Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id) abort(403);

        $request->validate([
            'group_product_id' => 'required|exists:group_products,id',
            'quantity' => 'required|integer|min:1',
            'total_cost' => 'required|numeric|min:0.1',
            'ticket_note' => 'nullable|string|max:255',
        ]);

        $product = GroupProduct::findOrFail($request->group_product_id);

        $transaction = $group->transactions()->create([
            'user_id' => auth()->id(),
            'type' => 'compra',
            'total' => $request->total_cost
        ]);

        $transaction->items()->create([
            'group_product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $request->total_cost / $request->quantity 
        ]);

        $product->increment('stock', $request->quantity);

        return back()->with('success', 'Compra registrada: Se sumaron ' . $request->quantity . ' unidades al inventario.');
    }
public function destroyProduct(Group $group, GroupProduct $product)
    {
        // Seguridad: Verificar que el grupo sea de tu iglesia
        if ($group->contract_id != auth()->user()->contract_id) abort(403);

        // REGLA DE ORO: ¿Este producto ya tiene ventas o compras?
        $tieneMovimientos = \App\Models\GroupTransactionItem::where('group_product_id', $product->id)->exists();

        if ($tieneMovimientos) {
            // Si ya tiene historial, bloqueamos la eliminación y le avisamos al usuario
            return back()->with('error', '⛔ No puedes eliminar este producto porque ya tiene historial de compras o ventas. Si ya no lo vendes, simplemente deja su stock en 0.');
        }

        // Si es un producto nuevo que se registró por error y no tiene movimientos, sí lo borramos
        $product->delete();

        return back()->with('success', 'Producto eliminado del inventario correctamente.');
    }

    // --- MÓDULO 3: INVENTARIO ---
    public function inventory(Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id || !$group->has_sales) abort(403);
        $products = $group->products()->latest()->get();
        return view('groups.store.inventory', compact('group', 'products'));
    }

public function storeProduct(Request $request, Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id) abort(403);

        $request->validate([
            'barcode' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // 1. Creamos el producto en el catálogo
        $product = $group->products()->create($request->only(['barcode', 'name', 'cost_price', 'sale_price', 'stock']));

        // 2. MAGIA: Si el producto entró con stock inicial, lo registramos como una inversión automática
        if ($product->stock > 0) {
            $transaction = $group->transactions()->create([
                'user_id' => auth()->id(),
                'type' => 'compra',
                'total' => $product->cost_price * $product->stock // Costo x Cantidad
            ]);

            $transaction->items()->create([
                'group_product_id' => $product->id,
                'quantity' => $product->stock,
                'price' => $product->cost_price
            ]);
        }

        return back()->with('success', 'Producto agregado al catálogo exitosamente.');
    }

// --- MÓDULO 4: REPORTES ---
    public function reports(Group $group)
    {
        if ($group->contract_id != auth()->user()->contract_id || !$group->has_sales) abort(403);
        
        // Traemos TODAS las transacciones ordenadas de la más nueva a la más vieja
        $transactions = $group->transactions()->with(['user', 'items.product'])->latest()->get();
        
        // Calculamos los totales para las tarjetas de arriba
        $totalVentas = $transactions->where('type', 'venta')->sum('total');
        $totalCompras = $transactions->where('type', 'compra')->sum('total');
        $gananciaNeta = $totalVentas - $totalCompras;
        
        return view('groups.store.reports', compact('group', 'transactions', 'totalVentas', 'totalCompras', 'gananciaNeta'));
    }
}