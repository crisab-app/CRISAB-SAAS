<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('grupos.store.index', $group) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-600 rounded-md text-sm font-medium text-gray-800 dark:text-gray-300 hover:text-white hover:bg-gray-700 transition shadow-sm">
                &larr; Volver al Menú
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                🛒 Punto de Venta: {{ $group->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                
                <div class="w-full lg:w-2/3 flex flex-col gap-6">
                    
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">🔍 Escanear código o buscar producto</label>
                        <input type="text" id="searchInput" autofocus placeholder="Pasa el escáner o escribe aquí..." 
                               class="w-full text-lg p-4 bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-200 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex-grow">
                        <h3 class="text-gray-500 dark:text-gray-400 font-bold mb-4 uppercase tracking-wider text-sm">Productos Disponibles</h3>
                        
                        @if($products->isEmpty())
                            <div class="text-center py-10">
                                <p class="text-gray-500 text-lg">No hay productos en stock.</p>
                                <p class="text-sm">Ve al módulo de Inventario para agregar mercancía.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4" id="productsGrid">
                                @foreach($products as $product)
                                    <button type="button" 
                                            onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->sale_price }}, {{ $product->stock }}, '{{ $product->barcode }}')"
                                            data-barcode="{{ $product->barcode }}"
                                            data-name="{{ strtolower($product->name) }}"
                                            class="product-card bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-4 text-left hover:bg-blue-50 dark:hover:bg-blue-900/40 hover:border-blue-500 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 active:scale-95 shadow-sm">
                                        <p class="font-black text-gray-800 dark:text-white text-lg leading-tight mb-2">{{ $product->name }}</p>
                                        <div class="flex justify-between items-end">
                                            <p class="text-blue-600 dark:text-blue-400 font-bold text-xl">${{ number_format($product->sale_price, 2) }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ $product->stock }} disp.</p>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-gray-900 border border-gray-700 rounded-2xl shadow-xl flex flex-col h-[600px] lg:h-full sticky top-6">
                        
                        <div class="p-5 border-b border-gray-800 bg-gray-800/50 rounded-t-2xl">
                            <h3 class="text-xl font-black text-white flex items-center gap-2">🛒 Ticket de Venta</h3>
                        </div>

                        <div class="flex-grow overflow-y-auto p-4 space-y-3" id="cartItems">
                            <div class="text-center text-gray-500 py-10 italic" id="emptyCartMsg">
                                Escanea o selecciona productos para armar el ticket...
                            </div>
                        </div>

                        <div class="p-6 bg-gray-800 border-t border-gray-700 rounded-b-2xl">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-gray-400 font-bold text-lg uppercase tracking-wider">Total a Pagar</span>
                                <span class="text-4xl font-black text-green-400" id="cartTotal">$0.00</span>
                            </div>

                            <form action="{{ route('grupos.store.pos.store', $group) }}" method="POST" id="checkoutForm">
                                @csrf
                                <input type="hidden" name="cart_data" id="cartDataInput">
                                
                                <button type="submit" id="checkoutBtn" disabled class="w-full bg-green-500 hover:bg-green-600 disabled:bg-gray-600 disabled:cursor-not-allowed text-white text-xl font-black py-4 rounded-xl shadow-lg hover:shadow-green-500/30 transition transform active:scale-95 flex justify-center items-center gap-2">
                                    💰 COBRAR
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let cart = {}; // Objeto para guardar el carrito { 'id_producto': { id, name, price, qty, maxStock } }

        function addToCart(id, name, price, maxStock, barcode) {
            if (maxStock <= 0) {
                alert('¡No hay inventario de este producto!');
                return;
            }

            if (cart[id]) {
                if (cart[id].qty < maxStock) {
                    cart[id].qty++;
                } else {
                    alert('¡No puedes vender más de los que tienes en stock!');
                    return;
                }
            } else {
                cart[id] = { id: id, name: name, price: price, qty: 1, maxStock: maxStock };
            }
            updateCartUI();
        }

        function decreaseQty(id) {
            if (cart[id]) {
                cart[id].qty--;
                if (cart[id].qty <= 0) delete cart[id];
                updateCartUI();
            }
        }

        function updateCartUI() {
            const container = document.getElementById('cartItems');
            const emptyMsg = document.getElementById('emptyCartMsg');
            const totalEl = document.getElementById('cartTotal');
            const dataInput = document.getElementById('cartDataInput');
            const checkoutBtn = document.getElementById('checkoutBtn');

            let total = 0;
            let html = '';
            let cartArray = [];

            for (let id in cart) {
                let item = cart[id];
                let subtotal = item.price * item.qty;
                total += subtotal;
                cartArray.push(item);

                html += `
                    <div class="bg-gray-800 p-3 rounded-lg border border-gray-700 flex justify-between items-center text-white shadow-sm">
                        <div class="flex-1">
                            <p class="font-bold text-sm truncate pr-2">${item.name}</p>
                            <p class="text-blue-400 text-xs font-black">$${item.price.toFixed(2)}</p>
                        </div>
                        <div class="flex items-center gap-3 bg-gray-900 rounded-lg p-1">
                            <button type="button" onclick="decreaseQty(${item.id})" class="w-8 h-8 rounded-md bg-red-500/20 text-red-500 hover:bg-red-500 hover:text-white font-bold transition">-</button>
                            <span class="font-black w-6 text-center">${item.qty}</span>
                            <button type="button" onclick="addToCart(${item.id}, '${item.name}', ${item.price}, ${item.maxStock})" class="w-8 h-8 rounded-md bg-green-500/20 text-green-500 hover:bg-green-500 hover:text-white font-bold transition">+</button>
                        </div>
                        <div class="w-16 text-right font-black text-lg">
                            $${subtotal.toFixed(2)}
                        </div>
                    </div>
                `;
            }

            if (cartArray.length > 0) {
                emptyMsg.style.display = 'none';
                container.innerHTML = html;
                checkoutBtn.disabled = false;
            } else {
                emptyMsg.style.display = 'block';
                container.innerHTML = '';
                container.appendChild(emptyMsg);
                checkoutBtn.disabled = true;
            }

            totalEl.innerText = '$' + total.toFixed(2);
            dataInput.value = JSON.stringify(cartArray);
        }

        // LÓGICA DEL ESCÁNER / BUSCADOR
        document.getElementById('searchInput').addEventListener('input', function(e) {
            let term = e.target.value.toLowerCase().trim();
            let cards = document.querySelectorAll('.product-card');
            
            // Lógica de búsqueda visual
            cards.forEach(card => {
                let name = card.getAttribute('data-name');
                if (name.includes(term)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Escuchar cuando el escáner presiona "Enter"
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Evitar que mande el formulario general
                let barcode = this.value.trim();
                if(barcode === '') return;

                // Buscar la tarjeta que tenga ese código de barras exacto
                let foundCard = document.querySelector(`.product-card[data-barcode="${barcode}"]`);
                
                if(foundCard) {
                    foundCard.click(); // Simulamos un clic en el producto
                    this.value = ''; // Limpiamos la barra para el siguiente escaneo
                    
                    // Restaurar la vista de todos los productos
                    document.querySelectorAll('.product-card').forEach(c => c.style.display = 'block');
                } else {
                    // Solo mostramos alerta si realmente escribieron un código largo, para no molestar si solo escriben una letra
                    if(barcode.length > 3) alert('Producto no encontrado en inventario');
                }
            }
        });
    </script>
</x-app-layout>