<?php

namespace Acacia\Users\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;
use Acacia\Users\Models\User;
class Users
{
    private ?User $model = null;
    private array $relationships = [];
    /**
     * Create a new policy instance.
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
        foreach ($relationships as $relationship) {
            $model->$relationship()->associate($data->$relationship?->id);
        }
        // Extend the saving logic here if need be.
        $model->saveOrFail();
        return $model;
    }
    public function show(): User
    {
        $relationships = $this->relationships;
        $this->model->load($relationships);
        return $this->model;
    }

    public function update(object $data): User
    {
        $relationships = $this->relationships;
        foreach ($relationships as $relationship) {
            $this->model->$relationship()->associate($data->$relationship?->id);
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
        $q = User::query();
        return \PrimevueDatatables::of($q)->make();
    }
}
