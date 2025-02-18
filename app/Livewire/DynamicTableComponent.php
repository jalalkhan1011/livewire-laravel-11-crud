<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\ItemAmount;
use Livewire\Component;

class DynamicTableComponent extends Component
{
    public $items = [];
    public $total = 0;

    public function mount()
    {
        $this->items[] = ['item_name' => '', 'qty' => 1, 'price' => 0, 'sub_total' => 0];
    }

    public function addItem()
    {
        $this->items[] = ['item_name' => '', 'qty' => 1, 'price' => 0, 'sub_total' => 0];
        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function itemUpdated($index)
    {
        // if (strpos($index, 'items.') !== false) {
        //     $this->calculateTotal();
        // }
        $this->items[$index]['sub_total'] = $this->items[$index]['price'] * $this->items[$index]['qty'];
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = 0;
        foreach ($this->items as $index => $item) {
            $this->items[$index]['sub_total'] = $item['qty'] * $item['price'];
            $this->total += $this->items[$index]['sub_total'];
        }
    }

    public function render()
    {
        return view('livewire.dynamic-table-component');
    }

    public function store()
    {
        $this->validate([
            'total' => 'required'
        ]);

        $itemInfo = Item::create([
            'uuid' => uniqid(),
            'total' => $this->total
        ]);

        foreach ($this->items as $item) {
            ItemAmount::create([
                'uuid' => uniqid(),
                'item_id' => $itemInfo->id,
                'item_name' => $item['item_name'],
                'price' => $item['price'],
                'qty' => $item['qty'],
                'sub_total' => $item['sub_total']
            ]);
        }

        return back();
    }
}
