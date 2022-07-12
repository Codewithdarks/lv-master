<?php

use App\Http\Controllers\ApiController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('checkout', [ApiController::class, 'GetPaymentCredentials']);
Route::get('thankyou', [ApiController::class, 'GetThankyouCredentials']);
Route::get('configsetting', [ApiController::class, 'GetConfigSettings']);
Route::post('order/fetch', [ApiController::class, 'FetchOrderInDB']);
Route::post('order/create', [ApiController::class, 'CreateOrderInDB']);
Route::post('order/update', [ApiController::class, 'UpdateOrderInDB']);
Route::get('getcountrylist',[ApiController::class, 'CountriesResponse']);
Route::post('singleupdnsell',[ApiController::class, 'SingleupdnsellResponse']);
Route::post('countrystatelist',[ApiController::class, 'StatesResponse']);