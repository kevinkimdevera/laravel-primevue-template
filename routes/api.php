<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.')->group(function () {

  // LOGIN
  Route::prefix('auth')->name('auth.')->group(function () {
    // Login Route
    Route::post('login', LoginController::class)->name('login');
  });

  // AUTHENTICATED ROUTES
  Route::middleware(['auth:sanctum'])->group(function () {

    // Authenticated User Routes
    Route::prefix('auth')->name('auth.')->group(function () {
      // Get User Info
      Route::get('user', [ UserController::class, 'show' ])->name('user.show');
    });

    // Place all authenticated routes here
    // ...
  });
});
