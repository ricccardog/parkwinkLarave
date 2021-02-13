<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('cars', 'App\Http\Controllers\CarController@getAllCars');
Route::get('cars/collectionSize', 'App\Http\Controllers\CarController@getCollectionSize');
Route::get('cars/{id}', 'App\Http\Controllers\CarController@getCar');
Route::post('cars', 'App\Http\Controllers\CarController@createCar');
Route::put('cars/{id}', 'App\Http\Controllers\CarController@updateCar');
Route::delete('cars/{id}', 'App\Http\Controllers\CarController@deleteCar');

Route::get('customers', 'App\Http\Controllers\CustomerController@getAllCustomers');
Route::get('customers/{id}', 'App\Http\Controllers\CustomerController@getCustomer');
Route::post('customers', 'App\Http\Controllers\CustomerController@createCustomer');
Route::put('customers/{id}', 'App\Http\Controllers\CustomerController@updateCustomer');
Route::delete('customers/{id}', 'App\Http\Controllers\CustomerController@deleteCustomer');

Route::get('rentals', 'App\Http\Controllers\RentalController@getAllRentals');
Route::get('rentals/{id}', 'App\Http\Controllers\RentalController@getRental');
Route::post('rentals', 'App\Http\Controllers\RentalController@createRental');
Route::put('rentals/{id}', 'App\Http\Controllers\RentalController@updateRental');
Route::delete('rentals/{id}', 'App\Http\Controllers\RentalController@deleteRental');
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
