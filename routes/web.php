<?php

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





Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Frontend All Routes
Route::group(['namespace' => 'App\Http\Controllers\Front'], function () {

Route::get('/','IndexController@index');

});



Route::get('/frontend/product', function () {
    return view('frontend.product_details');
});