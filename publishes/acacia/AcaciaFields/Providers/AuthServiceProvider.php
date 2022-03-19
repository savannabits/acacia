<?php

namespace Acacia\AcaciaFields\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Acacia\AcaciaFields\Models\Field;
use Acacia\AcaciaFields\Policies\FieldPolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Field::class => FieldPolicy::class,
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
