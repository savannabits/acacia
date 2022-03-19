<?php

namespace Acacia\Core\Http\Controllers\Api;

use DB;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Schema;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Str;

class GPanelController extends Controller
{
    private AbstractSchemaManager $manager;

    public function __construct()
    {
        $this->manager = DB::getDoctrineSchemaManager();
    }

    /**
     * @throws Exception
     */
    public function searchTables(Request $request): Collection
    {
        $existingTables = $this->manager->listTableNames();
        $collection = collect($existingTables)->map(fn ($name) => (object)[
            "name" => $name,
            "title" => Str::replace("_"," ", Str::title($name)),
        ]);
        if (!$request->get('q')) {
            return $collection;
        } else {
            return $collection->filter(fn($item) => Str::contains($item->name,$request->q) || Str::contains($item->title,$request->q))->values();
        }
    }

}
