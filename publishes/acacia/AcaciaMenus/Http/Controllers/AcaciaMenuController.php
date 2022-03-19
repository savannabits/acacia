<?php

namespace Acacia\AcaciaMenus\Http\Controllers;

use Acacia\AcaciaMenus\Models\Menu;
use Acacia\AcaciaMenus\Repositories\Menus;
use Acacia\AcaciaMenus\Http\Requests\Menu\IndexRequest;
use Acacia\AcaciaMenus\Http\Requests\Menu\ViewRequest;
use Acacia\AcaciaMenus\Http\Requests\Menu\StoreRequest;
use Acacia\AcaciaMenus\Http\Requests\Menu\UpdateRequest;
use Acacia\AcaciaMenus\Http\Requests\Menu\DestroyRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AcaciaMenuController extends Controller
{
    public function __construct(private Menus $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        $model = Menu::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("AcaciaMenus/Js/Pages/Index", compact("can"));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $model = Menu::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("AcaciaMenus/Js/Pages/Create", compact("can"));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $payload = $this->repo->store($request->sanitizedObject());
            $success = "Record created successfully";
            return back()->with(compact("success", "payload"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }

    /**
     * Show the specified resource.
     * @param ViewRequest $request
     * @param Menu $menu
     * @return Response
     */
    public function show(ViewRequest $request, Menu $menu): Response
    {
        $model = $this->repo->setModel($menu)->show();
        return Inertia::render("AcaciaMenus/Js/Pages/Show", compact("model"));
    }

    /**
     * Edit the specified resource.
     * @param Request $request
     * @param Menu $menu
     * @return Response
     */
    public function edit(Request $request, Menu $menu): Response
    {
        $model = $this->repo->setModel($menu)->show();
        return Inertia::render("AcaciaMenus/Js/Pages/Edit", compact("model"));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Menu $menu
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Menu $menu): RedirectResponse
    {
        try {
            $payload = $this->repo
                ->setModel($menu)
                ->update($request->sanitizedObject());
            $success = "Record updated successfully";
            return back()->with(compact("success", "payload"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param DestroyRequest $request
     * @param Menu $menu
     * @return RedirectResponse
     */
    public function destroy(
        DestroyRequest $request,
        Menu $menu
    ): RedirectResponse {
        try {
            $res = $this->repo->setModel($menu)->destroy();
            $success = "Record deleted successfully";
            return back()->with(compact("success"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }
}
