<?php

use App\Livewire\DynamicTableComponent;
use App\Livewire\PostComponent;
use App\Livewire\Product\ProductComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', PostComponent::class)->name('posts');
Route::get('/dynamics', DynamicTableComponent::class)->name('dynamics');
Route::get('/products', ProductComponent::class)->name('products');
