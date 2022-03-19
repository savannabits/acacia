<?php

namespace Acacia\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Acacia\Users\Database\Factories\UserFactory;
use Laravel\Scout\Searchable;

class User extends \App\Models\User
{
    use HasFactory, Searchable;

    protected $fillable = [
        "name",
        "email",
        "email_verified_at",
        "remember_token",
    ];
    protected $hidden = ["password", "remember_token"];
    protected $casts = [
        "email_verified_at" => "datetime",
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];
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

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
    /********* BELONGS TO **********/

    /********* MORPH TO **********/

    public function toSearchableArray(): array
    {
        return $this->only($this->getFillable());
    }
}
