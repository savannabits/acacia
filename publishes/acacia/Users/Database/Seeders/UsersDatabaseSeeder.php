<?php

namespace Acacia\Users\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class UsersDatabaseSeeder extends Seeder
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
            "users.view-any",
            "users.create",
            "users.view",
            "users.update",
            "users.delete",
            "users.restore",
            "users.force-delete",
            "users.review",
        ];
        try {// Create default admin user
            $user = User::firstOrCreate(['email' => 'admin@savannabits.com'],[
                'email' => 'admin@savannabits.com',
                'name' => 'System Admin',
                'email_verified_at' => now(),
                'password' => \Hash::make('password'),
            ]);

            // Give admin role
            $admin = Role::query()->where('name','=','administrator')->first();
            $user->roles()->save($admin);
            \Savannabits\Acacia\Helpers\Permissions::seedPermissions($perms);
        } catch (\Throwable $e) {
            \Log::info($e);
            abort(500, $e->getMessage());
        }

        // $this->call("OthersTableSeeder");
    }
}
