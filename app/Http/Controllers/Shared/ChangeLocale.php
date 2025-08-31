<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangeLocale extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $request->validate([
            'lang' => 'required|string',
        ]);

        $locale = config('site.locales.' . $request->lang)
            ? $request->lang
            : config('app.fallback_locale');

        $response = $request->ajax() || $request->wantsJson()
            ? response()->noContent()
            : back();

        return $response->cookie('locale', $locale, 525600);
    }
}
