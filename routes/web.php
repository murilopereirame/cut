<?php

use App\Http\Controllers\ShortenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::get('/{code}', [ShortenController::class, 'retrieve_url']);
