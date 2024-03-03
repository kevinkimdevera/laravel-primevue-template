<?php

namespace App\Listeners;

use App\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerificationCodeNotification
{
  /**
   * Create the event listener.
   */
  public function __construct()
  {
      //
  }

  /**
   * Handle the event.
   */
  public function handle(Registered $event): void
  {
    $user = $event->user;

    if ($user && !$user->is_verified) {
      $event->user->notify(new VerifyEmail($user->verification_code));
    }
  }
}
