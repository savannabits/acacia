<?php

namespace Acacia\AcaciaMenus\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AcaciaMenusDatabaseSeeder extends Seeder
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
            "acacia-menus.view-any",
            "acacia-menus.create",
            "acacia-menus.view",
            "acacia-menus.update",
            "acacia-menus.delete",
            "acacia-menus.restore",
            "acacia-menus.force-delete",
            "acacia-menus.review",
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
