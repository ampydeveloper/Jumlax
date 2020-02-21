<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ChatterController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('invite-vendor', [DashboardController::class, 'inviteVendor'])->name('inviteVendor');
Route::post('invite-vendor', [DashboardController::class, 'inviteVendorPost'])->name('inviteVendor.post');

//add charter
Route::get('charter-plane', [ChatterController::class, 'charterPlane'])->name('charter-plane');
Route::get('charter-plane-add', [ChatterController::class, 'addCharterPlane'])->name('charter-plane-add');
Route::post('charter-plane-save', [ChatterController::class, 'saveCharterPlane'])->name('charter-plane-save');
Route::get('charter-plane-edit/{id}', [ChatterController::class, 'editCharterPlane'])->name('charter-plane-edit');
Route::patch('charter-plane-update/{id}', [ChatterController::class, 'updateCharterPlane'])->name('charter-plane-update');
Route::get('charter-plane-delete/{id}', [ChatterController::class, 'deleteCharterPlane'])->name('charter-plane-delete');

//add charter plane details 
Route::get('flight-details', [ChatterController::class, 'flightDetails'])->name('flight-details');
Route::get('flight-details-add', [ChatterController::class, 'addFlightDetails'])->name('flight-details-add');
Route::post('flight-details-save', [ChatterController::class, 'saveFlightDetails'])->name('flight-details-save');
Route::get('flight-details-edit/{id}', [ChatterController::class, 'editFlightDetails'])->name('flight-details-edit');
Route::patch('flight-details-update/{id}', [ChatterController::class, 'updateFlightDetails'])->name('flight-details-update');
Route::get('flight-details-delete/{id}', [ChatterController::class, 'deleteFlightDetails'])->name('flight-details-delete');

//add charter details
Route::get('charter-details', [ChatterController::class, 'charterDetails'])->name('charter-details');
//Route::get('add-charter-details', [ChatterController::class, 'addcharterDetails'])->name('add-charter-details');
//Route::post('save-charter-details', [ChatterController::class, 'savecharterDetails'])->name('save-charter-details');
Route::get('edit-charter-details/{id}', [ChatterController::class, 'editcharterDetails'])->name('edit-charter-details');
Route::patch('update-charter-details/{id}', [ChatterController::class, 'updatecharterDetails'])->name('update-charter-details');
//Route::get('delete-charter-details/{id}', [ChatterController::class, 'deletecharterDetails'])->name('delete-charter-details');

Route::get('charter-booking', [ChatterController::class, 'charterBooking'])->name('charter-booking');
Route::get('charter-booking-details/{id}', [ChatterController::class, 'charterBookingDetails'])->name('charter-booking-details');
Route::get('download-pdf/{fileName}', [ChatterController::class, 'download_pdf'])->name('download-pdf');
