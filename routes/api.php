<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuideController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\ScopeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// === Passport OAuth routes ===
Route::group(['prefix' => 'oauth', 'middleware' => ['api']], function () {
    Route::post('/token', [AccessTokenController::class, 'issueToken']);
    Route::get('/tokens', [AuthorizedAccessTokenController::class, 'forUser']);
    Route::delete('/tokens/{token_id}', [AuthorizedAccessTokenController::class, 'destroy']);
    Route::get('/clients', [ClientController::class, 'forUser']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::put('/clients/{client_id}', [ClientController::class, 'update']);
    Route::delete('/clients/{client_id}', [ClientController::class, 'destroy']);
    Route::get('/scopes', [ScopeController::class, 'all']);
    Route::get('/personal-access-tokens', [PersonalAccessTokenController::class, 'forUser']);
    Route::post('/personal-access-tokens', [PersonalAccessTokenController::class, 'store']);
    Route::delete('/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy']);
});

Route::post('/auth/register', [RegisterController::class, 'store']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/guides', [GuideController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
});
