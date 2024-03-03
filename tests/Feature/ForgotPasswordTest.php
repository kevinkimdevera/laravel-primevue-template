<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends TestCase
{
    public function test_failed_forgot_password_request()
    {
      $response = $this->postJson(route('api.auth.password.forgot'), [
        'email' => null
      ]);

      $response->assertStatus(422);
      $response->assertJsonValidationErrors(['email']);
    }

    public function test_failed_forgot_password_request_with_non_existing_email()
    {
      $response = $this->postJson(route('api.auth.password.forgot'), [
        'email' => 'dummy-email@dummyemail.com'
      ]);

      $response->assertStatus(422);
      $response->assertJsonValidationErrors(['email']);
    }

    public function test_success_forgot_password_request()
    {
      $user = User::factory()->user()->verified()->create();

      $response = $this->postJson(route('api.auth.password.forgot'), [
        'email' => $user->email
      ]);

      $response->assertStatus(200);
      $response->assertJsonStructure([
        'message'
      ]);
    }
}
