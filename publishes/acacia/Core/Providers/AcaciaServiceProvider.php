<?php

namespace Acacia\Core\Providers;

use Acacia\Core\Console\Commands\AssignRoleCommand;
use Acacia\Core\Console\Commands\GPanelBlueprintCommand;
use App\Http\Kernel;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Acacia\Core\Console\Commands\AcaciaAssetsBuild;
use Acacia\Core\Console\Commands\AcaciaAssetsDev;
use Acacia\Core\Console\Commands\AcaciaAssetsInstall;
use Illuminate\Support\Str;

class AcaciaServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->commands([
            AcaciaAssetsInstall::class,
            AcaciaAssetsDev::class,
            AcaciaAssetsBuild::class,
            GPanelBlueprintCommand::class,
            AssignRoleCommand::class,
        ]);
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $kernel->appendMiddlewareToGroup("web",\Acacia\Core\Http\Middleware\HandleInertiaRequests::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        config(['database.connections.acacia' => array(
            'driver' => 'sqlite',
            'url' => '',
            'database' => module_path('Core','Database/acacia.sqlite'),
            'prefix' => '',
            'foreign_key_constraints' => true,
        )]);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
        \Blade::anonymousComponentNamespace('components',$this->moduleNameLower);
        \Blade::componentNamespace('Acacia\\Core\\Components',$this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
