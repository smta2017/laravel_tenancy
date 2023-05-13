<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Insert use Interface
 */

use App\Repositories\Contracts\{
    // IPost
};

/**
 * Insert use Repositories
 */

use App\Repositories\{     
    // PostRepository
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
        // $this->app->bind(IPost::class, PostRepository::class);
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
