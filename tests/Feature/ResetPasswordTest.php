<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
  // Test Failed Validation on Reset Password Request
  public function test_failed_validation_on_reset_password () {
    $response = $this->postJson(route('api.auth.password.reset'), [
      'token' => null,
      'email' => null,
      'password' => null,
      'password_confirmation' => null,
    ]);

    $response->assertStatus(422);

    $response->assertJsonValidationErrors([
      'token', 'email', 'password',
    ]);

    // Test Password Validation
    $response = $this->postJson(route('api.auth.password.reset'), [
      'token' => Str::random(),
      'email' => 'email@test.com',
      'password' => 'password',
      'password_confirmation' => 'password1234',
    ]);

    $response->assertStatus(422);

    $response->assertJsonValidationErrors([
      'password',
    ]);

    // Test Password Validation: min 8 characters
    $response = $this->postJson(route('api.auth.password.reset'), [
      'token' => Str::random(),
      'email' => 'email@test.com',
      'password' => 'pass',
      'password_confirmation' => 'pass',
    ]);

    $response->assertStatus(422);

    $response->assertJsonValidationErrors([
      'password',
    ]);

    // Test Password Validation: one uppercase character, one lowercase character, one number, and one symbol
    $response = $this->postJson(route('api.auth.password.reset'), [
      'token' => Str::random(),
      'email' => 'email@test.com',
      'password' => 'password',
      'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);

    $response->assertJsonValidationErrors([
      'password',
    ]);
  }

  // Test Failed Reset Password Request
  // Not existing token
  public function test_invalid_reset_token () {
    $response = $this->postJson(route('api.auth.password.reset'), [
      'token' => Str::random(),
      'email' => 'test@email.com',
      'password' => '@Password_1234',
      'password_confirmation' => '@Password_1234',
    ]);

    $response->assertStatus(500);
  }

  // Test Success Reset Password Request
  public function test_success_reset_password () {
    $user = User::factory()->user()->verified()->create();

    $token = Password::createToken($user);

    $response = $this->postJson(route('api.auth.password.reset'), [
      'token' => $token,
      'email' => $user->email,
      'password' => '@Password_1234',
      'password_confirmation' => '@Password_1234',
    ]);

    $response->assertStatus(200);

    // Assert Password Changed
    $this->assertDatabaseHas('users', [
      'id' => $user->id,
      'email' => $user->email,
    ]);

    $this->assertTrue(Hash::check('@Password_1234', $user->fresh()->password));
  }

}
