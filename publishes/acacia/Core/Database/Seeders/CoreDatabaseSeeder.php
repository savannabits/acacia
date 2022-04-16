<?php

namespace Acacia\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class CoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        if (config("acacia.seeder.seed_menu", false)) {
            $this->call(AcaciaMenuSeeder::class);
        }
    }
}
