<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function loginView(Request $request)
    {
        return inertia('Login');
    }

    public function loginSubmit(Request $request)
    {
        // login logic
        return redirect()->intended(route('office.index'));
    }

    public function logout(Request $request)
    {
        // logout logic
        return redirect(route('office.login'));
    }
}
