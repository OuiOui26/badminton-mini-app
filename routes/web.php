<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return redirect()->route('payments.index');
});

Route::resource('payments', PaymentController::class);
