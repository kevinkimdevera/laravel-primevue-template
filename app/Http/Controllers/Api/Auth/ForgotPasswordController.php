<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\ForgotPasswordRequest;

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
      $status_code = $status === Password::RESET_LINK_SENT
        ? 200
        : 500;

      return response()->json(['message' => __($status)], $status_code);
    }
}
