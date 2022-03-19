<?php

namespace Savannabits\Acacia\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Savannabits\Acacia\Commands\AcaciaInstall;
use Savannabits\Acacia\Commands\CommandMakeCommand;
use Savannabits\Acacia\Commands\ComponentClassMakeCommand;
use Savannabits\Acacia\Commands\ComponentViewMakeCommand;
use Savannabits\Acacia\Commands\ControllerMakeCommand;
use Savannabits\Acacia\Commands\DisableCommand;
use Savannabits\Acacia\Commands\DumpCommand;
use Savannabits\Acacia\Commands\EnableCommand;
use Savannabits\Acacia\Commands\EventMakeCommand;
use Savannabits\Acacia\Commands\FactoryMakeCommand;
use Savannabits\Acacia\Commands\InstallCommand;
use Savannabits\Acacia\Commands\JobMakeCommand;
use Savannabits\Acacia\Commands\AcaciaV6Migrator;
use Savannabits\Acacia\Commands\ListCommand;
use Savannabits\Acacia\Commands\ListenerMakeCommand;
use Savannabits\Acacia\Commands\MailMakeCommand;
use Savannabits\Acacia\Commands\MiddlewareMakeCommand;
use Savannabits\Acacia\Commands\MigrateCommand;
use Savannabits\Acacia\Commands\MigrateRefreshCommand;
use Savannabits\Acacia\Commands\MigrateResetCommand;
use Savannabits\Acacia\Commands\MigrateRollbackCommand;
use Savannabits\Acacia\Commands\MigrateStatusCommand;
use Savannabits\Acacia\Commands\MigrationMakeCommand;
use Savannabits\Acacia\Commands\ModelMakeCommand;
use Savannabits\Acacia\Commands\ModuleDeleteCommand;
use Savannabits\Acacia\Commands\ModuleMakeCommand;
use Savannabits\Acacia\Commands\NotificationMakeCommand;
use Savannabits\Acacia\Commands\PolicyMakeCommand;
use Savannabits\Acacia\Commands\ProviderMakeCommand;
use Savannabits\Acacia\Commands\PublishCommand;
use Savannabits\Acacia\Commands\PublishConfigurationCommand;
use Savannabits\Acacia\Commands\PublishMigrationCommand;
use Savannabits\Acacia\Commands\PublishTranslationCommand;
use Savannabits\Acacia\Commands\RepositoryMakeCommand;
use Savannabits\Acacia\Commands\RequestMakeCommand;
use Savannabits\Acacia\Commands\ResourceMakeCommand;
use Savannabits\Acacia\Commands\RouteProviderMakeCommand;
use Savannabits\Acacia\Commands\RuleMakeCommand;
use Savannabits\Acacia\Commands\SeedCommand;
use Savannabits\Acacia\Commands\SeedMakeCommand;
use Savannabits\Acacia\Commands\SetupCommand;
use Savannabits\Acacia\Commands\TestMakeCommand;
use Savannabits\Acacia\Commands\UnUseCommand;
use Savannabits\Acacia\Commands\UpdateCommand;
use Savannabits\Acacia\Commands\UseCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Namespace of the console commands
     * @var string
     */
    protected $consoleNamespace = "Savannabits\\Acacia\\Commands";

    /**
     * The available commands
     * @var array
     */
    protected $commands = [
        AcaciaInstall::class,
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
        RepositoryMakeCommand::class,
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
        AcaciaV6Migrator::class,
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
