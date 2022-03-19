<?php

namespace Acacia\Permissions\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionsDatabaseSeeder extends Seeder
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
            "permissions.view-any",
            "permissions.create",
            "permissions.view",
            "permissions.update",
            "permissions.delete",
            "permissions.restore",
            "permissions.force-delete",
            "permissions.review",
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
