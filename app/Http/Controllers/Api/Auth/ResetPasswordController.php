<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ResetPasswordRequest $request)
    {
      $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ]);

            $user->save();

            event(new PasswordReset($user));
        }
      );

      return $status === Password::PASSWORD_RESET
        ? response()->json(['message' => __($status)], 200)
        : response()->json(['message' => __($status)], 500);
    }
}
