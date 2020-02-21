<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\CharterPlaneController;
/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
//Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/terms-conditions', [HomeController::class, 'terms_conditions'])->name('terms-conditions');
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('/trips', [HomeController::class, 'trips'])->name('trips');
Route::post('/review', [HomeController::class, 'review'])->name('review');
//Route::post('/traveller-details', [HomeController::class, 'traveller_details'])->name('traveller-details');
Route::get('/traveller-details', [HomeController::class, 'traveller_details'])->name('traveller-details');
Route::post('/payment', [HomeController::class, 'payment'])->name('payment'); 
Route::get('/payment/{paymentDone?}', [HomeController::class, 'paymentGet'])->name('paymentGet'); 
Route::post('/paymentDone', [HomeController::class, 'paymentDone'])->name('paymentDone'); 
Route::post('/paymentCancelled', [HomeController::class, 'paymentCancelled'])->name('paymentCancelled'); 
Route::post('/process_payment', [HomeController::class, 'process_payment'])->name('process_payment');
Route::get('/booked', [HomeController::class, 'booked'])->name('booked');


Route::post('/chartereview', [CharterPlaneController::class, 'chartereview'])->name('chartereview');
Route::get('/chartedetails', [CharterPlaneController::class, 'chartedetails'])->name('chartedetails');
Route::post('/charterpayment', [CharterPlaneController::class, 'charterpayment'])->name('charterpayment');
Route::get('/charterpayment', [CharterPlaneController::class, 'charterpaymentGet'])->name('charterpaymentGet');
Route::post('/process_payment_charter', [CharterPlaneController::class, 'process_payment'])->name('process_payment_charter');
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        // User Dashboard Specific
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('change-password', [DashboardController::class, 'changePassword'])->name('changePassword');
        Route::post('change-password', [DashboardController::class, 'changePasswordPost'])->name('changePassword.post');

        // User Account Specific
        Route::get('account', [AccountController::class, 'index'])->name('account');

        // User Profile Specific
        Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });
});
