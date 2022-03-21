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
            $acPerm = Permission::query()->firstOrCreate(['name' =>'access-control'],[
                'name' => 'access-control',
                'guard_name' => 'web'
            ]);
            $this->command->call('permission:cache-reset');
            $admin = Role::query()->firstOrCreate(["name" => "administrator"],["name" => "administrator","guard_name" => "web"]);
            $admin?->givePermissionTo([$backendPerm, $genPerm, $acPerm]);

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
            $gen->title = "G-Panel";
            $gen->icon = "pi pi-prime";
            $gen->route = 'acacia.g-panel.index';
            $gen->active_pattern = "acacia.g-panel.*";
            $gen->permission_name = $genPerm?->name;
            $gen->description = "Responsible for generation of modular code during development";
            $gen->position = 0;
            $gen->saveOrFail();

            $gen = new AcaciaMenu();
            $gen->id = 3;
            $gen->parent_id = 2;
            $gen->title = "Generate Code";
            $gen->icon = "pi pi-code";
            $gen->route = 'acacia.g-panel.index';
            $gen->active_pattern = "acacia.g-panel.index";
            $gen->permission_name = $genPerm?->name;
            $gen->description = "Responsible for generation of modular code during development";
            $gen->position = 0;
            $gen->saveOrFail();

            $gen = new AcaciaMenu();
            $gen->id = 4;
            $gen->title = "Access Control";
            $gen->icon = "pi pi-lock";
            $gen->active_pattern = "acacia.auth.*";
            $gen->permission_name = $acPerm?->name;
            $gen->description = "Manage Users, Roles and Permissions";
            $gen->position = 2;
            $gen->saveOrFail();


            $gpanelModules = ["AcaciaMenus","AcaciaFields","AcaciaRelationships","AcaciaSchematics"];
            $authModules = ["Users","Roles","Permissions"];

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
                if (in_array($name, $gpanelModules)) {
                    $menu->parent_id = 2;
                    $menu->route = "acacia.g-panel.".$module->getLowerName().".index";
                    $title = \Str::replace("-"," ", \Str::title(str_replace("acacia-","",$module->getLowerName())));
                    $menu->title = $title;
                    $menu->active_pattern = "acacia.g-panel.".$module->getLowerName().".*";
                } elseif (in_array($name, $authModules)) {
                    $menu->parent_id = 4;
                    $menu->route = "acacia.auth.".$module->getLowerName().".index";
                    $menu->title = $title;
                    $menu->active_pattern = "acacia.auth.".$module->getLowerName().".*";
                }
                $menu->saveOrFail();
                $i++;
            }

        });
    }
}
