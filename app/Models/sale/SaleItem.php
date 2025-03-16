<?php

namespace App\Models\sale;

use App\Models\Product;
use App\Models\PurchaseProductItem;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = ['date', 'purchase_product_item_id', 'sale_id', 'product_id', 'price', 'qty', 'individual_total'];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productPurchaseItem()
    {
        return $this->belongsTo(PurchaseProductItem::class, 'purchase_product_item_id');
    }
}
