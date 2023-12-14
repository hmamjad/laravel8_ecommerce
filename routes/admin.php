<?php

use Illuminate\Support\Facades\Route;


Route::get('/admin-login', [App\Http\Controllers\Auth\LoginController::class, 'adminlogin'])->name('admin.login');


Route::group(['namespace'=>'App\Http\Controllers\Admin','middleware'=>'is_admin'],function(){
    Route::get('/admin/home', 'AdminController@admin')->name('admin.home');
    Route::get('/admin/logout', 'AdminController@logout')->name('admin.logout');

    // Category route
    Route::group(['prefix'=>'category'],function (){
        Route::get('/admin/logout', 'CategoryController@index')->name('category.index');
    });
    
});
