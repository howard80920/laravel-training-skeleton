<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Consts\CachePrefix;

class Authenticate extends Middleware
{

    protected $redirectRoute = '';

    /**
     * @return ?string
     */
    public static function getGuard()
    {
        return null;
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson()
            ? null
            : ($this->redirectRoute ? route($this->redirectRoute) : abort(401, 'Unauthenticated.'));
    }

    protected function ensureSingleLogin(Request $request)
    {
        if (!$request->hasSession()) {
            return;
        }
        $guard  = static::getGuard();
        $userId = Auth::guard($guard)->id();
        $loginSession   = Cache::get(CachePrefix::SINGLE_LOGIN . "{$guard}:{$userId}");
        $requestSession = $request->session()->getId();
        if (!$loginSession || $loginSession != $requestSession) {
            Auth::guard($guard)->logout();
            $this->unauthenticated($request, [$guard]);
        }
    }

    public function handle($request, $next, ...$guards)
    {
        $this->authenticate($request, $guards);
        // 檢查是否單一登入
        if (config('site.single_login.enable')) {
            $this->ensureSingleLogin($request);
        }

        return $next($request);
    }

}
