<?php

use Illuminate\Support\Facades\Route;


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/check',function(){
    echo "Admin Route";
});
