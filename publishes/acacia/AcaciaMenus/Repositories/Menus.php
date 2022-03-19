<?php

namespace Acacia\AcaciaMenus\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Throwable;
use Illuminate\Support\Str;
use Acacia\AcaciaMenus\Models\Menu;
class Menus
{
    private ?Menu $model = null;
    private array $relationships = [];
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->relationships = ["parent"];
    }
    public static function init(Menu $model): static
    {
        $instance = new static();
        $instance->model = $model;
        return $instance;
    }
    public function setModel(Menu $model): static
    {
        $this->model = $model;
        return $this;
    }
    public function index(): LengthAwarePaginator
    {
        if ($search = request()->input("search")) {
            return $data = Menu::search($search)
                ->query(fn($query) => $query)
                ->paginate();
        }
        return $data = Menu::query()->paginate();
    }
    public function store(object $data): ?Menu
    {
        $relationships = $this->relationships;
        $model = new Menu((array) $data);
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
    public function show(): Menu
    {
        $relationships = $this->relationships;
        $this->model->load($relationships);
        return $this->model;
    }

    public function update(object $data): Menu
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
        $q = Menu::query()->with('parent');
        return \PrimevueDatatables::of($q)->make();
    }
}
