<?php

namespace Acacia\AcaciaSchematics\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;
use Illuminate\Support\Str;
use Acacia\AcaciaSchematics\Models\Schematic;
class Schematics
{
    private ?Schematic $model = null;
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
    public static function init(Schematic $model): static
    {
        $instance = new static();
        $instance->model = $model;
        return $instance;
    }
    public function setModel(Schematic $model): static
    {
        $this->model = $model;
        return $this;
    }
    public function index(): LengthAwarePaginator
    {
        if ($search = request()->input("search")) {
            return $data = Schematic::search($search)
                ->query(fn($query) => $query)
                ->paginate();
        }
        return $data = Schematic::query()->paginate();
    }
    public function store(object $data): ?Schematic
    {
        $relationships = $this->relationships;
        $model = new Schematic((array) $data);
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
    public function show(): Schematic
    {
        $relationships = $this->relationships;
        $this->model->load($relationships);
        return $this->model;
    }

    public function update(object $data): Schematic
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
        $q = Schematic::query();
        return \PrimevueDatatables::of($q)->make();
    }
}
