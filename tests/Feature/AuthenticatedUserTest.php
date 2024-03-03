<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AuthenticatedUserTest extends TestCase
{
  use RefreshDatabase;

  public function test_unauthorized_user_cannot_access_protected_routes()
  {
    $response = $this->getJson(route('api.auth.user.show'));
    $response->assertStatus(401);
  }

  public function test_authenticated_user_can_get_user_data()
  {
    $user = User::factory()->user()->verified()->create();
    $this->actingAs($user);

    $response = $this->getJson(route('api.auth.user.show'));
    $response->assertStatus(200)
      ->assertJson([
        'data' => [
          'name' => $user->name,
          'email' => $user->email,
          'avatar' => $user->avatar,
          'role' => [
            'id' => $user->role->id,
            'name' => $user->role->name,
          ],
        ]
      ]);
  }
}
