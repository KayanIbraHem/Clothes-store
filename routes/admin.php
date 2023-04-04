<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\CategoryController;


Route::get('/index', [IndexController::class, 'index'])->name('admin');

Route::group(['as' => 'dashboard.'], function () {
    //Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/{setting}/update', [SettingController::class, 'update'])->name('settings.update');
    //EndSettings
    //Categories
    Route::get('categories/ajax', [CategoryController::class, 'getAll'])->name('categories.getall');
    Route::delete('categories/delete',[CategoryController::class , 'delete'])->name('categories.delete');
    Route::resource('categories', CategoryController::class)->except('destroy', 'create', 'show');
    //EndCategories
    //Products
    Route::get('products/ajax',[ProductController::class , 'getall'])->name('products.getall');
    Route::delete('products/delete',[ProductController::class , 'delete'])->name('products.delete');
    Route::resource('products', ProductController::class)->except('destroy');
    //EndProducts
});

