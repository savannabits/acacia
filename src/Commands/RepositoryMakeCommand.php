<?php

namespace Savannabits\AcaciaGenerator\Commands;

use Illuminate\Support\Str;
use Savannabits\Acacia\Models\Schematic;
use Savannabits\AcaciaGenerator\Module;
use Savannabits\AcaciaGenerator\Support\Config\GenerateConfigReader;
use Savannabits\AcaciaGenerator\Support\Stub;
use Savannabits\AcaciaGenerator\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RepositoryMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'acacia:make-repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class for the specified module.';
    private Schematic|null $schematic;
    private string|null $table_name;

    public function handle(): int
    {
        $this->schematic = $this->option('schematic');
        $this->table_name = $this->option('table');
        if (!$this->schematic && !$this->table_name) {
            $this->comment("Either --schematic or --table option has to be specified");
            return 1;
        }
        if (!$this->schematic) {
            $this->schematic = Schematic::query()->where("table_name","=", $this->table_name)->first();
        }
        if (!$this->schematic) {
            $this->comment("No existing schematic could be found for $this->table_name. Please create one first.");
            return 1;
        }
        return parent::handle();
    }
    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.repository.namespace') ?: $module->config('paths.generator.repository.path', 'Repositories');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the policy class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            [
                'schematic',
                null,
                InputOption::VALUE_OPTIONAL,
                'Schematic to be used for generation',
            ],
            [
                'table',
                null,
                InputOption::VALUE_OPTIONAL,
                'Schematic to be used for generation',
            ],
        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
        /**
         * @var Module $modelModule
         */
        $modelModule = $this->laravel['modules']->findOrFail($this->schematic->module_name);
        return (new Stub('/repository.stub', [
            'NAMESPACE' => $this->getClassNamespace($module),
            'MODEL_NAMESPACE' => '\Acacia\\'.$modelModule->getStudlyName()."\Models\\".$this->schematic->model_class,
            'MODEL_NAME' => $this->schematic->model_class,
            'BASE_PERMISSION' => $modelModule->getLowerName(),
            'CLASS'     => $this->getClass(),
            'METHODS'  => $this->buildMethods(),
            'BELONGS_TO_ARRAY' => $this->getBelongsTos(),
        ]))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $classPath = GenerateConfigReader::read('repository');

        return $path . $classPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    private function getFileName()
    {
        return Str::studly($this->argument('name'));
    }
    private function buildMethods(): string
    {
        return (new Stub('/partials/repository/methods.stub',[
            'MODEL_NAME' => $this->schematic->model_class,
        ]))->render();
    }
    private function getBelongsTos(): string
    {
        return $this->schematic->relationships()->where("type","=","BelongsTo")
            ->get()->pluck("method")->values()->toJson();
    }
}
