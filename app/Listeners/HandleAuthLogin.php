<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cache;
use App\Consts\CachePrefix;

class HandleAuthLogin
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
    public function handle(Login $event): void
    {
        $request = request();
        if (!$request->hasSession()) {
            return;
        }
        $request->session()->regenerate();
        if (config('site.single_login.enable')) {
            $sessionId = $request->session()->getId();
            if ($sessionId) {
                $userId = $event->user->getAuthIdentifier();
                Cache::put(
                    CachePrefix::SINGLE_LOGIN . "{$event->guard}:{$userId}",
                    $sessionId,
                    now()->addDays(config('site.single_login.expire_days', 7))
                );
            }
        }
    }
}
