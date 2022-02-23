<?php

namespace Savannabits\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Savannabits\Modules\Commands\CommandMakeCommand;
use Savannabits\Modules\Commands\ComponentClassMakeCommand;
use Savannabits\Modules\Commands\ComponentViewMakeCommand;
use Savannabits\Modules\Commands\ControllerMakeCommand;
use Savannabits\Modules\Commands\DisableCommand;
use Savannabits\Modules\Commands\DumpCommand;
use Savannabits\Modules\Commands\EnableCommand;
use Savannabits\Modules\Commands\EventMakeCommand;
use Savannabits\Modules\Commands\FactoryMakeCommand;
use Savannabits\Modules\Commands\InstallCommand;
use Savannabits\Modules\Commands\JobMakeCommand;
use Savannabits\Modules\Commands\AcaciaGeneratorV6Migrator;
use Savannabits\Modules\Commands\ListCommand;
use Savannabits\Modules\Commands\ListenerMakeCommand;
use Savannabits\Modules\Commands\MailMakeCommand;
use Savannabits\Modules\Commands\MiddlewareMakeCommand;
use Savannabits\Modules\Commands\MigrateCommand;
use Savannabits\Modules\Commands\MigrateRefreshCommand;
use Savannabits\Modules\Commands\MigrateResetCommand;
use Savannabits\Modules\Commands\MigrateRollbackCommand;
use Savannabits\Modules\Commands\MigrateStatusCommand;
use Savannabits\Modules\Commands\MigrationMakeCommand;
use Savannabits\Modules\Commands\ModelMakeCommand;
use Savannabits\Modules\Commands\ModuleDeleteCommand;
use Savannabits\Modules\Commands\ModuleMakeCommand;
use Savannabits\Modules\Commands\NotificationMakeCommand;
use Savannabits\Modules\Commands\PolicyMakeCommand;
use Savannabits\Modules\Commands\ProviderMakeCommand;
use Savannabits\Modules\Commands\PublishCommand;
use Savannabits\Modules\Commands\PublishConfigurationCommand;
use Savannabits\Modules\Commands\PublishMigrationCommand;
use Savannabits\Modules\Commands\PublishTranslationCommand;
use Savannabits\Modules\Commands\RequestMakeCommand;
use Savannabits\Modules\Commands\ResourceMakeCommand;
use Savannabits\Modules\Commands\RouteProviderMakeCommand;
use Savannabits\Modules\Commands\RuleMakeCommand;
use Savannabits\Modules\Commands\SeedCommand;
use Savannabits\Modules\Commands\SeedMakeCommand;
use Savannabits\Modules\Commands\SetupCommand;
use Savannabits\Modules\Commands\TestMakeCommand;
use Savannabits\Modules\Commands\UnUseCommand;
use Savannabits\Modules\Commands\UpdateCommand;
use Savannabits\Modules\Commands\UseCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Namespace of the console commands
     * @var string
     */
    protected $consoleNamespace = "Savannabits\\Modules\\Commands";

    /**
     * The available commands
     * @var array
     */
    protected $commands = [
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
        ComponentClassMakeCommand::class,
        ComponentViewMakeCommand::class,
    ];

    public function register(): void
    {
        $this->commands($this->resolveCommands());
    }

    private function resolveCommands(): array
    {
        $commands = [];

        foreach (config('modules.commands', $this->commands) as $command) {
            $commands[] = Str::contains($command, $this->consoleNamespace) ?
                $command :
                $this->consoleNamespace . "\\" . $command;
        }

        return $commands;
    }

    public function provides(): array
    {
        return $this->commands;
    }
}
