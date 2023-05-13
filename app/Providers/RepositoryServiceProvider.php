<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Insert use Interface
 */

use App\Repositories\Contracts\{
     IUser
};

/**
 * Insert use Repositories
 */

use App\Repositories\Eloquent\{     
    UserRepository
};

/**
 * Class RepositoryServiceProvider
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {       
        $this->app->bind(IUser::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
