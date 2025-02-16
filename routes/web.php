<?php

use App\Livewire\DynamicTableComponent;
use App\Livewire\PostComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', PostComponent::class)->name('posts');
Route::get('/dynamics', DynamicTableComponent::class)->name('dynamics');
