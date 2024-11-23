<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankTransferDetailController;
use App\Http\Controllers\P2pAdController;
use App\Http\Controllers\P2PController;
use App\Http\Controllers\PairCoinFiatController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/updatePairCoinFiat', [PairCoinFiatController::class, 'updatePairCoinFiat']);
    Route::post('/deletePairCoinFiat', [PairCoinFiatController::class, 'deletePairCoinFiat']);
    Route::get('/getPairCoinFiatBy', [PairCoinFiatController::class, 'getPairCoinFiatBy']);

    Route::post('/createP2pAd', [P2pAdController::class, 'createP2pAd']);

    Route::post('/createBankTransferDetail', [BankTransferDetailController::class, 'createBankTransferDetail']);
    Route::post('/updateBankTransferDetail', [BankTransferDetailController::class, 'updateBankTransferDetail']);
});

Route::post('/login', [AuthController::class, 'login']);





