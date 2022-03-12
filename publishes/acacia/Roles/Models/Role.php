<?php

namespace Acacia\Roles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Acacia\Roles\Database\Factories\RoleFactory;
use Laravel\Scout\Searchable;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, Searchable;

    protected $fillable = ["name", "guard_name"];
    protected $hidden = [];
    protected $casts = ["created_at" => "datetime", "updated_at" => "datetime"];

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
