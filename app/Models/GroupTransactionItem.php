<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTransactionItem extends Model
{
    protected $fillable = ['group_transaction_id', 'group_product_id', 'quantity', 'price'];

    public function transaction()
    {
        return $this->belongsTo(GroupTransaction::class, 'group_transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(GroupProduct::class, 'group_product_id');
    }
}