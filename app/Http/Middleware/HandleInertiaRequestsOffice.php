<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class HandleInertiaRequestsOffice extends HandleInertiaRequests
{

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'office/app';

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            // 'auth.manager' => fn () => $request->user('office')
            //     ? $request->user('office')->only('name', 'account')
            //     : null,
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'error'   => $request->session()->get('error'),
                'message' => $request->session()->get('message'),
            ],
            'locales' => fn () => config('site.locales'),
            'locale'  => fn () => app()->getLocale(),
            'request.prefix'   => '/office',
            'request.name'     => $request->route()->getName(),
            'request.path'     => $request->path(),
            'request.query'    => fn () => (object) $request->query(),
            'request.previous' => fn () => $request->user('office')
                ? (url()->previous() ?: null)
                : null,
        ]);
    }
}
