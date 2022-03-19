<?php

namespace Acacia\AcaciaSchematics\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Acacia\AcaciaSchematics\Models\Schematic;
use Acacia\AcaciaSchematics\Policies\SchematicPolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Schematic::class => SchematicPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //        $this->registerPolicies();
        //
    }
}
