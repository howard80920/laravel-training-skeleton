<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowDebug extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return [
            'ip' => $request->ip(),
            'server_remote_addr' => $_SERVER['REMOTE_ADDR'] ?? null,
            'http_host' => $request->getSchemeAndHttpHost(),
            'root' => $request->root(),
            'schema' => $request->getScheme(),
            'headers' => $request->headers->all(),
        ];
    }
}
