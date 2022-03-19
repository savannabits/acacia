<?php

namespace Acacia\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schematic extends Model
{
    protected $connection='acacia';
    public function getModuleNameAttribute(): string
    {
        return \Str::pluralStudly($this->model_class);
    }


    /**
     * @return HasMany
     */
    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    public function relationships(): HasMany
    {
        return $this->hasMany(Relationship::class,"schematic_id","id");
    }
}
