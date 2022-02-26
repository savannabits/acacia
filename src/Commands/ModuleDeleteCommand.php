<?php

namespace Savannabits\AcaciaGenerator\Commands;

use Acacia\Core\Entities\AcaciaMenu;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ModuleDeleteCommand extends Command
{
    protected $name = 'acacia:delete';
    protected $description = 'Delete a module from the application';

    public function handle() : int
    {
        $name = $this->argument('module');
        $lowerName = \Str::slug(\Str::pluralStudly($name));
        $route = "acacia.backend.$lowerName.index";
        AcaciaMenu::query()->where("route","=", $route)->forceDelete();
        $this->laravel['modules']->delete($this->argument('module'));
        $this->info("Module {$this->argument('module')} has been deleted.");

        return 0;
    }

    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The name of module to delete.'],
        ];
    }
}
