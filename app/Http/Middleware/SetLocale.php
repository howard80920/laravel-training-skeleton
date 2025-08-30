<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $fallback = config('app.locale');
        $locale   = $request->header('locale', $request->cookie('locale', $fallback));
        $locale   = config('site.locales.' . $locale, null) ? $locale : $fallback;

        app()->setLocale($locale);

        return $next($request);
    }
}
