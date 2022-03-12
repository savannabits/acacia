<?php

namespace Acacia\Permissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Acacia\Permissions\Database\Factories\PermissionFactory;
use Laravel\Scout\Searchable;

class Permission extends \Spatie\Permission\Models\Permission
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

    protected static function newFactory(): PermissionFactory
    {
        return PermissionFactory::new();
    }
    /********* BELONGS TO **********/

    /********* MORPH TO **********/

    public function toSearchableArray(): array
    {
        return $this->only($this->getFillable());
    }
}
