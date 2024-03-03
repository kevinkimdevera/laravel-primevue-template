<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerificationRequest;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
  public function verify (VerificationRequest $request) {
    // Verify email
    $user = $request->user();

    $message = null;
    $code = 200;

    if ($user) {
      if ($user->is_verified) {
        $message = 'User already verified';
        $code = 403;
      }
      else {
        if ($user->checkVerificationCode($request->code)) {
          if ($user->markEmailAsVerified()) {
            $message = 'Email verified successfully';
          } else {
            $message = 'Email verification failed';
          }
        } else {
          $message = 'Invalid verification code';
          $code = 422;
        }
      }
    } else {
      $message = 'Unauthenticated';
      $code = 401;
    }

    return response()->json([
      'message' => $message,
    ], $code);
  }
}
