<?php

namespace Acacia\Core\Repos;

use Acacia\Core\Constants\FormFields;
use Acacia\Core\Models\Field;
use Acacia\Core\Models\Relationship;
use Acacia\Core\Models\Schematic;
use Acacia\Core\Traits\ProcessesColumns;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Savannabits\Acacia\Helpers\ColumnsReader;
use Symfony\Component\Console\Logger\ConsoleLogger;

class GPanelRepo
{
    use ProcessesColumns;

    /**
     * @throws \Throwable
     */
    public static function createBlueprint(Collection $data): Schematic
    {
        $tableName = $data->get('table')["name"];
        $recreate = $data->get('recreate');
        $existingTable = $data->get('existingTable');
        if ($existingTable) {
            $schematic = self::generateBlueprintFromTable($tableName,$recreate);
        }
        return $schematic;
    }

    /**
     * @throws \Throwable
     */
    public static function generateBlueprintFromTable(string $tableName, bool $forceRecreate, ?Command $console = null): Schematic
    {
        $schematic = new Schematic();
        \DB::transaction(function() use($tableName,$forceRecreate,$console, &$schematic) {
            //Check if already exists
            $existing = Schematic::query()->where("table_name","=", $tableName)->first();
            if ($existing) {
                \Log::info("Schematic already exists");
                if ($forceRecreate) {
                    \Schema::connection('acacia')->disableForeignKeyConstraints();
                    \Log::info("Delete relationships");
                    $console?->comment("Delete relationships");
                    $existing->relationships()->delete();
                    \Log::info("Delete fields");
                    $console?->comment("Delete AcaciaFields");
                    $existing->fields()->delete();
                    \Log::info("Delete existing schema");
                    $console?->comment('Delete existing schema');
                    $existing->delete();
                    \Schema::connection('acacia')->enableForeignKeyConstraints();
                } else {
                    \Session::flash('payload',$existing);
                    abort(400,"Schematic for this table already exist");
                }
            }
            $columnListing = \DB::getDoctrineSchemaManager()->listTableColumns($tableName);
            $morphs = self::extractMorphs($tableName);
            $morphCols = collect($morphs)->map(fn(Index $morph) => $morph->getColumns())->flatten();
            $fks = \DB::getDoctrineSchemaManager()->listTableForeignKeys($tableName);
            $foreignCols = collect($fks)->map(fn(ForeignKeyConstraint $constraint) => $constraint->getLocalColumns())->flatten();

            $colNames = collect($columnListing)
                ->keys()
                ->reject(fn(string $col) => in_array($col,$foreignCols->merge($morphCols)->toArray()));
            // Create Schematic
            $console?->comment("Creating Schema for $tableName");
            $schematic->table_name = $tableName;
            $schematic->model_class = \Str::singular(\Str::studly(\Str::camel($tableName)));
            $schematic->controller_class = "{$schematic->model_class}Controller";
            $schematic->route_name = \Str::slug($tableName);

            $schematic->saveOrFail();
            $filteredCols = collect($columnListing)->only($colNames->toArray());
            $console?->comment("Creating AcaciaFields for $schematic->table_name");
            foreach ($filteredCols as $key => $column) {
                \Log::info($key);
                /**
                 * @var Column $column
                 */
                $field = new Field();
                $field->title = \Str::replace("_"," ",\Str::title($key));
                $field->name = $key;
                $field->db_type = $column->getType()->getName();
                $field->html_type = get_default_html_field($column->getType()->getName(), $column->getName());
                $field->has_options = false;
                $field->is_guarded = in_array($column->getName(),["id","password","username","created_at","updated_at"]);
                $field->is_vue = true;
                $field->in_form = !in_array($column->getName(),["id", "created_at","updated_at"]);
                $field->in_list = !(in_array($column->getName(),["password",'token','api_token','remember_token',"secret"]) || in_array($field->db_type, ['json','text']) );
                $field->schematic()->associate($schematic);
                $field->saveOrFail();

                // Make Server side validation:
                $field->server_validation = static::makeServerValidation($field, $column, $tableName, $schematic->model_class);
                $field->saveOrFail();

            }
            $labelFieldOpts = $schematic->fields()->where("is_guarded","=",false)->get()->pluck('name') ?? collect([]);
            if ($labelFieldOpts->contains('name')) {
                $labelField = "name";
            } else if ($labelFieldOpts->contains('title')) {
                $labelField = "title";
            } elseif ($labelFieldOpts->count()) {
                $labelField = $labelFieldOpts->first();
            } else {
                $labelField = $schematic->fields()->first()?->name ?? "id";
            }
            $schematic->default_label_column = $labelField;
            $schematic->save();
            // BelongsTo AcaciaRelationships
            $console?->comment("Creating BelongsTo AcaciaRelationships for $schematic->table_name");
            foreach ($fks as $key => $fk) {
                $rel = new Relationship();
                $rel->type = "BelongsTo";
                $rel->local_key = $fk->getLocalColumns()[0];
                $rel->related_key = $fk->getForeignColumns()[0];
                $rel->related_table = $fk->getForeignTableName();
                $rel->is_recursive = $fk->getForeignTableName() === $schematic->table_name;
                if ($rel->is_recursive) {
                    $rel->related()->associate($schematic);
                } else {
                    $relatedSchema =Schematic::query()
                        ->where("table_name","=", $rel->related_table)->first();
                    $rel->related()->associate($relatedSchema);
                }
                $rel->label_column = $rel->related?->default_label_column;
                $rel->schematic()->associate($schematic);
                $rel->method = \Str::camel(\Str::singular(trim(\Str::replace("_id","",$rel->local_key))));
                if (Str::snake($rel->method) ===$rel->local_key) {
                    $rel->method = "{$rel->method}Model";
                }
                $rel->saveOrFail();
                $column = collect($columnListing)->get($rel->local_key);
                $rel->server_validation = self::makeServerValidation(self::relationshipToField($rel),$column,$tableName,$schematic->model_class);
                $rel->saveOrFail();
            }
            // Add Morph relationships
            $console?->comment("Creating MorphTo AcaciaRelationships for $schematic->table_name");
            foreach ($morphs as $key => $index) {
                /**
                 * @var Index $index
                 */
                $rel = new Relationship();
                $rel->type = "MorphTo";
                $rel->is_morph = true;
                $rel->morph_type_column= collect($index->getColumns())->filter(fn($col) => \Str::endsWith($col,"_type"))->first();
                $rel->morph_id_column= collect($index->getColumns())->filter(fn($col) => \Str::endsWith($col,"_id"))->first();
                $rel->is_recursive = false;
                $rel->related_key = null;
                $rel->schematic()->associate($schematic);
                $rel->method = \Str::camel(\Str::singular(trim(\Str::replace("_id","",$rel->morph_id_column))));
                $rel->saveOrFail();
            }
        });
        return $schematic;
    }
    private static function makeServerValidation(Field $field, Column $column, ?string $tableName, ?string $modelClass): string
    {
        $reader = ColumnsReader::init($tableName);
        $modelVariableName = Str::camel($modelClass);
        $uniqueIndexes = $reader->getColumnUniqueIndexes($column->getName());
        $columns = $reader->getColumns();
        $filtered = $columns->filter(function($col) {
            return !($col['name'] == "id" || $col['name'] == "created_at" || $col['name'] == "updated_at" || $col['name'] == "deleted_at" || $col['name'] == "remember_token");
        });
        $validation = collect(['store' =>collect(),'update' => collect(),'index' => collect()]);
        if ($column->getNotnull()) {
            $validation->get('store')->push('required');
            $validation->get('update')->push('sometimes');
        } else {
            $validation->get("store")->push('nullable');
            $validation->get("update")->push('nullable');
        }

        // TODO: Add any other commonly used field names for email
        if (in_array($column->getName(),['email','email_address','secondary_email','work_email','e_mail','contact_email'])) {
            $validation->get('store')->push('email');
            $validation->get('update')->push('email');
        }
        if ($column->getName() ==='slug') {
            $validation->get('store')->merge(['unique']);
            $validation->get('update')->merge(['unique']);
        }
        if ($reader->isUnique($column->getName())){
            if($column->getType() === 'json') {
                if ($reader->getColumnUniqueIndexes($column->getName())->count() == 1) {
                    $storeRule = 'Rule::unique(\''.$tableName.'\', \''.$column->getName().'->\'.$locale)';
                    $updateRule = 'Rule::unique(\''.$tableName.'\', \''.$column->getName().'->\'.$locale)->ignore($this->'.$modelVariableName.'->getKey(), $this->'.$modelVariableName.'->getKeyName())';
                    $cols = $uniqueIndexes->first()->getColumns();
                    if (count($cols) > 1) {
                        $otherCols = collect($cols)->reject(function ($col) use ($column) { return $col ===$column->getName();});
                        foreach ($otherCols as $otherCol) {
                            $storeRule .= '->where('.$otherCol.',$this->'.$otherCol.')';
                            $updateRule .= '->where('.$otherCol.',$this->'.$otherCol.')';
                        }
                    }
                    $validation->get('store')->push($storeRule);
                    $validation->get('update')->push($updateRule);
                }
            } else {
                if ($uniqueIndexes->count() == 1) {
                    $storeRule = 'Rule::unique(\''.$tableName.'\', \''.$column->getName().'\')';
                    $updateRule = 'Rule::unique(\''.$tableName.'\', \''.$column->getName().'\')';

                    $cols = $uniqueIndexes->first()->getColumns();
                    if (count($cols) > 1) {
                        $otherCols = collect($cols)->reject(function ($col) use ($column) { return $col ===$column->getName();});
                        foreach ($otherCols as $otherCol) {
                            if ($filtered->keyBy("name")->has($otherCol)) {
                                $otherRel = $otherCol;
                                $otherKey = '';
                            }/* elseif ($relationships->keyBy("name")->has($otherCol)) {
                                $otherRel = $relationships->get($otherCol)['relationship_variable'];
                                $ownerKey = $relationships->get($otherCol)["owner_key"];
                                $otherKey = $ownerKey;
                            }*/ else {
                                $otherRel = null;
                                $otherKey = null;
                            }
                            if ($otherRel) {
                                if ($otherKey) {
                                    $where = 'collect($this->'.$otherRel.')->get(\''.$otherKey.'\')';
                                } else {
                                    $where = $otherRel;
                                }
                                $storeRule .= '->where("'.$otherCol.'", $this->'.$where.')';
                                $updateRule .= '->where("'.$otherCol.'",$this->'.$where.')';

                            }
                        }
                    }
                    $updateRule .= '->ignore($this->'.$modelVariableName.'->getKey(), $this->'.$modelVariableName.'->getKeyName())';
                    $validation->get('store')->push($storeRule);
                    $validation->get('update')->push($updateRule);
                }
            }
        }



        $otherRules = match ($field->db_type) {
            "integer","int" => "integer",
            "float","double" => "numeric",
            "boolean","bool","tinyint", => "boolean",
            "json","longtext","relationship" => "array",
            "date","datetime","timestamp" => "date",
            default => 'string',
        };

        if (in_array($column->getName(),['password','user_password'])) {
            $validation->get('store')
                ->push('confirmed')
                ->push('Password::min(8)->mixedCase()->numbers()->symbols()');
            $validation->get('update')
                ->push('confirmed')
                ->push('Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()->symbols()');
        } else {
            $validation->get('store')->push($otherRules);
            $validation->get('update')->push($otherRules);
        }

        return $validation->toJson();
    }

    public static function relationshipToField($relationship): Field
    {
        $labelFieldOpts = $relationship->related?->fields()->where("is_guarded","=",false)->get()->pluck('name') ?? collect([]);
        $defaultLabel = $relationship->related?->label_column;
        if ($defaultLabel) {
            $labelField = $defaultLabel;
        } else if ($labelFieldOpts->contains('name')) {
            $labelField = "name";
        } else if ($labelFieldOpts->contains('title')) {
            $labelField = "title";
        } elseif ($labelFieldOpts->count()) {
            $labelField = $labelFieldOpts->first();
        } else {
            $labelField = $relationship->related?->fields()->first()?->name ?? "id";
        }
        $field = new Field();
        $title = implode(" ", Str::ucsplit(Str::studly($relationship->method)));
        $field->forceFill([
            "title" => $title,
            "name" => Str::snake($relationship->method),
            "db_type" => "relationship",
            "html_type" => FormFields::SELECT,
            "has_options" => true,
            "is_vue" => true,
            "in_form" => true,
            "options_route_name" => "api.v1.".$relationship->related?->route_name.".index",
            "options_label_field" => $labelField
        ]);
        return $field;
    }
}
