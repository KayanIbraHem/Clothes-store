<?php

use App\Http\Controllers\Dashboard\IndexController;
use Illuminate\Support\Facades\Route;



Route::get('/index', [IndexController::class, 'index'])->name('admin');
