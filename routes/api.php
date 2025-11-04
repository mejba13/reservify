<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ProviderController;
use Illuminate\Support\Facades\Route;

/**
 * API Routes for Reservify Booking System
 *
 * All routes are prefixed with /api and return JSON responses.
 * Authentication is handled via Laravel Sanctum.
 */

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
|
| These routes are accessible without authentication.
|
*/

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Public Services & Availability
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);
Route::get('/availability', [AvailabilityController::class, 'index']);
Route::get('/availability/{provider}', [AvailabilityController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected Customer API Routes
|--------------------------------------------------------------------------
|
| These routes require authentication and are for customers.
|
*/

Route::middleware('auth:sanctum')->group(function () {

    // Customer Profile Routes
    Route::prefix('customer')->group(function () {
        Route::get('/profile', [CustomerController::class, 'profile']);
        Route::patch('/profile', [CustomerController::class, 'updateProfile']);
        Route::get('/bookings', [CustomerController::class, 'bookings']);
        Route::get('/notifications', [CustomerController::class, 'notifications']);
    });

    // Booking Routes
    Route::prefix('bookings')->group(function () {
        Route::post('/', [BookingController::class, 'store']);
        Route::get('/', [BookingController::class, 'index']);
        Route::get('/{booking}', [BookingController::class, 'show']);
        Route::patch('/{booking}', [BookingController::class, 'update']);
        Route::delete('/{booking}', [BookingController::class, 'destroy']);
        Route::post('/{booking}/cancel', [BookingController::class, 'cancel']);
        Route::post('/{booking}/reschedule', [BookingController::class, 'reschedule']);
    });
});

/*
|--------------------------------------------------------------------------
| Protected Admin/Provider API Routes
|--------------------------------------------------------------------------
|
| These routes require authentication and admin/provider role.
|
*/

Route::middleware(['auth:sanctum', 'role:admin,provider'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ProviderController::class, 'dashboard']);

    // Booking Management
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'adminIndex']);
        Route::patch('/{booking}/approve', [BookingController::class, 'approve']);
        Route::patch('/{booking}/complete', [BookingController::class, 'complete']);
    });

    // Customer Management
    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);

    // Service Management
    Route::post('/services', [ServiceController::class, 'store']);
    Route::patch('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

    // Availability Management
    Route::prefix('availability')->group(function () {
        Route::post('/bulk', [AvailabilityController::class, 'bulkStore']);
        Route::patch('/{availability}', [AvailabilityController::class, 'update']);
        Route::delete('/{availability}', [AvailabilityController::class, 'destroy']);
    });

    // Analytics & Reporting
    Route::get('/analytics', [ProviderController::class, 'analytics']);
    Route::get('/revenue', [ProviderController::class, 'revenue']);
});
