<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlayerController;

Route::get('/', function () {
    return Inertia::render('MainPage');
})->name('home');

Route::resource('payments', PaymentController::class);
Route::resource('players', PlayerController::class);
