<?php

namespace Acacia\Core\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class AcaciaAssetsBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acacia:assets-build {--U|using=npm : Which package manager do you want to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build js and css assets in the acacia Module for production';

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
        $command = \Str::lower($this->option('using')) ==='npm' ? 'npm run build' : 'yarn build';
        $path = "acacia/";
        $this->info("Running $command in $path");
        run_shell_command("cd $path && $command", $this);
        return 0;
    }
}
