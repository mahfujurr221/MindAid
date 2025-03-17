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
    Route::get('/doctor', [HomeController::class, 'showDoctorProfile'])->name('front.doctor-profile');

    //book-appointment
    Route::middleware('auth')->get('/book-appointment', [HomeController::class, 'bookAppointment'])->name('front.book-appointment');
    Route::middleware('auth')->get('/appointments', [HomeController::class, 'appointment'])->name('front.appointment');
    Route::middleware('auth')->get('/appointments/favorites', [HomeController::class, 'favorites'])->name('front.favorites');
    Route::middleware('auth')->get('/appointments/chat', [HomeController::class, 'chat'])->name('front.chat');

    Route::post('appointments/store-session', [HomeController::class, 'storeSession'])->name('appointments.store-session');
    //checkout
    Route::get('appointments/checkout', [HomeController::class, 'checkout'])->name('appointments.checkout');
    //dueCheckout
    Route::get('appointments/due-checkout/{id}', [HomeController::class, 'dueCheckout'])->name('appointments.due-checkout');
    Route::post('appointments/process-payment', [HomeController::class, 'processPayment'])->name('appointments.process-payment');
    Route::put('appointments/update-payment/{id}', [HomeController::class, 'updatePayment'])->name('appointments.update-payment');


    //contact-us
    Route::post('/contact-us', [HomeController::class, 'contactStore'])->name('front.contact-us');
});
