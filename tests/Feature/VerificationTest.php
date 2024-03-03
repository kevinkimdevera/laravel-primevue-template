<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerificationTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  public function test_guest_cannot_verify_email()
  {
    $response = $this->postJson(route('api.auth.email.verify'));
    $response->assertStatus(401);
  }

  public function test_verified_user_cannot_verify_email()
  {
    $user = User::factory()->user()->verified()->create();

    $response = $this->actingAs($user)->postJson(route('api.auth.email.verify'), [
      'code' => $user->verification_code
    ]);

    $response->assertStatus(403)
      ->assertJson([
        'message' => 'User already verified',
      ]);
  }

  public function test_verification_failed_form_validation ()
  {
    $user = User::factory()->user()->unverified()->create();

    $response = $this->actingAs($user)->postJson(route('api.auth.email.verify'));
    $response->assertStatus(422);

    $response = $this->actingAs($user)->postJson(route('api.auth.email.verify'), [
      'code' => '123',
    ]);

    $response->assertStatus(422)
      ->assertJsonStructure([
        'errors' => [
          'code',
        ],
      ]);
  }

  public function test_verification_failed_with_invalid_code ()
  {
    $user = User::factory()->user()->unverified()->create([
      'verification_code' => 123456,
    ]);

    $response = $this->actingAs($user)->postJson(route('api.auth.email.verify'), [
      'code' => '654321',
    ]);

    $response->assertStatus(422)
      ->assertJson([
        'message' => 'Invalid verification code',
      ]);
  }

  public function test_verification_success ()
  {
    $user = User::factory()->user()->unverified()->create();

    // Check user api if is_verified is false
    $userResponse = $this->actingAs($user)->getJson(route('api.auth.user.show'));
    $userResponse->assertStatus(200)
      ->assertJson([
        'data' => [
          'is_verified' => false,
        ]
      ]);

    $response = $this->actingAs($user)->postJson(route('api.auth.email.verify'), [
      'code' => $user->verification_code,
    ]);

    $response->assertStatus(200)
      ->assertJson([
        'message' => 'Email verified successfully',
      ]);

    // Check user api if is_verified is true
    $userResponse = $this->actingAs($user)->getJson(route('api.auth.user.show'));
    $userResponse->assertStatus(200)
      ->assertJson([
        'data' => [
          'is_verified' => true,
        ]
      ]);
  }

}
