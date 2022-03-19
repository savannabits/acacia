<?php

namespace Acacia\AcaciaFields\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AcaciaFieldsDatabaseSeeder extends Seeder
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
            "acacia-fields.view-any",
            "acacia-fields.create",
            "acacia-fields.view",
            "acacia-fields.update",
            "acacia-fields.delete",
            "acacia-fields.restore",
            "acacia-fields.force-delete",
            "acacia-fields.review",
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
