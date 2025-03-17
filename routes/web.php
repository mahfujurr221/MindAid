<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AppoinmentController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\DesignationController;
use App\Http\Controllers\Backend\DoctorController;
use App\Http\Controllers\Backend\PatientController;
use App\Http\Controllers\Backend\PaymentController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;

//backend
Route::middleware('auth')->prefix('back')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    //about
    Route::resource('about-us', AboutController::class)->except(['show']);
    //designations
    Route::resource('designations', DesignationController::class)->except(['show']);

    //departments
    Route::resource('departments', DepartmentController::class)->except(['show']);

    //patients
    Route::resource('patients', PatientController::class)->except(['show']);

    //doctors
    Route::resource('doctors', DoctorController::class)->except(['show']);

    //appointment
    Route::resource('appointments', AppoinmentController::class)->except(['show']);

    Route::post('/appointments-meetings/{id}/update-status', [AppoinmentController::class, 'updateStatus'])->name('appointments.update-status');


    Route::get('appointments/authorize', [AppoinmentController::class, 'redirectToappointments'])->name('appointments.authorize');
    Route::get('appointments/callback', [AppoinmentController::class, 'handleCallback'])->name('appointments.callback');
    Route::post('appointments/create-meeting', [AppoinmentController::class, 'createMeeting'])->name('appointments.create-meeting');

    Route::post('appointments/store-prescription', [AppoinmentController::class, 'storePrescription'])->name('appointments.store-prescription');
    Route::post('appointments/store-test', [AppoinmentController::class, 'storeTest'])->name('appointments.store-test');

    // Prescription and Test Routes
    Route::get('appointments/{appointment}/prescriptions', [AppoinmentController::class, 'showPrescriptions'])->name('appointments.prescription');
    Route::get('appointments/{appointment}/tests', [AppoinmentController::class, 'showTests'])->name('appointments.test');
    
    //canceled appointments
    Route::get('appointments/canceled', [AppoinmentController::class, 'canceledAppointments'])->name('appointments.canceled');

    //payments
    Route::resource('payments', PaymentController::class)->except(['show']);

    // payments update-status
    Route::post('/payments-meetings/{id}/update-status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');

    ///////////////////////////// Roles And Permission Route ///////////////////////////////////
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class)->except(['create', 'show', 'edit']);
    Route::get('roles/permissions/{id}', [RoleController::class, 'addPermissionToRole'])->name('role.permissions');
    Route::put('roles/permissions/{id}', [RoleController::class, 'addPermissionToRoleUpdate'])->name('role-permissions.update');

    ///////////////////////////// User and Profile Route ///////////////////////////////////
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile-reset', [ProfileController::class, 'reset'])->name('profile.reset');
    Route::put('/profile-update', [ProfileController::class, 'update'])->name('profile.update');

    ///////////////////////////// Settings Route ///////////////////////////////////
    Route::resource('settings', SettingController::class)->except(['show', 'edit', 'create', 'destroy']);
});


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "All caches are cleared";
});


require __DIR__ . '/front.php';
require __DIR__ . '/auth.php';
