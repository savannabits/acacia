<?php

namespace Acacia\Core\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Acacia\Core\Models\AcaciaMenu;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'core::app';
    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param Request $request
     * @return array
     */
    public function share(Request $request)
    {
        $routes = \Route::getRoutes();
        $routeNames = collect($routes->getRoutesByName())->keys()->toArray();
        $menu = AcaciaMenu::query()
            ->whereNull('parent_id')
            ->orderBy('position')
            ->with('children', function ($q) {
                $q->orderBy('position');
            })->get();
        $acaciaMenu = prepare_menu($menu);
        return array_merge(parent::share($request), [
            'acacia' => [
                'sidebar_heading' => config('acacia.sidebar.heading'),
                'sidebar_menu' => $acaciaMenu,
                'route_names' => $routeNames,
            ],
            'auth' => [
                "user" =>fn () => $request->user()
                    ? $request->user()->only('id', 'name', 'email')
                    : null,
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'payload' => $request->session()->get('payload')
            ],
        ]);
    }
}
