<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;

Route::get('/', [HotelController::class, 'search']);
Route::get('/results', [HotelController::class, 'results'])->name('results');