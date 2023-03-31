<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\CategoryController;


Route::get('/index', [IndexController::class, 'index'])->name('admin');

Route::group(['as' => 'dashboard.'], function () {
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/{setting}/update', [SettingController::class, 'update'])->name('settings.update');
    Route::get('categories/ajax', [CategoryController::class, 'getAll'])->name('categories.getall');
    Route::delete('categories/delete',[CategoryController::class , 'delete'])->name('categories.delete');
    Route::resource('categories', CategoryController::class)->except('destroy', 'create', 'show');
});
