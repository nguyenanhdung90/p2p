<?php

use App\Http\Controllers\PusherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/getPusher', [PusherController::class, 'getPusher']);
Route::get('/getEchoPusher', [PusherController::class, 'getEchoPusher']);
Route::get('/pusher', [PusherController::class, 'pusher']);


