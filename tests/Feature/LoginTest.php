<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
  use RefreshDatabase;

  public function test_login_failed_with_no_data()
  {
    $response = $this->postJson(route('api.auth.login'));
    $response->assertStatus(422);
  }

  public function test_login_failed_with_incorrect_credentials()
  {
    $user = User::factory()->user()->verified()->create();

    $response = $this->postJson(route('api.auth.login'), [
      'username' => $user->email,
      'password' => 'wrong-password',
    ]);

    $response->assertStatus(401)
      ->assertJsonStructure([
        'errors' => [
          'username',
        ],
      ]);
  }

  public function test_login_success_with_correct_credentials_using_email()
  {
    $user = User::factory()->user()->verified()->create([
      'password' => Hash::make('correct-password')
    ]);

    $response = $this->postJson(route('api.auth.login'), [
      'username' => $user->email,
      'password' => 'correct-password',
    ]);

    $response->assertStatus(200)
      ->assertJsonStructure([
        'access_token',
      ]);
  }

  public function test_login_success_with_correct_credentials_using_username()
  {
    $user = User::factory()->user()->verified()->create([
      'password' => Hash::make('correct-password')
    ]);

    $response = $this->postJson(route('api.auth.login'), [
      'username' => $user->username,
      'password' => 'correct-password',
    ]);

    $response->assertStatus(200)
      ->assertJsonStructure([
        'access_token',
      ]);
  }
}
