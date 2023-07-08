<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
  use HasFactory;

  protected $table = 'logs_login_attempts';

  protected $fillable = [
    'ip_address',
    'user_agent',
    'username',
    'password',
    'success',
  ];

  public static function log (array $data) {
    return self::create($data);
  }
}
