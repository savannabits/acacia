<?php

namespace Acacia\Core\Database\Seeders;

use Acacia\Core\Models\AcaciaMenu;
use Illuminate\Database\Seeder;
use Savannabits\AcaciaGenerator\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AcaciaMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::connection('acacia')->transaction(function (){
            $backendPerm = Permission::query()->firstOrCreate(['name' =>'backend'],[
                'name' => 'backend',
                'guard_name' => 'web'
            ]);
            $genPerm = Permission::query()->firstOrCreate(['name' =>'code.generate'],[
                'name' => 'code.generate',
                'guard_name' => 'web'
            ]);
            $this->command->call('permission:cache-reset');
            $admin = Role::query()->where("name","=","administrator")->first();
            $admin?->givePermissionTo([$backendPerm, $genPerm]);

            AcaciaMenu::query()->truncate();
            $backend = new AcaciaMenu();
            $backend->id = 1;
            $backend->title = "Backend";
            $backend->icon = "pi pi-chart-bar";
            $backend->route = 'acacia.backend.index';
            $backend->active_pattern = "acacia.backend.*";
            $backend->permission_name = $backendPerm?->name;
            $backend->description = "The landing page of the backend module";
            $backend->position = 1;
            $backend->saveOrFail();

            $gen = new AcaciaMenu();
            $gen->id = 2;
            $gen->title = "Code Generator";
            $gen->icon = "pi pi-prime";
            $gen->route = 'acacia.g-panel.index';
            $gen->active_pattern = "acacia.g-panel.*";
            $gen->permission_name = $genPerm?->name;
            $gen->description = "Responsible for generation of modular code during development";
            $gen->position = 0;
            $gen->saveOrFail();

            $modules = \Module::toCollection();
            $i = 0;
            foreach ($modules as $name => $module) {
                if ($name ==='Core') {
                    continue;
                }
                /**
                 * @var Module $module
                 */
                $title = \Str::replace("-"," ",\Str::title($module->getLowerName()));
                $perm = $module->getLowerName().".view-any";
                $menu = new AcaciaMenu();
                $menu->parent_id = 1;
                $menu->title = $title;
                $menu->icon = "pi pi-box";
                $menu->route = 'acacia.backend.'.$module->getLowerName().'.index';
                $menu->active_pattern = "acacia.backend.".$module->getLowerName().".*";
                $menu->position = $i;
                $menu->permission_name = $perm;
                $menu->module_name = $module->getName();
                $menu->description = "Browse the ".$title." Module";
                $menu->saveOrFail();
                $i++;
            }

        });
    }
}
