<?php

use App\Livewire\Crud;
use App\Livewire\DynamicTableComponent;
use App\Livewire\PostComponent;
use App\Livewire\Product\ProductComponent;
use App\Livewire\Product\Purchase\ProductPurchaseComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', PostComponent::class)->name('posts');
Route::get('/dynamics', DynamicTableComponent::class)->name('dynamics');
Route::get('/products', ProductComponent::class)->name('products');
Route::get('/products/purchase', ProductPurchaseComponent::class)->name('productPurchases');
Route::get('/news', Crud::class)->name('news');
