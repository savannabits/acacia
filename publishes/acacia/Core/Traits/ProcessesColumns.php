<?php

namespace Acacia\Core\Traits;

use Doctrine\DBAL\Exception;

trait ProcessesColumns
{
    /**
     * @throws Exception
     */
    public static function extractMorphs(string $table): array
    {
        $morphs = [];
        $indexListing = \DB::getDoctrineSchemaManager()->listTableIndexes($table);
        foreach ($indexListing as $index) {
            if (count($cols = $index->getColumns()) === 2) {
                if (\Str::endsWith($cols[0],"_type") && \Str::endsWith($cols[1],"_id")) {
                    $morphs[] = $index;
                }
            }
        }
        return $morphs;
    }
}
