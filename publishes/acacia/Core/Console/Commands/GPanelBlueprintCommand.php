<?php

namespace Acacia\Core\Console\Commands;

use Acacia\Core\Repos\GPanelRepo;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GPanelBlueprintCommand extends Command
{
    protected $name = 'acacia:blueprint';

    protected $description = 'Generate a blueprint from a given existing table.';

    public function handle()
    {
        $table = \Str::lower($this->argument('table'));
        $force = $this->option('force');
        try {
            $schematic = GPanelRepo::generateBlueprintFromTable($table, $force, $this);
            $this->info("Schematic $schematic?->model_class has been created");
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }

    }
    protected function getOptions(): array
    {
        return [
            ['force','f',InputOption::VALUE_NONE,'Force recreate in case the blueprint exists']
        ];
    }
    protected function getArguments(): array
    {
        return [
            ['table',InputArgument::REQUIRED,'Name of existing table for which to generate a blueprint']
        ];
    }
}
