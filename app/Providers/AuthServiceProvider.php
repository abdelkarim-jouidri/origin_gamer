<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('act-on-category', function(User $user){
            return $user->isAdmin() 
                                    ? Response::allow()
                                    : Response::deny('Only admins are authorized for this action');
        });

        Gate::define('act-on-product',function(User $user){
            return ($user->isAdmin() || $user->isSeller())
                        ? Response::allow()
                        : Response::deny('Not authorized');
        });
    }
}
