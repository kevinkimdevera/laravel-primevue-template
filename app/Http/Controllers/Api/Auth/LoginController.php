<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Logs\LoginAttempt;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
  public function __invoke(LoginRequest $request)
  {
    $user = User::ofUsername($request->username)
      ->first();

    if ($user && $user->checkPassword($request->password)) {
      LoginAttempt::log([
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'username' => $request->username,
        'success' => true,
      ]);

      $token = $user->createToken(config('sanctum.token_name'))->plainTextToken;

      return response()->json([
        'access_token' => $token,
      ]);
    }
    else {
      LoginAttempt::log([
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'username' => $request->username,
        'password' => $request->password,
        'success' => false,
      ]);

      return response()->json([
        'errors' => [
          'username' => ["These credentials didn't match our records."]
        ]
      ], 401);
    }
  }
}
