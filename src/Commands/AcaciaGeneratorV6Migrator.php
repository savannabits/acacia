<?php

declare(strict_types=1);

namespace Savannabits\AcaciaGenerator\Commands;

use Illuminate\Console\Command;
use Savannabits\AcaciaGenerator\Contracts\RepositoryInterface;
use Savannabits\AcaciaGenerator\Module;

class AcaciaGeneratorV6Migrator extends Command
{
    protected $name = 'acacia:v6:migrate';
    protected $description = 'Migrate acacia-generator v5 modules statuses to v6.';

    public function handle() : int
    {
        $moduleStatuses = [];
        /** @var RepositoryInterface $modules */
        $modules = $this->laravel['modules'];

        $modules = $modules->all();
        /** @var Module $module */
        foreach ($modules as $module) {
            if ($module->json()->get('active') === 1) {
                $module->enable();
                $moduleStatuses[] = [$module->getName(), 'Enabled'];
            }
            if ($module->json()->get('active') === 0) {
                $module->disable();
                $moduleStatuses[] = [$module->getName(), 'Disabled'];
            }
        }
        $this->info('All modules have been migrated.');
        $this->table(['Module name', 'Status'], $moduleStatuses);

        return 0;
    }
}
