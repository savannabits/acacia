<?php

namespace Acacia\Roles\Database\Seeders;

use Acacia\Roles\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RolesDatabaseSeeder extends Seeder
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
            "roles.view-any",
            "roles.create",
            "roles.view",
            "roles.update",
            "roles.delete",
            "roles.restore",
            "roles.force-delete",
            "roles.review",
        ];
        try {
            // Create administrator if not existing
            DB::table(config('permission.table_names.roles','roles'))
                ->where('name','=','administrator')
                ->existsOr(function () {
                    DB::table(config('permission.table_names.roles','roles'))->insertGetId([
                        'name' =>'administrator',
                        'guard_name' => 'web',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
            });
            \Savannabits\Acacia\Helpers\Permissions::seedPermissions($perms);
        } catch (\Throwable $e) {
            \Log::info($e);
            abort($e->getMessage());
        }

        // $this->call("OthersTableSeeder");
    }
}
