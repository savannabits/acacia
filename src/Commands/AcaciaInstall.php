<?php

namespace Savannabits\Acacia\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class AcaciaInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acacia:install {--F|force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Acacia and prepare the app for code generation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $force = $this->option('force');
        $configOpts =  ['--tag' => 'acacia-config'];
        $moduleOpts =  ['--tag' => 'acacia-modules'];
        $permissions =  ['--provider' => 'Spatie\Permission\PermissionServiceProvider'];
        $scout =  ['--provider' => 'Laravel\Scout\ScoutServiceProvider'];
        $this->alert("Begin Installation");
        if ($force) {
            shell_exec('rm -rf acacia/');
        }
        $this->info("1. Publishing files");
        $this->info("   a. Publishing acacia configs");
        $this->call("vendor:publish",$configOpts);
        $this->info("   b. Publishing acacia core module");
        $this->call("vendor:publish",$moduleOpts);
        $this->info("   c. Publishing laravel permission config and migration");
        $this->call("vendor:publish",$permissions);
        $this->info("   d. Publishing laravel scout config");
        $this->call("vendor:publish",$scout);
        $this->info("Dump autoload");
        shell_exec('composer dump-autoload');
        $this->info("Clear the config cache");
        $this->call('config:clear');
        $this->info("3. Enable initial modules");
        $this->call("acacia:enable");
        $this->call("config:clear");
        $this->info("2. Running GPanel Migrations");
        $this->call('migrate:fresh',['--path' => 'acacia/Core/Database/SqliteMigrations', '--database' =>'acacia']);
        $this->info("2. Running Initial Modules Seeders");
        $this->call('acacia:seed');
        $this->call('acacia:blueprint',['table' => 'Permissions']);
        $this->call('acacia:blueprint',['table' => 'Roles']);
        $this->call('acacia:blueprint',['table' => 'Users']);
        $this->info("Ensure breeze is installed");
        $this->call('breeze:install');
        $this->info("Attempt to install npm dependencies");
        run_shell_command("npm install && npm run dev",$this);
        $this->call('acacia:assets-install');
        $this->call('acacia:assets-build');
        $this->warn("Done. NB: to compile assets, `cd acacia/ && npm run dev` or `cd acacia/ && npm run build`");
        $this->alert('Installation Complete');
        return 0;
    }
}
