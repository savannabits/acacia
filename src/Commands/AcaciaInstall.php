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
    protected $description = 'Acacia Admin generator installer';

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
    public function handle()
    {
        $configOpts =  ['--tag' => 'acacia-config'];
        $moduleOpts =  ['--tag' => 'acacia-modules'];
        $permissions =  ['--provider' => 'Spatie\Permission\PermissionServiceProvider'];
        $scout =  ['--provider' => 'Laravel\Scout\ScoutServiceProvider'];
        $this->alert("Begin Installation");
        $this->info("1. Publishing files");
        $this->info("   a. Publishing acacia configs");
        $this->call("vendor:publish",$configOpts);
        $this->info("   b. Publishing acacia core module");
        $this->call("vendor:publish",$moduleOpts);
        $this->info("   c. Publishing laravel permission config and migration");
        $this->call("vendor:publish",$permissions);
        $this->info("2. Running Migrate Command");
        $this->call('migrate');
        $this->alert('Installation Complete');
        return 0;
    }
}
