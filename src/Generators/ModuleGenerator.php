<?php

namespace Savannabits\AcaciaGenerator\Generators;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command as Console;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Savannabits\Acacia\Models\Schematic;
use Savannabits\AcaciaGenerator\Contracts\ActivatorInterface;
use Savannabits\AcaciaGenerator\FileRepository;
use Savannabits\AcaciaGenerator\Module;
use Savannabits\AcaciaGenerator\Support\Config\GenerateConfigReader;
use Savannabits\AcaciaGenerator\Support\Stub;

class ModuleGenerator extends Generator
{
    /**
     * The module name will created.
     *
     * @var string
     */
    protected $name;

    /**
     * The laravel config instance.
     *
     * @var Config
     */
    protected $config;

    /**
     * The laravel filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * The laravel console instance.
     *
     * @var Console
     */
    protected $console;

    /**
     * The activator instance
     *
     * @var ActivatorInterface
     */
    protected $activator;

    /**
     * The module instance.
     *
     * @var Module
     */
    protected $module;

    /**
     * Force status.
     *
     * @var bool
     */
    protected $force = false;

    /**
     * set default module type.
     *
     * @var string
     */
    protected $type = 'web';

    /**
     * Enables the module.
     *
     * @var bool
     */
    protected $isActive = false;
    private ?Schematic $schematic;

    /**
     * The constructor.
     * @param $name
     * @param FileRepository $module
     * @param Config     $config
     * @param Filesystem $filesystem
     * @param Console    $console
     */
    public function __construct(
        $name,
        Schematic $schematic = null,
        FileRepository $module = null,
        Config $config = null,
        Filesystem $filesystem = null,
        Console $console = null,
        ActivatorInterface $activator = null
    ) {
        $this->name = $name;
        $this->schematic = $schematic;
        $this->config = $config;
        $this->filesystem = $filesystem;
        $this->console = $console;
        $this->module = $module;
        $this->activator = $activator;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set active flag.
     *
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active)
    {
        $this->isActive = $active;

        return $this;
    }

    /**
     * Get the name of module will created. By default in studly case.
     *
     * @return string
     */
    public function getName(): string
    {
        if ($this->schematic) {
            return Str::studly($this->schematic->model_class);
        }
        return Str::studly($this->name);
    }

    public function getPluralName(): string
    {
        return Str::plural($this->getName());
    }

    /**
     * Get the laravel config instance.
     *
     * @return Config|null
     */
    public function getConfig(): ?Config
    {
        return $this->config;
    }

    /**
     * Set the laravel config instance.
     *
     * @param Config $config
     *
     * @return $this
     */
    public function setConfig(Config $config): static
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Set the modules activator
     *
     * @param ActivatorInterface $activator
     *
     * @return $this
     */
    public function setActivator(ActivatorInterface $activator): static
    {
        $this->activator = $activator;

        return $this;
    }

    /**
     * Get the laravel filesystem instance.
     *
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Set the laravel filesystem instance.
     *
     * @param Filesystem $filesystem
     *
     * @return $this
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Get the laravel console instance.
     *
     * @return Console|null
     */
    public function getConsole(): ?Console
    {
        return $this->console;
    }

    /**
     * Set the laravel console instance.
     *
     * @param Console $console
     *
     * @return $this
     */
    public function setConsole(Console $console): static
    {
        $this->console = $console;

        return $this;
    }

    /**
     * Get the module instance.
     *
     * @return Module|FileRepository|null
     */
    public function getModule(): Module|FileRepository|null
    {
        return $this->module;
    }

    /**
     * Set the module instance.
     *
     * @param mixed $module
     *
     * @return $this
     */
    public function setModule(mixed $module): static
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get the list of folders will created.
     *
     * @return array
     */
    public function getFolders(): array
    {
        return $this->module->config('paths.generator');
    }

    /**
     * Get the list of files will created.
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->module->config('stubs.files');
    }

    /**
     * Set force status.
     *
     * @param bool|int $force
     *
     * @return $this
     */
    public function setForce(bool|int $force): static
    {
        $this->force = $force;

        return $this;
    }

