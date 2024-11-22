<?php

use App\Http\Controllers\P2PController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/mapPairCoinFiats', [P2PController::class, 'mapPairCoinFiatsExample']);
Route::post('/createPairCoinFiat', [P2PController::class, 'createPairCoinFiatExample']);
Route::post('/deletePairCoinFiat', [P2PController::class, 'deletePairCoinFiatExample']);
Route::get('/getPairCoinFiatBy', [P2PController::class, 'getPairCoinFiatByExample']);
