<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    protected $fillable = ['date', 'sku', 'total'];

    public function purchaseProductItems()
    {
        return $this->hasMany(PurchaseProductItem::class);
    }
}
