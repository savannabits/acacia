<?php

namespace Acacia\AcaciaSchematics\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AcaciaSchematicsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permissions Seeder
        $perms = [
            "acacia-schematics.view-any",
            "acacia-schematics.create",
            "acacia-schematics.view",
            "acacia-schematics.update",
            "acacia-schematics.delete",
            "acacia-schematics.restore",
            "acacia-schematics.force-delete",
            "acacia-schematics.review",
        ];
        try {
            \Savannabits\Acacia\Helpers\Permissions::seedPermissions($perms);
        } catch (\Throwable $e) {
            \Log::info($e);
            abort($e->getMessage());
        }

        // $this->call("OthersTableSeeder");
    }
}
