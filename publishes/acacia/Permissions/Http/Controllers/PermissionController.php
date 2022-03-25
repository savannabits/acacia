<?php

namespace Acacia\Permissions\Http\Controllers;

use Acacia\Permissions\Models\Permission;
use Acacia\Permissions\Repositories\Permissions;
use Acacia\Permissions\Http\Requests\Permission\IndexRequest;
use Acacia\Permissions\Http\Requests\Permission\ViewRequest;
use Acacia\Permissions\Http\Requests\Permission\StoreRequest;
use Acacia\Permissions\Http\Requests\Permission\UpdateRequest;
use Acacia\Permissions\Http\Requests\Permission\DestroyRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PermissionController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct(private Permissions $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        $model = Permission::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("Permissions/Js/Pages/Index", compact("can"));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $model = Permission::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("Permissions/Js/Pages/Create", compact("can"));
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
     * @param Permission $permission
     * @return Response
     */
    public function show(ViewRequest $request, Permission $permission): Response
    {
        $model = $this->repo->setModel($permission)->show();
        return Inertia::render("Permissions/Js/Pages/Show", compact("model"));
    }

    /**
     * Edit the specified resource.
     * @param Request $request
     * @param Permission $permission
     * @return Response
     */
    public function edit(Request $request, Permission $permission): Response
    {
        $model = $this->repo->setModel($permission)->show();
        return Inertia::render("Permissions/Js/Pages/Edit", compact("model"));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(
        UpdateRequest $request,
        Permission $permission
    ): RedirectResponse {
        try {
            $payload = $this->repo
                ->setModel($permission)
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
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function destroy(
        DestroyRequest $request,
        Permission $permission
    ): RedirectResponse {
        try {
            $res = $this->repo->setModel($permission)->destroy();
            $success = "Record deleted successfully";
            return back()->with(compact("success"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }
}
