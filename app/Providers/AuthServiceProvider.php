<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('staf', function ($user) {
            return $user->role === 'staf';
        });

        // Gate::define('view-logs', function ($user){
        //     return $user->role === 'staf';
        // });
    
        // Gate::define('delete-item', function ($user) {
        //     return $user->role === 'staf';
        // });

        // Gate::define('restore-item', function ($user) {
        //     return $user->role === 'staf';
        // });

        // Gate::define('add-item', function ($user){
        //     return $user->role === 'staf';
        // });

        // Gate::define('edit-item', function ($user){
        //     return $user->role === 'staf';
        // });
    }
}
