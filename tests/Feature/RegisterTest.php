<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use WithFaker;

    use RefreshDatabase;

    public function test_register_failed_with_no_data() {
      $response = $this->postJson(route('api.auth.register'));
      $response->assertStatus(422);
    }

    public function test_register_failed_on_password_mismatch() {
      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => 'test@email.com',
        'password' => 'password',
        'password_confirmation' => 'mismatch-password',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'password',
          ],
        ]);
    }

    public function test_register_failed_on_invalid_email() {
      $response = $this->postJson(route('api.auth.register'), [
          'first_name' => $this->faker->firstName,
          'last_name' => $this->faker->lastName,
          'email' => 'invalid-email',
          'password' => 'password',
          'password_confirmation' => 'password',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'email',
          ],
        ]);
    }

    public function test_register_failed_on_existing_email () {
      $user = User::factory()->user()->verified()->create();

      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $user->email,
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'email',
          ],
        ]);
    }

    public function test_register_failed_on_existing_username () {
      $user = User::factory()->user()->verified()->create();

      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'username' => $user->username,
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'username',
          ],
        ]);
    }

    public function test_register_failed_on_password_errors () {
      // Min 8 characters
      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'password' => '1',
        'password_confirmation' => '1',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'password',
          ],
        ]);

      // Mixed Cases
      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'password' => 'password',
        'password_confirmation' => 'password',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'password',
          ],
        ]);

      // No Letters
      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'password' => '12345678',
        'password_confirmation' => '12345678',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'password',
          ],
        ]);

      // No Numbers
      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'password' => 'Password',
        'password_confirmation' => 'Password',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'password',
          ],
        ]);

      // No Symbols
      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'password' => 'Password1',
        'password_confirmation' => 'Password1',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'password',
          ],
        ]);

      // Compromised Password
      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'password' => 'Password1!',
        'password_confirmation' => 'Password1!',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'password',
          ],
        ]);

      // Not Mixed Case
      $response = $this->postJson(route('api.auth.register'), [
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'password' => 'password1!',
        'password_confirmation' => 'password1!',
      ]);

      $response->assertStatus(422)
        ->assertJsonStructure([
          'errors' => [
            'password',
          ],
        ]);
    }

    public function test_register_successful () {
      Event::fake();

      $response = $this->postJson(route('api.auth.register'), [
        'username' => $this->faker->userName,
        'first_name' => $this->faker->firstName,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->email,
        'password' => '@Password__1234',
        'password_confirmation' => '@Password__1234',
      ]);

      $response->assertStatus(200)
        ->assertJsonStructure([
          'access_token'
        ]);

      // Assert if verification code was sent
      Event::assertDispatched(Registered::class);
    }
}
