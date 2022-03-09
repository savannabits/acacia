<?php

namespace Acacia\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;

class Schematic extends Model
{
    protected $connection='acacia';
    public function getModuleNameAttribute(): string
    {
        return \Str::pluralStudly($this->model_class);
    }

    public static function schema(Blueprint $table)
    {
        $table->id();
        $table->string('table_name');
        $table->string('model_class')->nullable();
        $table->string('controller_class')->nullable();
        $table->string('route_name')->nullable();
        $table->timestamp('generated_at')->nullable();
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
