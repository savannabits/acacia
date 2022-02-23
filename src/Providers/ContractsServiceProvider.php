<?php

namespace Savannabits\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Savannabits\Modules\Contracts\RepositoryInterface;
use Savannabits\Modules\Laravel\LaravelFileRepository;

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
