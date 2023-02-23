<?php

namespace App\Providers;

use App\Repositories\Users\UsersInterface;
use App\Repositories\Users\UsersRepository;
use Illuminate\Support\ServiceProvider;

class UserRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UsersInterface::class, UsersRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