    /**
     * Generate the module.
     * @throws \Savannabits\AcaciaGenerator\Exceptions\ModuleNotFoundException
     */
    public function generate() : int
    {
        $name = $this->getPluralName();

        if ($this->module->has($name)) {
            if ($this->force) {
                $this->module->delete($name);
            } else {
                $this->console->error("Module [{$name}] already exist!");

                return E_ERROR;
            }
        }

        $this->generateFolders();

        $this->generateModuleJsonFile();

        if ($this->type !== 'plain') {
            $this->generateFiles();
            $this->generateResources();
        }

        if ($this->type === 'plain') {
            $this->cleanModuleJsonFile();
        }

        $this->activator->setActiveByName($name, $this->isActive);

        $this->console->info("Module [{$name}] created successfully.");

        return 0;
    }

    /**
     * Generate the folders.
     */
    public function generateFolders()
    {
        foreach ($this->getFolders() as $key => $folder) {
            $folder = GenerateConfigReader::read($key);

            if ($folder->generate() === false) {
                continue;
            }

            $path = $this->module->getModulePath($this->getPluralName()) . '/' . $folder->getPath();

            $this->filesystem->makeDirectory($path, 0755, true);
            if (config('modules.stubs.gitkeep')) {
                $this->generateGitKeep($path);
            }
        }
    }

    /**
     * Generate git keep to the specified path.
     *
     * @param string $path
     */
    public function generateGitKeep($path)
    {
        $this->filesystem->put($path . '/.gitkeep', '');
    }

