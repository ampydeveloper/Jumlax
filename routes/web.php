<?php

use App\Http\Controllers\LanguageController;
use App\Models\Bookings;

/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});



 
// amadeus controller and route
//Route::get('/frontend.index', 'AmadeusController@getAirPortListing')->name('frontend.index');
Route::get('/', 'AmadeusController@getAirPortListing')->name('frontend.index');

Route::post('/get-lisit', 'AmadeusController@getAirPortListing');

//charter from list
Route::post('/get-charter-from-lisit', 'AmadeusController@getCharterFromListing');
Route::post('/get-charter-to-lisit', 'AmadeusController@getCharterToListing');

//save airports details
Route::post('/save-airport', 'AmadeusController@saveAirport');

Route::get('/flight-search/{passenger_class}/{flight_type}/{from}/{to}/{departure}/{return}/{passenger_adult}/{passenger_child}/{passenger_infant}/{popular_destination}', 'AmadeusController@getFlightListing');
Route::get('/flight-search-listing', 'AmadeusController@getFlightListingView');

Route::post('/most-search', 'AmadeusController@mostTraveledSearch');

//Route::get('/contact', 'AmadeusController@getContact');

Route::post('/charter-search', 'CharterPlaneController@getCharterListing');

//Route::post('/fake', 'AmadeusController@getPDF');

Route::get('mailable', function () {
    $booking = Bookings::find(1);

    return new App\Mail\Frontend\Flight\FlightBooked($booking);
});