<?php

use Savannabits\AcaciaGenerator\Activators\FileActivator;
use Savannabits\AcaciaGenerator\Commands\AcaciaGeneratorV6Migrator;
use Savannabits\AcaciaGenerator\Commands\CommandMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ControllerMakeCommand;
use Savannabits\AcaciaGenerator\Commands\DisableCommand;
use Savannabits\AcaciaGenerator\Commands\DumpCommand;
use Savannabits\AcaciaGenerator\Commands\EnableCommand;
use Savannabits\AcaciaGenerator\Commands\EventMakeCommand;
use Savannabits\AcaciaGenerator\Commands\FactoryMakeCommand;
use Savannabits\AcaciaGenerator\Commands\InstallCommand;
use Savannabits\AcaciaGenerator\Commands\JobMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ListCommand;
use Savannabits\AcaciaGenerator\Commands\ListenerMakeCommand;
use Savannabits\AcaciaGenerator\Commands\MailMakeCommand;
use Savannabits\AcaciaGenerator\Commands\MiddlewareMakeCommand;
use Savannabits\AcaciaGenerator\Commands\MigrateCommand;
use Savannabits\AcaciaGenerator\Commands\MigrateRefreshCommand;
use Savannabits\AcaciaGenerator\Commands\MigrateResetCommand;
use Savannabits\AcaciaGenerator\Commands\MigrateRollbackCommand;
use Savannabits\AcaciaGenerator\Commands\MigrateStatusCommand;
use Savannabits\AcaciaGenerator\Commands\MigrationMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ModelMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ModuleDeleteCommand;
use Savannabits\AcaciaGenerator\Commands\ModuleMakeCommand;
use Savannabits\AcaciaGenerator\Commands\NotificationMakeCommand;
use Savannabits\AcaciaGenerator\Commands\PolicyMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ProviderMakeCommand;
use Savannabits\AcaciaGenerator\Commands\PublishCommand;
use Savannabits\AcaciaGenerator\Commands\PublishConfigurationCommand;
use Savannabits\AcaciaGenerator\Commands\PublishMigrationCommand;
use Savannabits\AcaciaGenerator\Commands\PublishTranslationCommand;
use Savannabits\AcaciaGenerator\Commands\RequestMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ResourceMakeCommand;
use Savannabits\AcaciaGenerator\Commands\RouteProviderMakeCommand;
use Savannabits\AcaciaGenerator\Commands\RuleMakeCommand;
use Savannabits\AcaciaGenerator\Commands\SeedCommand;
use Savannabits\AcaciaGenerator\Commands\SeedMakeCommand;
use Savannabits\AcaciaGenerator\Commands\SetupCommand;
use Savannabits\AcaciaGenerator\Commands\TestMakeCommand;
use Savannabits\AcaciaGenerator\Commands\UnUseCommand;
use Savannabits\AcaciaGenerator\Commands\UpdateCommand;
use Savannabits\AcaciaGenerator\Commands\UseCommand;

return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    'namespace' => 'Acacia',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => true,
        'path' => base_path() . '/vendor/savannabits/acacia-generator/src/Commands/stubs',
        'files' => [
            'routes/web' => 'Routes/web.php',
            'routes/api' => 'Routes/api.php',
            'views/index' => 'resources/views/index.blade.php',
            'views/master' => 'resources/views/layouts/master.blade.php',
            'scaffold/config' => 'Config/config.php',
            'composer' => 'composer.json',
            'assets/js/app' => 'resources/assets/js/app.js',
            'assets/sass/app' => 'resources/assets/sass/app.scss',
            'js/pages/index' => 'Js/Pages/Index.vue',
            'js/pages/create' => 'Js/Pages/Create.vue',
            'js/pages/edit' => 'Js/Pages/Edit.vue',
            'js/pages/partials/create-form' => 'Js/Pages/Partials/CreateForm.vue',
            'js/pages/partials/edit-form' => 'Js/Pages/Partials/EditForm.vue',
            'webpack' => 'webpack.mix.js',
            'package' => 'package.json',
        ],
        'replacements' => [
            'routes/web' => ['LOWER_NAME', 'STUDLY_SINGULAR_NAME'],
            'routes/api' => ['LOWER_NAME', 'STUDLY_SINGULAR_NAME'],
            'webpack' => ['LOWER_NAME'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['LOWER_NAME', 'STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'js/pages/index' => ['LOWER_NAME','STUDLY_NAME','JS_INDEX_COLUMNS','JS_INDEX_TITLE','JS_INDEX_SEARCHABLE_COLS'],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
            ],
        ],
        'gitkeep' => true,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path('acacia'),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path('acacia-modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'acacia:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'config'    => ['path' => 'Config', 'generate' => true],
            'command'   => ['path' => 'Console', 'generate' => true],
            'migration' => ['path' => 'Database/Migrations', 'generate' => true],
            'seeder'    => ['path' => 'Database/Seeders', 'generate' => true],
            'factory'   => ['path' => 'Database/Factories', 'generate' => true],
            'model'     => ['path' => 'Entities', 'generate' => true],
            'routes'    => ['path' => 'Routes', 'generate' => true],
            'controller'=> ['path' => 'Http/Controllers', 'generate' => true],
            'api-controller' => ['path' => 'Http/Controllers/Api', 'generate' => true],
            'filter'    => ['path' => 'Http/Middleware', 'generate' => true],
            'request'   => ['path' => 'Http/Requests', 'generate' => true],
            'provider'  => ['path' => 'Providers', 'generate' => true],
            'assets'    => ['path' => 'resources/assets', 'generate' => true],
            'lang'      => ['path' => 'resources/lang', 'generate' => true],
            'views'     => ['path' => 'resources/views', 'generate' => true],
            'test'      => ['path' => 'tests/Unit', 'generate' => true],
            'test-feature' => ['path' => 'tests/Feature', 'generate' => true],
            'repository'        => ['path' => 'Repositories', 'generate' => false],
            'event'             => ['path' => 'Events', 'generate' => false],
            'listener'          => ['path' => 'Listeners', 'generate' => false],
            'policies'          => ['path' => 'Policies', 'generate' => false],
            'rules'             => ['path' => 'Rules', 'generate' => false],
            'jobs'              => ['path' => 'Jobs', 'generate' => false],
            'emails'            => ['path' => 'Emails', 'generate' => false],
            'notifications'     => ['path' => 'Notifications', 'generate' => false],
            'resource'          => ['path' => 'Transformers', 'generate' => false],
            'component-view'    => ['path' => 'resources/views/components', 'generate' => false],
            'component-class'   => ['path' => 'View/Component', 'generate' => false],
            'vue-pages'         => ['path' => 'Js/Pages', 'generate' => true],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example you don't use some of the commands provided
    | you can simply comment them out.
    |
    */
    'commands' => [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        InstallCommand::class,
        ListCommand::class,
        ModuleDeleteCommand::class,
        ModuleMakeCommand::class,
        FactoryMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        PublishCommand::class,
        PublishConfigurationCommand::class,
        PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        UpdateCommand::class,
        UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        AcaciaGeneratorV6Migrator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        'enabled' => false,
        'paths' => [
            base_path('vendor/*/*'),
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    |
    */

    'composer' => [
        'vendor' => 'savannabits',
        'author' => [
            'name' => 'Samson Maosa',
            'email' => 'maosa.sam@gmail.com',
        ],
    ],

    'composer-output' => false,

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        'enabled' => false,
        'key' => 'acacia-generator',
        'lifetime' => 60,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what acacia-generator will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    'register' => [
        'translations' => true,
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],

    'activator' => 'file',
];
