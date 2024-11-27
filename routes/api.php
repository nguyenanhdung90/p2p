<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankTransferDetailController;
use App\Http\Controllers\P2pAdController;
use App\Http\Controllers\P2pTransactionController;
use App\Http\Controllers\PairCoinFiatController;
use App\Http\Controllers\AppealController;
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

    Route::post('/updatePairCoinFiat', [PairCoinFiatController::class, 'update']);
    Route::post('/deletePairCoinFiat', [PairCoinFiatController::class, 'delete']);
    Route::get('/getPairCoinFiat', [PairCoinFiatController::class, 'getBy']);
    Route::get('/getAttributeCoinFiat', [PairCoinFiatController::class, 'getAttribute']);

    Route::post('/createP2pAd', [P2pAdController::class, 'create']);

    Route::post('/createP2pTransaction', [P2pTransactionController::class, 'create']);
    Route::post('/partnerTransferStatus', [P2pTransactionController::class, 'partnerTransfer']);
    Route::post('/successTransfer', [P2pTransactionController::class, 'successTransfer']);

    Route::post('/createBankTransferDetail', [BankTransferDetailController::class, 'create']);
    Route::post('/updateBankTransferDetail', [BankTransferDetailController::class, 'update']);
    Route::get('/getOwnTransferDetail', [BankTransferDetailController::class, 'getOwn']);

    Route::post('/createAppeal', [AppealController::class, 'create']);
});

Route::post('/login', [AuthController::class, 'login']);





