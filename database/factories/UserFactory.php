<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      $last_name = $this->faker->lastName();
      $first_name = $this->faker->firstName();

      // Username from first name and last name firstname.lastname
      $username = Str::of($first_name)
        ->lower()
        ->append('.')
        ->append(Str::of($last_name)->lower());

      $email = Str::of($username)
        ->append('@')
        ->append($this->faker->safeEmailDomain());

      return [
        'last_name' => $first_name,
        'first_name' => $last_name,
        'username' => $username,
        'role_id' => Role::USER,
        'email' => $email,
        'password' => Hash::make('@Password_123'),
        'verification_code' => rand(100000, 999999),
      ];
    }

    public function user () {
      return $this->state([
        'role_id' => Role::USER,
      ]);
    }

    public function admin () {
      return $this->state([
        'role_id' => Role::ADMIN,
      ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified()
    {
        return $this->state([
          'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's email address should be verified.
     */
    public function verified()
    {
        return $this->state([
            'email_verified_at' => now(),
        ]);
    }
}
