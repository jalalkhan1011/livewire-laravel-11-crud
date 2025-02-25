<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseProductItem extends Model
{
    protected $fillable = ['sku', 'product_id', 'product_purchase_id', 'qty', 'price', 'individual_total'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_id');
    }

    public function productPurchase()
    {
        return $this->belongsTo(ProductPurchase::class, 'product_purchase_id');
    }
}
