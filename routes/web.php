<?php

use Illuminate\Support\Facades\Route;

/**
 * Web routes for Reservify API-First Booking System
 *
 * This file contains minimal web routes as the application is API-first.
 * The Vue.js SPA will be served from the root route, and all functionality
 * is handled through API routes defined in routes/api.php
 */

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
