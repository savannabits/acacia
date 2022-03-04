<?php

namespace Savannabits\AcaciaGenerator\Commands;

use Illuminate\Support\Str;
use Savannabits\Acacia\Models\Schematic;
use Savannabits\AcaciaGenerator\Facades\Module;
use Savannabits\AcaciaGenerator\Support\Config\GenerateConfigReader;
use Savannabits\AcaciaGenerator\Support\Stub;
use Savannabits\AcaciaGenerator\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait;

    /**
     * The name of argument name.
     *
     * @var string
     */
    protected $argumentName = 'model';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'acacia:make-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model for the specified module.';

    protected ?Schematic $schematic;
    protected ?string $imports=null;

    public function handle() : int
    {
        $this->schematic = $this->option('schematic');
        if (!$this->schematic) {
            $this->schematic = Schematic::query()->where("model_class", "=", $this->argument('model'))->first();
        }
        if (parent::handle() === E_ERROR) {
            return E_ERROR;
        }

        $this->handleOptionalMigrationOption();

        return 0;
    }

    /**
     * Create a proper migration name:
     * ProductDetail: product_details
     * Product: products
     * @return string
     */
    private function createMigrationName()
    {
        $pieces = preg_split('/(?=[A-Z])/', $this->argument('model'), -1, PREG_SPLIT_NO_EMPTY);

        $string = '';
        foreach ($pieces as $i => $piece) {
            if ($i+1 < count($pieces)) {
                $string .= strtolower($piece) . '_';
            } else {
                $string .= Str::plural(strtolower($piece));
            }
        }

        return $string;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'The name of model will be created.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['schematic',null,InputOption::VALUE_OPTIONAL,'The schematic model to use for generation', null],
            ['fillable', null, InputOption::VALUE_OPTIONAL, 'The fillable attributes.', null],
            ['migration', 'm', InputOption::VALUE_NONE, 'Flag to create associated migrations', null],
        ];
    }

    /**
     * Create the migration file with the given model if migration flag was used
     */
    private function handleOptionalMigrationOption()
    {
        if ($this->option('migration') === true) {
            $migrationName = 'create_' . $this->createMigrationName() . '_table';
            $this->call('acacia:make-migration', ['name' => $migrationName, 'module' => $this->argument('module')]);
        }
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
        $replace = [
            'NAME'              => $this->getModelName(),
            'FILLABLE'          => $this->getFillable(),
            'HIDDEN'          => $this->getHidden(),
            'NAMESPACE'         => $this->getClassNamespace($module),
            'CLASS'             => $this->getClass(),
            'LOWER_NAME'        => $module->getLowerName(),
            'MODULE'            => $this->getModuleName(),
            'STUDLY_NAME'       => $module->getStudlyName(),
            'MODULE_NAMESPACE'  => $this->laravel['modules']->config('namespace'),
            'BELONGS_TO'        => $this->getBelongsTo() ?? "",
            'MORPH_TO'        => $this->getMorphTo() ?? "",
            'IMPORTS'       => ''
        ];
        return (new Stub('/model.stub', $replace))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $modelPath = GenerateConfigReader::read('model');

        return $path . $modelPath->getPath() . '/' . $this->getModelName() . '.php';
    }

    /**
     * @return mixed|string
     */
    private function getModelName()
    {
        return $this->schematic?->model_class ?: Str::studly($this->argument('model'));
    }

    /**
     * @return string
     */
    private function getFillable()
    {
        $fillable = $this->option('fillable');

        if (!is_null($fillable)) {
            $arrays = explode(',', $fillable);

            return json_encode($arrays);
        } elseif($this->schematic) {
            $arrays = $this->schematic->fields()->where("is_guarded","=",false)->get();
            return $arrays?->pluck('name')->toJson();
        }

        return '[]';
    }

    /**
     * @return string|null
     */
    private function getHidden(): ?string
    {
        $arrays = $this->schematic->fields()->where("is_hidden","=",true)->get();
        return $arrays?->pluck('name')->toJson() ?? '[]';
    }


    public function getBelongsTo(): string
    {
        $content = "/********* BELONGS TO **********/\n";
        if ($this->schematic) {
            foreach ($this->schematic->relationships()->where("type","BelongsTo")->get() as $relation) {
                $related = $relation->related;
                if ($related) {
                    $module = Module::find($related?->module_name);
                    $studlyName = $module->getStudlyName();
                    $relatedModel = $related->model_class;
                    $content .= (new Stub('/partials/belongs-to.stub', [
                        "METHOD" => $relation->method,
                        "MODEL"     => "\Acacia\\$studlyName\Models\\$relatedModel",
                        "FK" => $relation->local_key,
                        "RELATED_KEY" => $relation->related_key,
                    ]))->render();
                }
            }
        }
        return $content;
    }
    public function getMorphTo(): string
    {
        $content = "/********* MORPH TO **********/\n";
        if ($this->schematic) {
            foreach ($this->schematic->relationships()->where("type","MorphTo")->get() as $relation) {
                $content .= (new Stub('/partials/morph-to.stub', [
                    "METHOD" => $relation->method,
                ]))->render()."\n";
            }
        }
        return $content;
    }


    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.model.namespace') ?: $module->config('paths.generator.model.path', 'Models');
    }
}
