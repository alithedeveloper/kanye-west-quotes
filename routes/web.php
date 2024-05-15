<?php

use App\Http\Controllers\QuotesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// This should really be in the api.php file, but for the sake of simplicity, we'll keep it here.
Route::prefix('api')->group(function () {
    Route::get('/quotes', QuotesController::class);
});
