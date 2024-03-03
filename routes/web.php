<?php

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Preview of Mails
Route::prefix('preview-email')->group(function () {
  Route::get('verify', function () {
    $user = User::find(1);

    return (new VerifyEmail($user->verification_code))->toMail($user);
  });
});

// SPA Route
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');


