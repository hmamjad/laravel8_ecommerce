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

Route::get('/login', function () {
    return redirect()->to('/');
})->name('login');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/customer/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('customer.logout');



// Frontend All Routes
Route::group(['namespace' => 'App\Http\Controllers\Front'], function () {

    Route::get('/', 'IndexController@index');
    Route::get('/product-details/{slug}', 'IndexController@ProductDetails')->name('product.details');

    // Review
    Route::post('/store/review', 'ReviewController@store')->name('store.review');
    // Wishlist
    Route::get('/add/wishlist/{id}', 'ReviewController@AddWishlist')->name('add.wishlist');
    // product-quick-view
    Route::get('/product-quick-view/{id}', 'IndexController@ProductQuickView');
    // Add to cart
    Route::get('/my-cart', 'CartController@MyCart')->name('cart');
    Route::post('/addtocart', 'CartController@addTocartQV')->name('add.to.cart.quickview');
});

Route::get('/cart/destroy',function(){
    Cart::destroy();
});
