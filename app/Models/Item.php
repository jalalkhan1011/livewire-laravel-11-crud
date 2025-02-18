<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['uuid', 'total'];

    public function itemAmounts()
    {
        return $this->hasMany(ItemAmount::class);
    }
}
