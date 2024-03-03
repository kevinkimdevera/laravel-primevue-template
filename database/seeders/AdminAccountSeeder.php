<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class AdminAccountSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::create([
      'role_id' => Role::ADMIN,
      'last_name' => 'Admin',
      'first_name' => 'Admin',
      'middle_name' => 'Admin',
      'username' => 'admin',
      'email' => 'admin@email.com',
      'password' => Hash::make('@Password_123'),
      'email_verified_at' => now(),
    ]);
  }
}
