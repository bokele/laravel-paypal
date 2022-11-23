<?php

use App\Http\Controllers\PaypalController;
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

Route::get('paypal-order', [PaypalController::class, 'getOrderDetails']);
Route::get('paypal-auth', [PaypalController::class, 'getAccessToken']);
Route::get('paypal-refund', [PaypalController::class, 'refund']);
