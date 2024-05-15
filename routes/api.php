<?php


use App\Http\Controllers\QuotesController;
use App\Http\Controllers\RefreshQuotesController;
use Illuminate\Support\Facades\Route;

Route::get('/quotes', QuotesController::class);
Route::get('/quotes/refresh', RefreshQuotesController::class);
