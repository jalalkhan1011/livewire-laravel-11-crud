<?php

namespace App\Livewire\Product\Purchase;

use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\PurchaseProductItem;
use Livewire\Component;

class ProductPurchaseComponent extends Component
{
    public $productPurchases, $date, $sku, $total, $product_purchase_id;
    public $items = [];
    public $grandtotal = 0;
    public $products;
    public $isModalOpen = false;

    public function mount()
    {
        $this->products = Product::pluck('name', 'id');
        $this->date = now()->format('Y-m-d'); // Set default date
        $this->items[] = ['product_id' => '', 'qty' => 1, 'price' => 0, 'individual_total' => 0];
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'qty' => 1, 'price' => 0, 'individual_total' => 0];
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
        $this->items[$index]['individual_total'] = $this->items[$index]['price'] * $this->items[$index]['qty'];
        $this->calculateTotal();
    }

    public function productUpdate($index)
    {
        $product = Product::find($this->items[$index]['product_id']);
        $this->items[$index]['price'] = $product->price;
        $this->items[$index]['individual_total'] = $product->price * $this->items[$index]['qty'];
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
            $this->items[$index]['individual_total'] = $item['price'] * $item['qty'];
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

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'date' => 'required',
            'items.*.product_id' => 'required',
            'items.*.qty' => 'required',
            'items.*.price' => 'required',
        ]);

        $productPurchase = ProductPurchase::create(['date' => $this->date, 'sku' => rand(), 'total' => $this->grandtotal]);

        foreach ($this->items as $item) {
            PurchaseProductItem::create([
                'sku' => rand(),
                'product_id' => $item['product_id'],
                'product_purchase_id' => $productPurchase->id,
                'price' => $item['price'],
                'qty' => $item['qty'],
                'individual_total' => $item['individual_total']
            ]);
        }

        $this->closeModal();
        session()->flash('message', 'Product Purchase Successfully');
    }

    public function edit($id)
    {
        $productPurchase = ProductPurchase::findOrFail($id);
        $this->product_purchase_id = $id;
        $this->date = $productPurchase->date;
        $this->sku = $productPurchase->sku;
        $this->total = $productPurchase->total;
        $this->grandtotal = $productPurchase->total;

        $this->items = PurchaseProductItem::where('product_purchase_id', $productPurchase->id)->get()->toArray();

        $this->openModal();
    }
}
