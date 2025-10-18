<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuideController;
use Illuminate\Support\Facades\Route;

Route::get('/guides', [GuideController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
