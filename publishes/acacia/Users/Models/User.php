<?php

namespace Acacia\Users\Models;

use Illuminate\Database\Eloquent\Model;
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
    protected $hidden = [];

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
