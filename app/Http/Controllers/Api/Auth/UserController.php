<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;

class UserController extends Controller
{
  public function show (Request $request) {
    return AuthResource::make($request->user());
  }
}
