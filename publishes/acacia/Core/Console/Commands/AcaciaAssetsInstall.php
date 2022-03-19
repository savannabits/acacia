<?php

namespace Acacia\Core\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class AcaciaAssetsInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acacia:assets-install {--U|using=npm : Which package manager do you want to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install assets in the acacia Module';

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
        $command = \Str::lower($this->option('using')) ==='npm' ? 'npm install' : 'yarn install';
        $path ="acacia/";
        $this->alert("Running $command within $path");
        run_shell_command("cd $path && $command install", $this);
        $this->alert("DONE.");
        return 0;
    }
}
