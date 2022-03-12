<?php

namespace Acacia\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Acacia\Roles\Database\Factories\RoleFactory;
use Laravel\Scout\Searchable;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, Searchable;

    protected $fillable = ["name", "guard_name"];
    protected $hidden = ["password", "remember_token"];
    protected $casts = ["created_at" => "datetime", "updated_at" => "datetime"];
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

    protected static function newFactory(): RoleFactory
    {
        return RoleFactory::new();
    }
    /********* BELONGS TO **********/

    /********* MORPH TO **********/

    public function toSearchableArray(): array
    {
        return $this->only($this->getFillable());
    }
}
