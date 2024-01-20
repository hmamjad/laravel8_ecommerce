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
    Route::get('/add/wishlist/{id}', 'CartController@AddWishlist')->name('add.wishlist');
    Route::get('/wishlist', 'CartController@wishlist')->name('wishlist');
    Route::get('/clear/wishlist', 'CartController@Clearwishlist')->name('clear.wishlist');
    Route::get('/wishlist/product/delete/{id}', 'CartController@WishlistProductdelete')->name('wishlistproduct.delete');

    // product-quick-view
    Route::get('/product-quick-view/{id}', 'IndexController@ProductQuickView');
    // Add to cart
    Route::get('/my-cart', 'CartController@MyCart')->name('cart');
    Route::post('/addtocart', 'CartController@addTocartQV')->name('add.to.cart.quickview');
    Route::get('/cartproduct/remove/{rowId}', 'CartController@RemoveProduct');
    Route::get('cartproduct/updateqty/{rowId}/{qty}', 'CartController@UpdateQty');
    Route::get('cartproduct/updatecolor/{rowId}/{color}', 'CartController@UpdateColor');
    Route::get('cartproduct/updatesize/{rowId}/{size}', 'CartController@UpdateSize');
    Route::get('/cart/empty', 'CartController@EmptyCart')->name('cart.empty');


        // Category wise products
        Route::get('/categor/product/{id}', 'IndexController@categoryWiseProduct')->name('categorywise.product');
        // Sub-Category wise products
        Route::get('/subcategorywise/product/{id}', 'IndexController@SubcategoryWiseProduct')->name('subcategorywise.product');
        // Sub-Category wise products
        Route::get('/childcategorywise/product/{id}', 'IndexController@ChildcategoryWiseProduct')->name('childcategorywise.product');


});


