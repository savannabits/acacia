<?php

namespace Savannabits\Acacia\Commands;

use Illuminate\Console\Command;
use Savannabits\Acacia\Helpers\Helpers;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

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
            Helpers::runShellCommand('rm -rf acacia/');
            if (file_exists(config_path('acacia.php'))) {
                Helpers::runShellCommand('rm -rf '.config_path('acacia.php'));
            }
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
        Helpers::runShellCommand('composer dump-autoload');
        $this->info("3. Enable initial modules");
        $this->call("acacia:enable");
        $this->info("Configure acacia db config temporarily");
        Helpers::configureAcaciaDb();
        Helpers::runShellCommand('composer dump-autoload', $this);
        $this->info("2. Running GPanel Migrations");
        $this->call('migrate:fresh',['--path' => 'acacia/Core/Database/SqliteMigrations', '--database' =>'acacia']);
        $this->info("2. Running Initial Modules Seeders");
        $this->call('acacia:seed');
        $this->info("Ensure breeze is installed");
        $this->call('breeze:install');
        $this->info("Attempt to install the app's npm dependencies");
        Helpers::runShellCommand("npm install && npm run dev", $this);
        $this->info("Attempt to install acacia's npm dependencies");
        Helpers::runShellCommand("cd acacia && npm install && npm run build", $this);
        $this->alert('Installation Complete');
        $this->warn("NB: To install npm dependencies: `cd acacia/ && npm install` or simply run `php artisan acacia:assets-install`");
        $this->warn("NB: to compile npm assets: `cd acacia/ && npm run dev` or `cd acacia/ && npm run build`, or run the command `php artisan acacia:assets-build`");
        return 0;

        /**
        $this->call('acacia:blueprint',['table' => 'Permissions']);
        $this->call('acacia:blueprint',['table' => 'Roles']);
        $this->call('acacia:blueprint',['table' => 'Users']);
         */

    }
}
