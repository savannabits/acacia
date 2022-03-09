<?php

namespace Acacia\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Field extends Model
{
    protected $connection='acacia';
    public function schematic(): BelongsTo
    {
        return $this->belongsTo(Schematic::class);
    }
}
