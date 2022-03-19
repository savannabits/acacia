<?php

namespace Acacia\AcaciaMenus\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Acacia\AcaciaMenus\Models\Menu;
use Acacia\AcaciaMenus\Policies\MenuPolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Menu::class => MenuPolicy::class,
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
