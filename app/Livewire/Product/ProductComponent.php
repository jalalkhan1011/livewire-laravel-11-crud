<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class ProductComponent extends Component
{
    public $products, $sku, $name, $price, $product_id;
    public $updateMode = false;

    public function render()
    {
        $this->products = Product::all();

        return view('livewire.product.product-component');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->price = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:products,name',
            'price' => 'required',
        ]);

        product::create([
            'sku' => rand(),
            'name' => $this->name,
            'price' => $this->price
        ]);

        session()->flash('message', 'Product Created Successfully');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->product_id = $id;
        $this->name = $product->name;
        $this->price = $product->price;

        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:products,name,' . $this->product_id,
            'price' => 'required'
        ]);

        if ($this->product_id) {
            $product = Product::findOrFail($this->product_id);
            $product->update([
                'name' => $this->name,
                'price' => $this->price
            ]);
        }

        $this->updateMode = false;

        session()->flash('message',  'Product Updated Successfully');

        $this->resetInputFields();
    }

    public function delete($id)
    {
        if ($id) {
            Product::findOrFail($id)->delete();

            Session()->flash('message', 'Product Deleted Successfully');
        }
    }
}
