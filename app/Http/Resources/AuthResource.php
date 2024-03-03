<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $user = $this->load(['role']);

      return [
        'name' => $user->name,
        'email' => $user->is_verified ? $user->email : $user->masked_email,
        'avatar' => $user->avatar,
        'role' => RoleResource::make($user->role),
        'is_verified' => $user->is_verified,
      ];
    }
}
