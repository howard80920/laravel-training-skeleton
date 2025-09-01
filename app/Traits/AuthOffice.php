<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\Manager;

trait AuthOffice
{

    /**
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function authGuard()
    {
        return Auth::guard('office');
    }

    protected function manager(): ?Manager
    {
        return $this->authGuard()->user();
    }

    protected function isLogined()
    {
        return $this->authGuard()->check();
    }

}
