<?php

namespace Acacia\AcaciaFields\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Acacia\AcaciaFields\Database\Factories\FieldFactory;
use Laravel\Scout\Searchable;

class Field extends \Acacia\Core\Models\Field
{
    use HasFactory, Searchable;

    protected $fillable = [
        "title",
        "name",
        "description",
        "db_type",
        "html_type",
        "server_validation",
        "client_validation",
        "is_vue",
        "has_options",
        "is_guarded",
        "is_hidden",
        "in_form",
        "in_list",
        "options_route_name",
        "options_label_field",
    ];
    protected $hidden = ["password", "remember_token"];
    protected $casts = [
        "is_vue" => "boolean",
        "has_options" => "boolean",
        "is_guarded" => "boolean",
        "is_hidden" => "boolean",
        "in_form" => "boolean",
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

    protected static function newFactory(): FieldFactory
    {
        return FieldFactory::new();
    }
    /********* BELONGS TO **********/
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
