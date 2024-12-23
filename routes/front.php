<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

////////////////////////////// Frontend Route ///////////////////////////////////
Route::get('/', [HomeController::class, 'front_index'])->name('website');

Route::prefix('home')->group(function () {
    Route::get('/about', [HomeController::class, 'about'])->name('front.about');
    Route::get('/contact', [HomeController::class, 'contact'])->name('front.contact');

    //doctors
    Route::get('/doctors', [HomeController::class, 'doctor'])->name('front.doctor');
    
    //contact-us
    Route::post('/contact-us', [HomeController::class, 'contactStore'])->name('front.contact-us');
});