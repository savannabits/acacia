<?php

namespace Acacia\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Acacia\Core\Database\factories\AcaciaMenuFactory;

class AcaciaMenu extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'menus';
    protected $connection='acacia';

    protected static function newFactory(): AcaciaMenuFactory
    {
        return AcaciaMenuFactory::new();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class,'parent_id');
    }
    public function children() : HasMany {
        return $this->hasMany(static::class,"parent_id");
    }
}
