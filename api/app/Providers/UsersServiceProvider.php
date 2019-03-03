<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UsersService;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UsersService::class, function(){
            return new UsersService();
        });
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {   
    }
}
