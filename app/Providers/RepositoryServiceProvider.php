<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //repository binding
        $this->app->bind(\App\Repositories\ProductRepositoryInterface::class, \App\Repositories\EloquentProductRepository::class);
        //service binding
        $this->app->bind(\App\Services\Contracts\ProductServiceInterface::class, \App\Services\ProductService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
