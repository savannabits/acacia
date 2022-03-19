<?php

namespace Acacia\AcaciaRelationships\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Acacia\AcaciaRelationships\Database\Factories\RelationshipFactory;
use Laravel\Scout\Searchable;

class Relationship extends \Acacia\Core\Models\Relationship
{
    use HasFactory, Searchable;

    protected $fillable = [
        "type",
        "method",
        "related_key",
        "related_table",
        "local_key",
        "label_column",
        "is_recursive",
        "is_morph",
        "morph_type_column",
        "morph_id_column",
        "server_validation",
        "in_list",
    ];
    protected $hidden = ["password", "remember_token"];
    protected $casts = [
        "is_recursive" => "boolean",
        "is_morph" => "boolean",
        "in_list" => "boolean",
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

    protected static function newFactory(): RelationshipFactory
    {
        return RelationshipFactory::new();
    }
    /********* BELONGS TO **********/
    public function related(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            \Acacia\AcaciaSchematics\Models\Schematic::class,
            "related_id",
            "id"
        );
    }
    public function schematic(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            \Acacia\AcaciaSchematics\Models\Schematic::class,
            "schematic_id",
            "id"
        );
    }

    /********* MORPH TO **********/

    public function toSearchableArray(): array
    {
        return $this->only($this->getFillable());
    }
}
