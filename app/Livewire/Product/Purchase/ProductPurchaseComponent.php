<?php

namespace App\Livewire\Product\Purchase;

use App\Models\Product;
use App\Models\ProductPurchase;
use Livewire\Component;

class ProductPurchaseComponent extends Component
{
    public $productPurchases, $date, $sku, $total, $product_purchase_id;
    public $items = [];
    public $grandtotal = 0;
    public $products;
    public $isCreateModalOpen = false;
    public $isEditModalOpen = false;

    public function mount()
    {
        $this->products = Product::pluck('name', 'id');
        $this->date = now()->format('Y-m-d'); // Set default date
        $this->items[] = ['product_id' => '', 'quantity' => 1, 'price' => 0, 'individual_total' => 0];
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'quantity' => 1, 'price' => 0, 'individual_total' => 0];
        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function itemUpdate($index)
    {
        $this->items[$index]['individual_total'] = $this->items[$index]['price'] * $this->items[$index]['quantity'];
        $this->calculateTotal();
    }

    public function productUpdate($index)
    {
        $product = Product::find($this->items[$index]['product_id']);
        $this->items[$index]['price'] = $product->price;
        $this->items[$index]['individual_total'] = $product->price * $this->items[$index]['quantity'];
        $this->calculateTotal();
    }

    public function priceUpdate()
    {
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->grandtotal = 0;
        foreach ($this->items as $index => $item) {
            $this->items[$index]['individual_total'] = $item['price'] * $item['quantity'];
            $this->grandtotal += $this->items[$index]['individual_total'];
        }
    }

    public function render()
    {
        $this->productPurchases = ProductPurchase::all();

        return view('livewire.product.purchase.product-purchase-component');
    }

    private function resetInputFields()
    {
        $this->total = '';
        $this->items = [];
    }

    public function openCreateModal()
    {
        $this->isCreateModalOpen = true;
        $this->resetInputFields();
    }

    public function openEditModal()
    {
        $this->isEditModalOpen = true;
        $this->resetInputFields();
    }

    public function closeModal()
    {
        $this->isCreateModalOpen = false;
        $this->isEditModalOpen = false;
        $this->resetInputFields();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openCreateModal();
    }

    public function store()
    {
        dd('store');
    }
}
