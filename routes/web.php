<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return Inertia::render('welcome');
});

Route::get('/vue-page', function () {
    return Inertia::render('VuePage');
});