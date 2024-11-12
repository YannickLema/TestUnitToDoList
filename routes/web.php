<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/calculator/add/{a}/{b}', [CalculatorController::class, 'add']);
