<?php

namespace Acacia\Roles\Http\Controllers\Api;

use Acacia\Roles\Models\Role;
use Acacia\Roles\Repositories\Roles;
use Acacia\Roles\Http\Requests\Role\IndexRequest;
use Acacia\Roles\Http\Requests\Role\DtRequest;
use Acacia\Roles\Http\Requests\Role\ViewRequest;
use Acacia\Roles\Http\Requests\Role\StoreRequest;
use Acacia\Roles\Http\Requests\Role\UpdateRequest;
use Acacia\Roles\Http\Requests\Role\DestroyRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Savannabits\Acacia\Helpers\ApiResponse;
use Acacia\Permissions\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RoleController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct(private ApiResponse $api, private Roles $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        try {
            $data = $this->repo->index();
            return $this->api
                ->success()
                ->message("List of Roles")
                ->payload($data)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * @param DtRequest $request
     * @return LengthAwarePaginator|JsonResponse
     */
    public function dt(DtRequest $request): LengthAwarePaginator|JsonResponse
    {
        try {
            return $this->repo->dt();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $payload = $this->repo->store($request->sanitizedObject());
            $success = "Record created successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Show the specified resource.
     * @param ViewRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function show(ViewRequest $request, Role $role): JsonResponse
    {
        try {
            $payload = $this->repo->setModel($role)->show();
            $success = "Single record fetched";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Role $role): JsonResponse
    {
        try {
            $payload = $this->repo
                ->setModel($role)
                ->update($request->sanitizedObject());
            $success = "Record updated successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param DestroyRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function destroy(DestroyRequest $request, Role $role): JsonResponse
    {
        try {
            $payload = $this->repo->setModel($role)->destroy();
            $success = "Record deleted successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    public function assignPermission(Request $request, Role $role): JsonResponse
    {
        $this->authorize("update", $role);
        $validated = $request->validate([
            "permission" => ["nullable", "array"],
            "all" => ["required", "boolean"],
            "checked" => ["required", "boolean"],
        ]);
        if ($validated["all"]) {
            $res = $this->repo
                ->setModel($role)
                ->toggleAllPermissions($validated["checked"]);
        } else {
            $res = $this->repo
                ->setModel($role)
                ->assignPermission($validated["permission"]);
        }
        return $this->api
            ->success()
            ->message("Role assignment updated")
            ->payload($res)
            ->send();
    }
}
