<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Office\LoginRequest;
use App\Traits\AuthOffice;

class AuthController extends Controller
{

    use AuthOffice;

    public function loginView(Request $request)
    {
        if ($this->isLogined()) {
            return redirect(route('office.index'));
        }
        return inertia('Login');
    }

    public function loginSubmit(LoginRequest $request)
    {
        $request->authenticate();

        return redirect()->intended(route('office.index'));
    }

    public function logout(Request $request)
    {
        if ($this->isLogined()) {
            $this->authGuard()->logout();
        }
        return redirect(route('office.login'));
    }
}
