<?php

namespace Savannabits\AcaciaGenerator\Commands;

use Acacia\Core\Models\Schematic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Savannabits\AcaciaGenerator\Support\Config\GenerateConfigReader;
use Savannabits\AcaciaGenerator\Support\Stub;
use Savannabits\AcaciaGenerator\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    private Schematic|Model|null $schematic;

    public function handle() : int
    {
        if ($this->option('schematic')) {
            $this->schematic = $this->option('schematic');
        } elseif ($this->option('table')) {
            $this->schematic = Schematic::query()->where("table_name","=", trim($this->option('table')))->first();
        } else {
            $err = "Error: You must either pass the --table or --schematic option";
            $this->comment($err);
            abort(400,$err);
        }
        if (!$this->schematic) {
            $err = "We don't know how to generate this controller because it does not have an existing schematic";
            $this->comment($err);
            abort(400,$err);
        }
        if (parent::handle() === E_ERROR) {
            return E_ERROR;
        }
        return 0;
    }

    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'controller';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'acacia:make-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new restful controller for the specified module.';

    /**
     * Get controller name.
     *
     * @return string
     */
    public function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $controllerPath = GenerateConfigReader::read('controller');

        return $path . $controllerPath->getPath() . '/' . $this->getControllerName() . '.php';
    }

    public function getModelNamespace() {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.model.namespace') ?: $module->config('paths.generator.model.path', 'Models');
    }
    public function getRepoNamespace() {
        $module = $this->laravel['modules'];
        return $module->config('paths.generator.repository.namespace') ?: $module->config('paths.generator.repository.path', 'Repositories');
    }
    public function getRequestsNamespace() {
        $module = $this->laravel['modules'];
        return $module->config('paths.generator.request.namespace') ?: $module->config('paths.generator.request.path', 'Http/Requests');
    }
    /**
     * @return string
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'MODULE_NAME'        => $module->getStudlyName(),
            'CONTROLLER_NAME'    => $this->getControllerName(),
            'NAMESPACE'         => $module->getStudlyName(),
            'CLASS_NAMESPACE'   => $this->getClassNamespace($module),
            'CLASS'             => $this->getControllerNameWithoutNamespace(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'NAME'              => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODEL_NAME'        => $this->getModelName(),
            'REPO_NAME'        => $this->getRepositoryName(),
            'MODEL_CAMEL_NAME'  => Str::camel($this->getModelName()),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
            'MODEL_NAMESPACE'  => $this->getModelNamespace(),
            'REPO_NAMESPACE'  => $this->getRepoNamespace(),
            'REQUESTS_NAME'  => $this->getModelName(),
            'REQUESTS_NAMESPACE'  => $this->getRequestsNamespace(),
        ]))->render();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['controller', InputArgument::REQUIRED, 'The name of the controller class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['schematic',null, InputOption::VALUE_OPTIONAL,'The schematic model to use for generation', null],
            ['table',null,InputOption::VALUE_OPTIONAL,'Optional table name to use for generation', null],
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain controller', null],
            ['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the controller.'],
        ];
    }

    /**
     * @return array|string
     */
    protected function getControllerName()
    {
        $controller = Str::studly($this->argument('controller'));

        if (Str::contains(strtolower($controller), 'controller') === false) {
            $controller .= 'Controller';
        }

        return $controller;
    }

    public function getModelName(){
        return $this->schematic?->model_class;
    }
    public function getRepositoryName(): string
    {
        return $this->getModuleName();
    }

    /**
     * @return array|string
     */
    private function getControllerNameWithoutNamespace()
    {
        return class_basename($this->getControllerName());
    }

    public function getDefaultNamespace() : string
    {
        /**
         * @var \Module $module
         */
        $module = $this->laravel['modules'];
        return $module->config('paths.generator.controller.namespace') ?: $module->config('paths.generator.controller.path', 'Http/Controllers');
    }

    /**
     * Get the stub file name based on the options
     * @return string
     */
    protected function getStubName()
    {
        if ($this->option('plain') === true) {
            $stub = '/controller-plain.stub';
        } elseif ($this->option('api') === true) {
            $stub = '/controller-api.stub';
        } else {
            $stub = '/controller.stub';
        }

        return $stub;
    }
}
