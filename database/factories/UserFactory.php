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
      return [
        'last_name' => fake()->lastName(),
        'first_name' => fake()->firstName(),
        'username' => fake()->unique()->userName(),
        'role_id' => Role::USER,
        'email' => fake()->unique()->safeEmail(),
        'password' => Hash::make('password'),
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
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
