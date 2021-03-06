<?php

namespace App\Providers;

use App\Movie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;



class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('delete', 'App\Policies\MoviePolicy@delete');
        Gate::define('update', 'App\Policies\MoviePolicy@update');
        Gate::define('create', 'App\Policies\MoviePolicy@create');

        //
    }
}
