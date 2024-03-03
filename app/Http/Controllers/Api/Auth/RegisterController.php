<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Logs\LoginAttempt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
      // Create User with 6 digit verification code
      $user_details = array_merge($request->validated(), [
        'role_id' => Role::USER,
        'password' => Hash::make($request->password),
        'verification_code' => rand(100000, 999999)
      ]);

      $user = User::create($user_details);

      if ($user) {
        // Send email verification
        event(new Registered($user));

        // Log login attempt
        LoginAttempt::log([
          'ip_address' => $request->ip(),
          'user_agent' => $request->userAgent(),
          'username' => $user->username,
          'success' => true,
        ]);

        // Create token
        $token = $user->createToken(config('sanctum.token_name'))->plainTextToken;

        return response()->json([
          'access_token' => $token,
        ]);
      }

      return null;
    }
}