    /**
     * Generate the files.
     */
    public function generateFiles()
    {
        foreach ($this->getFiles() as $stub => $file) {
            $path = $this->module->getModulePath($this->getPluralName()) . $file;

            if (!$this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0775, true);
            }

            $this->filesystem->put($path, $this->getStubContents($stub));

            $this->console->info("Created : {$path}");
        }
    }

    /**
     * Generate some resources.
     */
    public function generateResources()
    {
        // Seeder

        if (GenerateConfigReader::read('seeder')->generate() === true) {
            $this->console->call('acacia:make-seed', [
                'name' => $this->getPluralName(),
                'module' => $this->getPluralName(),
                '--master' => true,
            ]);
        }

        // Provider
        if (GenerateConfigReader::read('provider')->generate() === true) {
            $this->console->call('acacia:make-provider', [
                'name' => $this->getPluralName() . 'ServiceProvider',
                'module' => $this->getPluralName(),
                '--master' => true,
            ]);
            $this->console->call('acacia:route-provider', [
                'module' => $this->getPluralName(),
            ]);
        }

        // Factory
        if (GenerateConfigReader::read('model')->generate() === true) {
//            $options = ['--schematic'=> $this->schematic];
            $options = [];
            $this->console->call('acacia:make-factory', [
                    'name' => $this->schematic?->model_class ?: $this->getName(),
                    'module' => $this->getPluralName(),
                ]+$options);
        }
        // Model
        if (GenerateConfigReader::read('model')->generate() === true) {
            $options = ['--schematic'=> $this->schematic];
            $this->console->call('acacia:make-model', [
                    'model' => $this->schematic?->model_class ?: $this->getName(),
                    'module' => $this->getPluralName(),
                ]+$options);
        }

        // Controller
        if (GenerateConfigReader::read('controller')->generate() === true) {
            $options = $this->type=='api' ? ['--api' => true] : [];
            $this->console->call('acacia:make-controller', [
                'controller' =>$this->schematic?->controller_class ?:  $this->getName() . 'Controller',
                'module' => $this->getPluralName(),
            ]+$options);
        }
        // API Controller
        if (GenerateConfigReader::read('api-controller')->generate() === true) {
            $options = ['--api' => true];
            $this->console->call('acacia:make-controller', [
                    'controller' => "Api/".$this->getName() . 'Controller',
                    'module' => $this->getPluralName(),
                ]+$options);
        }
    }

    /**
     * Get the contents of the specified stub file by given stub name.
     *
     * @param $stub
     *
     * @return string
     */
    protected function getStubContents($stub)
    {
        return (new Stub(
            '/' . $stub . '.stub',
            $this->getReplacement($stub)
        )
        )->render();
    }

    /**
     * get the list for the replacements.
     */
    public function getReplacements()
    {
        return $this->module->config('stubs.replacements');
    }

    /**
     * Get array replacement for the specified stub.
     *
     * @param $stub
     *
     * @return array
     */
    protected function getReplacement($stub)
    {
        $replacements = $this->module->config('stubs.replacements');

        if (!isset($replacements[$stub])) {
            return [];
        }

        $keys = $replacements[$stub];

        $replaces = [];

        if ($stub === 'json' || $stub === 'composer') {
            if (in_array('PROVIDER_NAMESPACE', $keys, true) === false) {
                $keys[] = 'PROVIDER_NAMESPACE';
            }
        }
        foreach ($keys as $key) {
            if (method_exists($this, $method = 'get' . ucfirst(Str::studly(strtolower($key))) . 'Replacement')) {
                $replaces[$key] = $this->$method();
            } else {
                $replaces[$key] = null;
            }
        }

        return $replaces;
    }

    /**
     * Generate the module.json file
     */
    private function generateModuleJsonFile()
    {
        $path = $this->module->getModulePath($this->getPluralName()) . 'module.json';

        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0775, true);
        }

        $this->filesystem->put($path, $this->getStubContents('json'));

        $this->console->info("Created : {$path}");
    }

    /**
     * Remove the default service provider that was added in the module.json file
     * This is needed when a --plain module was created
     */
    private function cleanModuleJsonFile()
    {
        $path = $this->module->getModulePath($this->getPluralName()) . 'module.json';

        $content = $this->filesystem->get($path);
        $namespace = $this->getModuleNamespaceReplacement();
        $studlyName = $this->getStudlyNameReplacement();

        $provider = '"' . $namespace . '\\\\' . $studlyName . '\\\\Providers\\\\' . $studlyName . 'ServiceProvider"';

        $content = str_replace($provider, '', $content);

        $this->filesystem->put($path, $content);
    }

    /**
     * @param Schematic|null $schematic
     * @return ModuleGenerator
     */
    public function setSchematic(?Schematic $schematic): ModuleGenerator
    {
        $this->schematic = $schematic;
        return $this;
    }

    /**
     * @return Schematic|null
     */
    public function getSchematic(): ?Schematic
    {
        return $this->schematic;
    }

    /**
     * Get the module name in lower case.
     *
     * @return string
     */
    protected function getLowerNameReplacement()
    {
        return strtolower($this->getPluralName());
    }

    /**
     * Get the module name in studly case.
     *
     * @return string
     */
    protected function getStudlyNameReplacement()
    {
        return $this->getPluralName();
    }

    /**
     * Get replacement for $VENDOR$.
     *
     * @return string
     */
    protected function getVendorReplacement()
    {
        return $this->module->config('composer.vendor');
    }

    /**
     * Get replacement for $MODULE_NAMESPACE$.
     *
     * @return string
     */
    protected function getModuleNamespaceReplacement()
    {
        return str_replace('\\', '\\\\', $this->module->config('namespace'));
    }

    /**
     * Get replacement for $AUTHOR_NAME$.
     *
     * @return string
     */
    protected function getAuthorNameReplacement()
    {
        return $this->module->config('composer.author.name');
    }

    /**
     * Get replacement for $AUTHOR_EMAIL$.
     *
     * @return string
     */
    protected function getAuthorEmailReplacement()
    {
        return $this->module->config('composer.author.email');
    }

    protected function getProviderNamespaceReplacement(): string
    {
        return str_replace('\\', '\\\\', GenerateConfigReader::read('provider')->getNamespace());
    }
}
