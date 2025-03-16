<?php

namespace App\Livewire\Product\Sale;

use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\PurchaseProductItem;
use App\Models\sale\Sale;
use App\Models\sale\SaleItem;
use Livewire\Component;

class ProductSaleComponent extends Component
{
    public $sales, $date, $sku, $sub_total, $discount, $grand_total, $sale_id;
    public $saleItems = [];
    public $isCreateModalOpen = false;
    public $isEditModalOpen = false;
    public $products;
    public $productsSkus = [];
    public $selectedProducts = [];
    public $selectedProductSkus = [];
    public $editItem = null;
    public $subTotal = 0;
    public $total = 0;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->saleItems[] = ['product_id' => '', 'purchase_product_item_id' => '', 'qty' => 1, 'price' => 0, 'individual_total' => 0];
        $this->products = Product::pluck('name', 'id');
        $this->productsSkus = PurchaseProductItem::pluck('sku', 'id'); 
    }

    public function addItem()
    {
        $this->saleItems[] = ['product_id' => '', 'purchase_product_item_id' => '', 'qty' => 1, 'price' => 0, 'individual_total' => 0];
    }

    public function removeItem($index)
    {
        unset($this->saleItems[$index]);
        $this->saleItems = array_values($this->saleItems);
        $this->calculateTotal();
    }

    public function productUpdate($index = '')
    {
        $this->saleItems[$index]['productsSkus'] = PurchaseProductItem::where('product_id', $this->saleItems[$index]['product_id'])->pluck('sku', 'id');
    }

    public function skuUpdate($index)
    {
        $productItem = PurchaseProductItem::where('id', $this->saleItems[$index]['purchase_product_item_id'])->first();
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

        $productSale = Sale::create([
            'date' => $this->date,
            'sku' => rand(),
            'sub_total' => $this->subTotal,
            'discount' => $this->discount,
            'grand_total' => $this->total
        ]);

        foreach ($this->saleItems as $saleItem) {
            SaleItem::create([
                'date' => $this->date,
                'purchase_product_item_id' => $saleItem['purchase_product_item_id'],
                'sale_id' => $productSale->id,
                'product_id' => $saleItem['product_id'],
                'price' => $saleItem['price'],
                'qty' => $saleItem['qty'],
                'individual_total' => $saleItem['individual_total']
            ]);
        }

        $this->closeModal();
        session()->flash('message', 'Product Sale Successfully');
    }

    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        $this->sale_id = $id;
        $this->date = $sale->date;
        $this->sku = $sale->sku;
        $this->subTotal = $sale->sub_total;
        $this->discount = $sale->discount;
        $this->total = $sale->grand_total;

        $this->saleItems = SaleItem::where('sale_id', $sale->id)->get()->toArray();

        foreach ($this->saleItems as $index => $saleItem) { // for dependent select menu selected

            $this->saleItems[$index]['productsSkus'] = PurchaseProductItem::where('product_id', $this->saleItems[$index]['product_id'])->pluck('sku', 'id');
        }

        $this->openEditModal();
    }
}
