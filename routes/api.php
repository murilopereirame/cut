<?php

use App\Http\Controllers\ShortenController;
use Illuminate\Support\Facades\Route;
Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return response()->redirectToRoute('up');
    });
    Route::get('/up', function () {
        return response()->json([
            "status" => "SUCCESS",
            "time" => \Carbon\Carbon::now()->toDateTimeString(),
            "response_time" => round((microtime(true) - LARAVEL_START) * 1000)
        ]);
    })->name('up');
    Route::controller(ShortenController::class)->prefix('shorten')->group(function () {
       Route::post('short', 'short_url');
    });
});

Route::any('/', function () {return response()->redirectTo('/');});
Route::fallback(function () {return response()->redirectTo('/');});
