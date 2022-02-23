<?php

namespace Savannabits\AcaciaGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Savannabits\AcaciaGenerator\Commands\CommandMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ComponentClassMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ComponentViewMakeCommand;
use Savannabits\AcaciaGenerator\Commands\ControllerMakeCommand;
use Savannabits\AcaciaGenerator\Commands\DisableCommand;
use Savannabits\AcaciaGenerator\Commands\DumpCommand;
use Savannabits\AcaciaGenerator\Commands\EnableCommand;
use Savannabits\AcaciaGenerator\Commands\EventMakeCommand;
use Savannabits\AcaciaGenerator\Commands\FactoryMakeCommand;
use Savannabits\AcaciaGenerator\Commands\InstallCommand;
use Savannabits\AcaciaGenerator\Commands\JobMakeCommand;
use Savannabits\AcaciaGenerator\Commands\AcaciaGeneratorV6Migrator;
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

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Namespace of the console commands
     * @var string
     */
    protected $consoleNamespace = "Savannabits\\AcaciaGenerator\\Commands";

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
