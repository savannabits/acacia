<?php

namespace Savannabits\Acacia\Providers;

use Illuminate\Support\ServiceProvider;
use Savannabits\Acacia\Contracts\RepositoryInterface;
use Savannabits\Acacia\Laravel\LaravelFileRepository;

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
