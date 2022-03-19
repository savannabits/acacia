<?php

namespace Acacia\AcaciaRelationships\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AcaciaRelationshipsDatabaseSeeder extends Seeder
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
            "acacia-relationships.view-any",
            "acacia-relationships.create",
            "acacia-relationships.view",
            "acacia-relationships.update",
            "acacia-relationships.delete",
            "acacia-relationships.restore",
            "acacia-relationships.force-delete",
            "acacia-relationships.review",
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
