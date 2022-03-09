<?php

namespace Savannabits\Acacia\Commands;

use Acacia\Core\Models\Schematic;
use Illuminate\Support\Str;
use Savannabits\Acacia\Support\Config\GenerateConfigReader;
use Savannabits\Acacia\Support\Stub;
use Savannabits\Acacia\Traits\CanClearModulesCache;
use Savannabits\Acacia\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SeedMakeCommand extends GeneratorCommand
{
    use ModuleCommandTrait, CanClearModulesCache;

    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'acacia:make-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new seeder for the specified module.';
    private Schematic|null $schematic;
    private ?string $table_name;

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

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of seeder will be created.'],
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
            [
                'master',
                null,
                InputOption::VALUE_NONE,
                'Indicates the seeder will created is a master database seeder.',
            ],
            [
                'permissions',
                null,
                InputOption::VALUE_NONE,
                'Indicate that this is a permissions seeder.',
            ],
            [
                'schematic',
                null,
                InputOption::VALUE_OPTIONAL,
                'Schematic to be used for seeder generation',
            ],
            [
                'table',
                null,
                InputOption::VALUE_OPTIONAL,
                'Schematic to be used for seeder generation',
            ],

        ];
    }

    /**
     * @return mixed
     */
    protected function getTemplateContents()
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub('/seeder.stub', [
            'NAME' => $this->getSeederName(),
            'MODULE' => $this->getModuleName(),
            'NAMESPACE' => $this->getClassNamespace($module),
            'PERMISSIONS_CONTENT' => $this->getPermissionsSeederContent(),

        ]))->render();
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath()
    {
        $this->clearCache();

        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $seederPath = GenerateConfigReader::read('seeder');

        return $path . $seederPath->getPath() . '/' . $this->getSeederName() . '.php';
    }

    /**
     * Get seeder name.
     *
     * @return string
     */
    private function getSeederName()
    {
        $end = $this->option('master') ? 'DatabaseSeeder' : 'TableSeeder';

        return Str::studly($this->argument('name')) . $end;
    }

    /**
     * Get default namespace.
     *
     * @return string
     */
    public function getDefaultNamespace() : string
    {
        $module = $this->laravel['modules'];

        return $module->config('paths.generator.seeder.namespace') ?: $module->config('paths.generator.seeder.path', 'Database/Seeders');
    }
    private function getPermissionsSeederContent(): string
    {
        $content = "// TODO: Implement Seeding Logic";
        if (!$this->hasOption('permissions')) {
            return $content;
        } else {
            $content = (new Stub("/partials/seeder/permissions.stub",[
                "LOWER_NAME" => \Module::find($this->getModuleName())->getLowerName()
            ]))->render();
        }
        return $content;
    }
}
