<?php

namespace App\Http\Middleware;

use App\Http\Middleware\Authenticate;

class AuthenticateOffice extends Authenticate
{

    protected $redirectRoute = 'office.login';

    public static function getGuard()
    {
        return 'office';
    }

    public function handle($request, $next, ...$guards)
    {
        return parent::handle($request, $next, static::getGuard());
    }

}
