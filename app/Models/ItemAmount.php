<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAmount extends Model
{
    protected $fillable = ['uuid', 'item_id', 'item_name', 'price', 'qty', 'sub_total'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
