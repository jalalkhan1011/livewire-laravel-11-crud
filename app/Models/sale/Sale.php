<?php

namespace App\Models\sale;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['date', 'sku', 'sub_total', 'discount', 'grand_total'];

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
