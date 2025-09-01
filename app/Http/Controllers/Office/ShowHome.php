<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowHome extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.office');
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia('Home');
    }
}
