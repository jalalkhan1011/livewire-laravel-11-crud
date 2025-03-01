<?php

namespace App\Models;

use App\Models\sale\SaleItem;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['sku', 'name', 'price'];

    public function purchaseProductItems()
    {
        return $this->hasMany(PurchaseProductItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
