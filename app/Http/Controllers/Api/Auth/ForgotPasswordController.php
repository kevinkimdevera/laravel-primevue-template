<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
      // Send Reset Link
      $status = Password::sendResetLink([
        'email' => $request->email,
      ]);

      // Return Response
      return $status === Password::RESET_LINK_SENT
        ? response()->json(['message' => __($status)], 200)
        : response()->json(['message' => __($status)], 500);
    }
}
