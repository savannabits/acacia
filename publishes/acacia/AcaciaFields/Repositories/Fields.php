<?php

namespace Acacia\AcaciaFields\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;
use Illuminate\Support\Str;
use Acacia\AcaciaFields\Models\Field;
class Fields
{
    private ?Field $model = null;
    private array $relationships = [];
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->relationships = ["schematic"];
    }
    public static function init(Field $model): static
    {
        $instance = new static();
        $instance->model = $model;
        return $instance;
    }
    public function setModel(Field $model): static
    {
        $this->model = $model;
        return $this;
    }
    public function index(): LengthAwarePaginator
    {
        if ($search = request()->input("search")) {
            return $data = Field::search($search)
                ->query(fn($query) => $query)
                ->paginate();
        }
        return $data = Field::query()->paginate();
    }
    public function store(object $data): ?Field
    {
        $relationships = $this->relationships;
        $model = new Field((array) $data);
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
    public function show(): Field
    {
        $relationships = $this->relationships;
        $this->model->load($relationships);
        return $this->model;
    }

    public function update(object $data): Field
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
        $q = Field::query()->with('schematic');
        return \PrimevueDatatables::of($q)->make();
    }
}
