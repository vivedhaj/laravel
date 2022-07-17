<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/login', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/quotes', [QuoteController::class, 'getQuotes']);
    Route::get('/logout', [LoginController::class, 'logout']);
});

Route::post('/login', [LoginController::class, 'index']);
Route::get('/load-quotes', [QuoteController::class, 'loadQuotes']);

