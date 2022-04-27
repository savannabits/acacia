<?php

namespace Savannabits\Acacia\Helpers;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ColumnsReader
{
    public function __construct(private string $table)
    {
    }

    public static function init($table): ColumnsReader
    {
        return new self($table);
    }

    /**
     * @throws Exception
     */
    public function getIndexes(): Collection
    {
        return collect(Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($this->table));
    }
    public function getColumns($tableName = null): Collection
    {
        if (!$tableName) {
            $tableName = $this->table;
        }
        $indexes = $this->getIndexes();
        return collect(Schema::getColumnListing($tableName))->map(function($columnName) use ($tableName, $indexes) {

            //Checked unique index
            $columnUniqueIndexes = $indexes->filter(function($index) use ($columnName) {
                return in_array($columnName, $index->getColumns()) && ($index->isUnique() && !$index->isPrimary());
            });
            $columnPrimaryIndex = $indexes->filter(function($index) use ($columnName) {
                return in_array($columnName,$index->getColumns()) && $index->isPrimary();
            });
            $columnUniqueDeleteAtCondition = $columnUniqueIndexes->filter(function($index) {
                return $index->hasOption('where') && $index->getOption('where') == '(deleted_at IS NULL)';
            });

            // TODO add foreign key

            return [
                'name' => $columnName,
                'primary' => $columnPrimaryIndex->count() > 0,
                'label' => \Str::title(str_replace("-"," ",Str::slug($columnName))),
                'type' => Schema::getColumnType($tableName, $columnName),
                'required' => boolval(Schema::getConnection()->getDoctrineColumn($tableName, $columnName)->getNotnull()),
                'unique' => $columnUniqueIndexes->count() > 0,
                'unique_indexes' => $columnUniqueIndexes,
                'unique_deleted_at_condition' => $columnUniqueDeleteAtCondition->count() > 0,
            ];
        })->values();
    }

    /**
     * @throws Exception
     */
    protected function getBelongsToRelations(): Collection
    {
        $relationships = collect(app('db')->connection()->getDoctrineSchemaManager()->listTableForeignKeys($this->table))
            ->map(function($fk) {
            /**@var ForeignKeyConstraint $fk*/
            $columns = $this->getColumns($fk->getForeignTableName())->filter(function($column) {
                return in_array($column["name"],["name", "display_name","title"]) || in_array($column["type"],["string"]);
            })->pluck("name");
            $labelColumn = $columns->filter(function($column){return in_array($column, [
                'name','display_name', 'title'
            ]);
            })->first();
            if (!$labelColumn) $labelColumn = $columns->filter(function($column){return $column==='title';})->first();
            if (!$labelColumn) $labelColumn = $columns->filter(function($column){return $column==='name';})->first();
            if (!$labelColumn) $labelColumn = $columns->first();
            if (!$labelColumn) $labelColumn = "id";
            $functionName = collect($fk->getForeignColumns())->first();
            if (Str::contains($functionName,"_id")) {$functionName = Str::singular(str_replace("_id","",$functionName));} else {
                $functionName =Str::singular($functionName)."_model";
            }
            $functionName = Str::camel($functionName);
            $relatedTitle = Str::title(str_replace("_"," ",Str::snake(Str::studly($functionName))));
            return [
                "function_name" => $functionName,
                "related_table" => $fk->getForeignTableName(),
                "related_route_name" => Str::slug(Str::pluralStudly($fk->getForeignTableName())),
                "related_model" => "\\$this->modelNamespace\\". Str::studly(Str::singular($fk->getForeignTableName())).'::class',
                "related_model_title" => $relatedTitle,
                "label_column" => $labelColumn,
                "relationship_variable" => Str::snake($functionName),
                "foreign_key" => collect($fk->getColumns())->first(),
                "owner_key" => collect($fk->getForeignColumns())->first(),
            ];
        })->keyBy('foreign_key');
        $this->relations["belongsTo"] = $relationships;
        return $relationships;
    }
    /**
     * @throws Exception
     */
    public function getColumnUniqueIndexes(string $columnName): Collection
    {
        $indexes = $this->getIndexes();
        return $indexes->filter(function($index) use ($columnName) {
            return in_array($columnName, $index->getColumns()) && ($index->isUnique() && !$index->isPrimary());
        });
    }

    /**
     * @throws Exception
     */
    public function isUnique(string $columnName): bool
    {
        return $this->getColumnUniqueIndexes($columnName)->count() > 0;
    }
}
