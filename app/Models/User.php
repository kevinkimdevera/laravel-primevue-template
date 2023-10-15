<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
      'role_id',
      'last_name',
      'first_name',
      'middle_name',
      'username',
      'email',
      'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
      'password',
      'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  // User Full Name
  public function getNameAttribute () : string {
    return "$this->first_name $this->last_name";
  }

  // User Avatar
  public function getAvatarAttribute () : array {
    $names = Str::of($this->name)->explode(' ');

    $fn = Str::of($names[0])->substr(0, 1)->upper();
    $ln = Str::of($names[1])->substr(0, 1)->upper();

    $colors = [
      'blue',
      'green',
      'yellow',
      'cyan',
      'red',
      'indigo',
      'teal',
      'orange',
      'bluegray',
      'purple'
    ];

    $color_index = (ord($fn) - 65) + (ord($ln) - 65);

    // User uploaded image
    $image = null;

    return [
      'color' => $colors[$color_index % count($colors)],
      'text' => Str::of("$fn$ln"),
      'image' => $image
    ];
  }

  // Check Username or Email
  public function scopeOfUsername ($query, $username) {
    return $query->where(function ($q) use ($username) {
      $q->orWhere('username', $username)
        ->orWhere('email', $username);
    });
  }

  /**
   * Check Password
   *
   * Check if the given password matches the hashed password in the database.
   *
   * @param string $password
   *
   * @return bool
   *
   */
  public function checkPassword ($password) {
    return Hash::check($password, $this->password);
  }

  // User Role
  public function role () {
    return $this->belongsTo(Role::class);
  }
}
