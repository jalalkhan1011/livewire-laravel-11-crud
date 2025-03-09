<?php

namespace App\Livewire\Product\Sale;

use App\Models\Product;
use App\Models\PurchaseProductItem;
use App\Models\sale\Sale;
use Livewire\Component;

class ProductSaleComponent extends Component
{
    public $sales, $date, $sku, $sub_total, $discount, $grand_total;
    public $saleItems = [];
    public $isCreateModalOpen = false;
    public $isEditModalOpen = false;
    public $products;
    public $productsSkus = [];
    public $subTotal = 0;
    public $total = 0;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->saleItems[] = ['product_id' => '', 'item_sku' => '', 'qty' => 1, 'price' => 0, 'individual_total' => 0];
        $this->products = Product::pluck('name', 'id');
    }

    public function addItem()
    {
        $this->saleItems[] = ['product_id' => '', 'item_sku' => '', 'qty' => 1, 'price' => 0, 'individual_total' => 0];
    }

    public function removeItem($index)
    {
        unset($this->saleItems[$index]);
        $this->saleItems = array_values($this->saleItems);
        $this->calculateTotal();
    }

    public function productUpdate($index)
    {
        $this->saleItems[$index]['productsSkus'] = PurchaseProductItem::where('product_id', $this->saleItems[$index]['product_id'])->pluck('sku', 'sku');
    }

    public function skuUpdate($index)
    {
        $productItem = PurchaseProductItem::where('sku', $this->saleItems[$index]['item_sku'])->first();
        $this->saleItems[$index]['price'] = $productItem->price;
        $this->saleItems[$index]['individual_total'] = $productItem->price * $this->saleItems[$index]['qty'];
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->subTotal = 0;
        foreach ($this->saleItems as  $index => $saleItem) {
            $this->saleItems[$index]['individual_total'] = $saleItem['price'] * $saleItem['qty'];
            $sub = $this->subTotal += $this->saleItems[$index]['individual_total'];
        }
        $this->total = $sub - $this->discount;
    }

    
    public function render()
    {
        $this->sales = Sale::all();

        return view('livewire.product.sale.product-sale-component');
    }

    private function resetInputFields()
    {
        $this->date = now()->format('Y-m-d');
        $this->subTotal = '';
        $this->total = '';
        $this->saleItems = [];
    }

    public function openCreateModal()
    {
        $this->isCreateModalOpen = true;
    }

    public function closeModal()
    {
        $this->isCreateModalOpen = false;
        $this->resetInputFields();
    }

    public function create()
    {
        $this->openCreateModal();
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate([
            'date' => 'required',
            'saleItems.*.product_id' => 'required',
            'saleItems.*.item_sku' => 'required',
            'saleItems.*.qty' => 'required',
            'saleItems.*.price' => 'required',
        ]);

        $productSale = Sale::create(['date' => $this->date, 'sku' => rand(), 'sub_total', 'discount', 'grand_total']);
    }
}
