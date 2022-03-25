<?php

namespace Acacia\Permissions\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;
use Illuminate\Support\Str;
use Acacia\Permissions\Models\Permission;
class Permissions
{
    private ?Permission $model = null;
    private array $relationships = [];
    /**
     * Create a new permissions repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->relationships = [];
    }
    public static function init(Permission $model): static
    {
        $instance = new static();
        $instance->model = $model;
        return $instance;
    }
    public function setModel(Permission $model): static
    {
        $this->model = $model;
        return $this;
    }
    public function index(): LengthAwarePaginator
    {
        if ($search = request()->input("search")) {
            return $data = Permission::search($search)
                ->query(fn($query) => $query)
                ->paginate();
        }
        return $data = Permission::query()->paginate();
    }
    public function store(object $data): ?Permission
    {
        $relationships = $this->relationships;
        $model = new Permission((array) $data);
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
    public function show(): Permission
    {
        $relationships = $this->relationships;
        $this->model->load($relationships);
        $this->model->assigned = \Auth::user()->hasPermissionTo($this->model);
        return $this->model;
    }

    public function update(object $data): Permission
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

        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        return !!$this->model->delete();
    }
    public function dt(): LengthAwarePaginator
    {
        $q = Permission::query();
        return \PrimevueDatatables::of($q)->make();
    }
}
