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
    public $isCreateModalOpen = false;
    public $isEditModalOpen = false;

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
        $this->grandtotal = '';
        $this->items = [];
    }

    public function openCreateModal()
    {
        $this->isCreateModalOpen = true;
    }

    public function openEditModal()
    {
        $this->isEditModalOpen = true;
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
        $this->openEditModal();
    }

    public function update()
    {
        $this->validate([
            'date' => 'required',
            'items.*.product_id' => 'required',
            'items.*.qty' => 'required',
            'items.*.price' => 'required',
        ]);
        if ($this->product_purchase_id) {
            $purchase = ProductPurchase::findOrFail($this->product_purchase_id);
            $purchase->update(['date' => $this->date, 'total' => $this->grandtotal]);
            $this->purchaseItemBatchUpdate($this->product_purchase_id);
            $this->purchaseItemUpdate($this->product_purchase_id); 
        }

        $this->closeModal();
        session()->flash('message', 'Product Purchase Successfully');
    }

    public function purchaseItemArray($purchaseId)
    {
        $purchaseItems = PurchaseProductItem::where('product_purchase_id', $purchaseId)->select('product_id')->get()->toArray();
        $oldItems = [];
        foreach ($purchaseItems as $purchaseItem) {
            $oldItems[] = $purchaseItem['product_id'];
        }
        return $oldItems;
    }

    public function purchaseItemBatchUpdate($purchaseId)
    {
        $previousPurchaseItems = $this->purchaseItemArray($purchaseId);
        $addProducts = array_diff(array_column($this->items, 'product_id'), $previousPurchaseItems);
        $removeProducts = array_diff($previousPurchaseItems, array_column($this->items, 'product_id'));
        foreach ($addProducts as $addProduct) {
            PurchaseProductItem::create([
                'sku' => rand(),
                'product_id' => $addProduct,
                'product_purchase_id' => $purchaseId,
                'price' => $this->items[array_search($addProduct, array_column($this->items, 'product_id'))]['price'],
                'qty' => $this->items[array_search($addProduct, array_column($this->items, 'product_id'))]['qty'],
                'individual_total' => $this->items[array_search($addProduct, array_column($this->items, 'product_id'))]['individual_total']
            ]);
        }
        PurchaseProductItem::whereIn('product_id', $removeProducts)->where('product_purchase_id', $purchaseId)->delete();
    }

    public function purchaseItemUpdate($purchaseId)
    {
        $purchaseItems = PurchaseProductItem::where('product_purchase_id', $purchaseId)->select('id')->get()->toArray();
        
        $itemPurchases = [];
        foreach ($purchaseItems as $purchaseItem) {
            $itemPurchases[] = $purchaseItem['id'];
        }
        
        foreach ($itemPurchases as $key => $itemPurchase) {
            $productFind =PurchaseProductItem::find($itemPurchase); 
            if($productFind['product_id']){
                $productFind->update([
                    'product_id' => $this->items[$key]['product_id'],
                    'price' => $this->items[$key]['price'],
                    'qty' => $this->items[$key]['qty'],
                    'individual_total' => $this->items[$key]['individual_total']
                ]);
            }
        }
    }

    public function  delete($id)
    {
        $productPurchase = ProductPurchase::findOrFail($id);
        $productPurchase->delete();
        session()->flash('message', 'Product Purchase Deleted Successfully');
    }
}
