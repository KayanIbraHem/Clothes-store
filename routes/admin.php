<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\SettingController;



Route::get('/index', [IndexController::class, 'index'])->name('admin');
Route::get('settings',[SettingController::class , 'index'])->name('dashboard.settings.index');
Route::put('settings/{setting}/update',[SettingController::class , 'update'])->name('dashboard.settings.update');
