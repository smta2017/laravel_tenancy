<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Insert use Interface
 */

use App\Repositories\Contracts\{
     IBase
};

/**
 * Insert use Repositories
 */

use App\Repositories\{     
    BaseRepository
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
        $this->app->bind(IPost::class, PostRepository::class);
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
