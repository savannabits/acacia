<?php

namespace Savannabits\Acacia\Commands;

use Acacia\Core\Models\Schematic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Savannabits\Acacia\Support\Config\GenerateConfigReader;
use Savannabits\Acacia\Support\Stub;
use Savannabits\Acacia\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RequestMakeCommand extends GeneratorCommand
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
    protected $name = 'acacia:make-request';

    private Schematic|Model|null $schematic;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request class for the specified module.';
    private string $type;

    public function handle(): int
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
        $this->type = strtolower($this->option('type'));
        if (!in_array($this->type,['index','view','dt','store','update','destroy'])) {
            $err = "type must be one of index,dt, view, store, update or destroy.";
            $this->comment($err);
            abort(400, $err);
        }
        if (parent::handle() === E_ERROR) {
            return E_ERROR;
        }
        return 0;
    }

    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.request.namespace') ?: $module->config('paths.generator.request.path', 'Http/Requests');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the form request class.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['schematic',null, InputOption::VALUE_OPTIONAL,'The schematic model to use for generation', null],
            ['table',null,InputOption::VALUE_OPTIONAL,'Optional table name to use for generation', null],
            ['type',null,InputOption::VALUE_OPTIONAL,'Either index, store, update or destroy', 'index'],
        ];
    }
    /**
     * @return string
     */
    protected function getTemplateContents(): string
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        $stub = $this->deriveSpecialStub('request');
        return (new Stub($stub, [
            'NAMESPACE' => $this->getClassNamespace($module),
            'CLASS'     => $this->getClass(),
            'MODEL_NAME'        => $this->getModelName(),
            'MODEL_CAMEL_NAME'  => Str::camel($this->getModelName()),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
            'MODULE_NAME'  => $this->getModuleName(),
            'MODEL_NAMESPACE'  => $this->getModelNamespace(),
            'RULES' => $this->makeRules(),
            'POLICY_ARGUMENT' => $this->getPolicyArgument(),
            'REQUEST_PERMISSION' => $this->getRequestPermission(),
        ]))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $requestPath = GenerateConfigReader::read('request');

        return $path . $requestPath->getPath() . '/' . $this->getFileName() . '.php';
    }

    /**
     * @return string
     */
    private function getFileName(): string
    {
        return Str::studly($this->argument('name'));
    }

    public function getRequestPermission(): string
    {
        return match($this->type) {
            "view" => "view",
            "store" => "create",
            "update" => "update",
            "destroy" => "delete",
            default => "viewAny"
        };
    }

    public function getPolicyArgument(): string
    {
        return match($this->type) {
            "view","update","destroy" => '$this->'.Str::snake($this->getModelName()),
            default => $this->getModelName()."::class",
        };
    }

    public function getModelName(){
        return $this->schematic?->model_class;
    }

    public function getModelNamespace() {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.model.namespace') ?: $module->config('paths.generator.model.path', 'Models');
    }

    public function makeRules(): string
    {
        $content = "";
        $rules = (match ($this->type) {
            "index" => $this->makeIndexRules(),
            "store" => $this->makeStoreRules(),
            "update" => $this->makeUpdateRules(),
            "destroy" => $this->makeDestroyRules(),
            default => collect([])
        });
        foreach ($rules as $field => $rule) {
            $content.="'$field' => ".$this->renderRule($rule).",";
        }
        return "[$content]";
    }
    public function renderRule($rules): string
    {
        $content = "[";
        foreach ($rules as $rule) {
            if (Str::contains($rule,"::")) {
                $content.= $rule.',';
            } else {
                $content .= "'".$rule."',";
            }
        }
        $content.="]";
        return $content;
    }
    private function makeIndexRules(): Collection
    {
        $fields = $this->schematic->fields()->where("in_form","=",true)->get();
        $rules = $fields->keyBy("name")->map(fn($field) => collect(json_decode($field->server_validation ?? '[]',true))->get('index'));
        return $rules;
    }
    private function makeStoreRules(): Collection
    {
        $fields = $this->schematic->fields()->where("in_form","=",true)->get();
        $rules = $fields->keyBy("name")->map(fn($field) => collect(json_decode($field->server_validation ?? '[]'))
            ->get('store'));
        // Add belongsTo relationships
        $belongsTos = $this->schematic->relationships()->where("type","=","BelongsTo")->get();
        $bRules = $belongsTos->map(function ($item) {
            $item->snake_method = Str::snake($item->method);
            return $item;
        })->keyBy("snake_method")->map(fn($field) => collect(json_decode($field->server_validation ?? '[]'))
            ->get('store') ?? []);
        if($rules->isEmpty()) {
            return $bRules;
        }
        return $rules->merge($bRules);
    }
    private function makeUpdateRules(): Collection
    {
        $fields = $this->schematic->fields()->where("in_form","=",true)->get();
        $rules = $fields->keyBy("name")->map(fn($field) => collect(json_decode($field->server_validation ?? '[]'))->get('update'));
        $belongsTos = $this->schematic->relationships()->where("type","=","BelongsTo")->get();
        $bRules = $belongsTos->map(function ($item) {
            $item->snake_method = Str::snake($item->method);
            return $item;
        })->keyBy("snake_method")->map(fn($field) => collect(json_decode($field->server_validation ?? '[]'))
            ->get('update') ?? []);
        if($rules->isEmpty()) {
            return $bRules;
        }
        return $rules->merge($bRules);
    }
    private function makeDestroyRules(): Collection
    {
        $rules = collect([]);
        return $rules;
    }
}
