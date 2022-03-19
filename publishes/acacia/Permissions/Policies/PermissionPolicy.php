<?php

namespace Acacia\Permissions\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use App\Models\User as AuthUser;
use Acacia\Permissions\Models\Permission;
class PermissionPolicy
{
    use HandlesAuthorization;
    private string $basePerm = "permissions";
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
     * @param  Permission  $model
     * @return Response|bool
     */
    public function view(AuthUser $user, Permission $model): Response|bool
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
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  AuthUser  $user
     * @param  Permission $model
     * @return Response|bool
     */
    public function update(AuthUser $user, Permission $model): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  AuthUser  $user
     * @param  Permission $model
     * @return Response|bool
     */
    public function delete(AuthUser $user, Permission $model): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  AuthUser  $user
     * @param  Permission $model
     * @return Response|bool
     */
    public function restore(AuthUser $user, Permission $model): Response|bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  AuthUser  $user
     * @param  Permission $model
     * @return Response|bool
     */
    public function forceDelete(
        AuthUser $user,
        Permission $model
    ): Response|bool {
        return false;
    }
}
