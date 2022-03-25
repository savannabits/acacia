<?php

namespace Savannabits\Acacia\Helpers;

use Symfony\Component\Process\Process;

class Helpers
{
    public static function configureAcaciaDb() {
        config(['database.connections.acacia' => array(
            'driver' => 'sqlite',
            'url' => '',
            'database' => module_path('Core','Database/acacia.sqlite'),
            'prefix' => '',
            'foreign_key_constraints' => true,
        )]);
    }

    public static function runShellCommand(string $command, $console = null)
    {
        $process = Process::fromShellCommandline($command);
        $process->start();
        foreach ($process as $type => $data) {
            if ($process::OUT === $type) {
                if ($console)
                    $console->info(trim($data));
            } else {
                // $process::ERR === $type
                if ($console)
                    $console->warn(trim($data));
            }
        }
    }
}
