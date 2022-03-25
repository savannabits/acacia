<?php

namespace Acacia\Roles\Http\Controllers;

use Acacia\Roles\Models\Role;
use Acacia\Roles\Repositories\Roles;
use Acacia\Roles\Http\Requests\Role\IndexRequest;
use Acacia\Roles\Http\Requests\Role\ViewRequest;
use Acacia\Roles\Http\Requests\Role\StoreRequest;
use Acacia\Roles\Http\Requests\Role\UpdateRequest;
use Acacia\Roles\Http\Requests\Role\DestroyRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Acacia\Permissions\Models\Permission;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct(private Roles $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        $model = Role::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("Roles/Js/Pages/Index", compact("can"));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $model = Role::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("Roles/Js/Pages/Create", compact("can"));
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
     * @param Role $role
     * @return Response
     */
    public function show(ViewRequest $request, Role $role): Response
    {
        $model = $this->repo->setModel($role)->show();
        return Inertia::render("Roles/Js/Pages/Show", compact("model"));
    }

    /**
     * Edit the specified resource.
     * @param Request $request
     * @param Role $role
     * @return Response
     */
    public function edit(Request $request, Role $role): Response
    {
        $model = $this->repo->setModel($role)->show();
        return Inertia::render("Roles/Js/Pages/Edit", compact("model"));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Role $role): RedirectResponse
    {
        try {
            $payload = $this->repo
                ->setModel($role)
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
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(
        DestroyRequest $request,
        Role $role
    ): RedirectResponse {
        try {
            $res = $this->repo->setModel($role)->destroy();
            $success = "Record deleted successfully";
            return back()->with(compact("success"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }
}
