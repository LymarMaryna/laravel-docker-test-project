<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::get('/currencies', [CurrencyController::class, 'index']);
Route::get('/currencies/{identifier}', [CurrencyController::class, 'show']);

Route::post('/issue-token', [AuthController::class, 'issueToken']);


