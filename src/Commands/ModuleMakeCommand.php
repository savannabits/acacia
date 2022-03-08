<?php

namespace Savannabits\AcaciaGenerator\Commands;

use Acacia\Core\Models\Schematic;
use Illuminate\Console\Command;
use Savannabits\AcaciaGenerator\Contracts\ActivatorInterface;
use Savannabits\AcaciaGenerator\Generators\ModuleGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModuleMakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'acacia:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module.';

    /**
     * Execute the console command.
     * @throws \Savannabits\AcaciaGenerator\Exceptions\ModuleNotFoundException
     */
    public function handle() : int
    {
        $names = $this->argument('table');
        $success = true;

        foreach ($names as $name) {
            $schematic = Schematic::query()->where("table_name","=", $name)->first();
            if (!$schematic) {
                \Log::info("Not Found");
                $this->warn("Schematic for $name not found.");
                continue;
            }
            $runMigrations = $this->hasOption('yes') ? "yes": ($this->hasOption("no") ? "no": 'prompt');
            $code = with(new ModuleGenerator($schematic->model_class))
                ->setSchematic($schematic)
                ->setFilesystem($this->laravel['files'])
                ->setModule($this->laravel['modules'])
                ->setConfig($this->laravel['config'])
                ->setActivator($this->laravel[ActivatorInterface::class])
                ->setConsole($this)
                ->setForce($this->option('force'))
                ->setType($this->getModuleType())
                ->setActive(!$this->option('disabled'))
                ->setRunMigrations($runMigrations)
                ->generate();

            if ($code === E_ERROR) {
                $success = false;
            }
        }

        return $success ? 0 : E_ERROR;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['table', InputArgument::IS_ARRAY, 'The table names for the modules that will be will be generated.'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain module (without some resources).'],
            ['api', null, InputOption::VALUE_NONE, 'Generate an api module.'],
            ['web', null, InputOption::VALUE_NONE, 'Generate a web module.'],
            ['disabled', 'd', InputOption::VALUE_NONE, 'Do not enable the module at creation.'],
            ['force', 'F', InputOption::VALUE_NONE, 'Force the operation to run when the module already exists.'],
            ['yes', 'y', InputOption::VALUE_NONE, 'Automatically run migrations for permissions NOW instead of prompting'],
            ['no', null, InputOption::VALUE_NONE, 'Automatically run migrations for permissions LATER instead of prompting'],
        ];
    }

    /**
    * Get module type .
    *
    * @return string
    */
    private function getModuleType()
    {
        $isPlain = $this->option('plain');
        $isApi = $this->option('api');

        if ($isPlain && $isApi) {
            return 'web';
        }
        if ($isPlain) {
            return 'plain';
        } elseif ($isApi) {
            return 'api';
        } else {
            return 'web';
        }
    }
}
