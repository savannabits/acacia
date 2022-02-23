<?php

namespace Savannabits\AcaciaGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Savannabits\AcaciaGenerator\Contracts\RepositoryInterface;
use Savannabits\AcaciaGenerator\Laravel\LaravelFileRepository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, LaravelFileRepository::class);
    }
}
