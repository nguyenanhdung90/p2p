<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankTransferDetailController;
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
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);


Route::post('/mapPairCoinFiats', [P2PController::class, 'mapPairCoinFiats']);
Route::post('/createPairCoinFiat', [P2PController::class, 'createPairCoinFiat']);
Route::post('/deletePairCoinFiat', [P2PController::class, 'deletePairCoinFiat']);
Route::get('/getPairCoinFiatBy', [P2PController::class, 'getPairCoinFiatBy']);

Route::post('/createP2pAd', [P2PController::class, 'createP2pAd']);

Route::post('/createBankTransferDetail', [BankTransferDetailController::class, 'createBankTransferDetail']);
Route::post('/updateBankTransferDetail', [BankTransferDetailController::class, 'updateBankTransferDetail']);


