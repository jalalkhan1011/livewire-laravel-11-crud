<?php

namespace App\Livewire\Product\Sale;

use App\Models\sale\Sale;
use Livewire\Component;

class ProductSaleComponent extends Component
{
    public $sales, $date, $sku, $sub_total, $discount, $ground_total;
    public $saleItems = [];

    public function render()
    {
        $this->sales = Sale::all();
        
        return view('livewire.product.sale.product-sale-component');
    }
}
