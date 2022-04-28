<?php

namespace Acacia\Users\Repositories;

use Acacia\Roles\Models\Role;
use Hash;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use PrimevueDatatables;
use Throwable;
use Illuminate\Support\Str;
use Acacia\Users\Models\User;
class Users
{
    private ?User $model = null;
    private array $relationships = [];
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->relationships = [];
    }
    public static function init(User $model): static
    {
        $instance = new static();
        $instance->model = $model;
        return $instance;
    }
    public function setModel(User $model): static
    {
        $this->model = $model;
        return $this;
    }
    public function index(): LengthAwarePaginator
    {
        if ($search = request()->input("search")) {
            return $data = User::search($search)
                ->query(fn($query) => $query)
                ->paginate();
        }
        return $data = User::query()->paginate();
    }
    public function store(object $data): ?User
    {
        $relationships = $this->relationships;
        $model = new User((array) $data);
        if (isset($data->password) && $data->password) {
            $model->password = Hash::make($data->password);
        }
        foreach ($relationships as $relationship) {
            $method = Str::snake($relationship);
            if (isset($data->$method) && $data->$method?->id) {
                $model->$relationship()->associate($data->$method?->id);
            }
        }
        // Extend the saving logic here if need be.
        $model->saveOrFail();
        return $model;
    }
    public function show(): User
    {
        $relationships = $this->relationships;
        $this->model->load($relationships);
        $this->model->append('assigned_roles');
        return $this->model;
    }

    public function update(object $data): User
    {
        $relationships = $this->relationships;
        foreach ($relationships as $relationship) {
            $method = Str::snake($relationship);
            if (isset($data->$method) && $data->$method?->id) {
                $this->model->$relationship()->associate($data->$method?->id);
            } else {
                $this->model->$relationship()->dissociate();
            }
        }
        $this->model->update((array) $data);
        if (isset($data->password) && $data->password) {
            $this->model->password = Hash::make($data->password);
        }

        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        return !!$this->model->delete();
    }
    public function toggleRole(object $data): bool
    {
        $authUser = \App\Models\User::query()->find($this->model->id);
        if ($data->assigned) {
            $authUser->assignRole($data->role_id);
        } else {
            $authUser->removeRole($data->role_id);
        }
        return true;
    }
    public function dt(): LengthAwarePaginator
    {
        $q = User::query();
        return PrimevueDatatables::of($q)->make();
    }
}
