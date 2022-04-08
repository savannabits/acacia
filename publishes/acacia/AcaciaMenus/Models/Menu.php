<?php

namespace Acacia\AcaciaMenus\Models;

use Acacia\Core\Models\AcaciaMenu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Acacia\AcaciaMenus\Database\Factories\MenuFactory;
use Laravel\Scout\Searchable;

class Menu extends AcaciaMenu
{
    use Searchable;

    protected $fillable = [
        "title",
        "icon",
        "route",
        "url",
        "active",
        "active_pattern",
        "position",
        "permission_name",
        "module_name",
        "description",
    ];
    protected $hidden = ["password", "remember_token"];
    protected $casts = ["active" =>"boolean","created_at" => "datetime", "updated_at" => "datetime"];
    protected $appends = ["can"];

    protected function getCanAttribute(): array
    {
        $policies = collect([
            "viewAny",
            "view",
            "create",
            "update",
            "delete",
            "restore",
            "forceDelete",
            "review",
        ]);
        return $policies
            ->map(
                fn(string $policy) => [
                    "policy" => $policy,
                    "can" =>
                        \Auth::check() && \Auth::user()->can($policy, $this),
                ]
            )
            ->pluck("can", "policy")
            ->toArray();
    }

    /********* BELONGS TO **********/
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            \Acacia\AcaciaMenus\Models\Menu::class,
            "parent_id",
            "id"
        );
    }

    /********* MORPH TO **********/

    public function toSearchableArray(): array
    {
        return $this->only($this->getFillable());
    }
}
