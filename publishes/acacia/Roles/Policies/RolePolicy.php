<?php

namespace Acacia\Roles\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use App\Models\User as AuthUser;
use Acacia\Roles\Models\Role;
class RolePolicy
{
    use HandlesAuthorization;
    private string $basePerm = "roles";
    /**
     * Determine whether the user can view any models.
     *
     * @param  AuthUser $user
     * @return Response|bool
     */
    public function viewAny(AuthUser $user): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.view-any");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  AuthUser  $user
     * @param  Role  $model
     * @return Response|bool
     */
    public function view(AuthUser $user, Role $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.view");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  AuthUser  $user
     * @return Response|bool
     */
    public function create(AuthUser $user): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.create");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  AuthUser  $user
     * @param  Role $model
     * @return Response|bool
     */
    public function update(AuthUser $user, Role $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.update") &&
            (\Str::slug($model->name) !== "administrator" ||
                $user->hasRole("administrator"));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  AuthUser  $user
     * @param  Role $model
     * @return Response|bool
     */
    public function delete(AuthUser $user, Role $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.delete") &&
            \Str::slug($model->name) !== "administrator";
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  AuthUser  $user
     * @param  Role $model
     * @return Response|bool
     */
    public function restore(AuthUser $user, Role $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.restore") &&
            \Str::slug($model->name) !== "administrator";
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  AuthUser  $user
     * @param  Role $model
     * @return Response|bool
     */
    public function forceDelete(AuthUser $user, Role $model): Response|bool
    {
        return $user->hasPermissionTo("$this->basePerm.force-delete") &&
            \Str::slug($model->name) !== "administrator";
    }
}
