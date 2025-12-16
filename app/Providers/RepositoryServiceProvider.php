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
        //product repository binding
        $this->app->bind(\App\Repositories\ProductRepositoryInterface::class, \App\Repositories\EloquentProductRepository::class);
        //product service binding
        $this->app->bind(\App\Services\Contracts\ProductServiceInterface::class, \App\Services\ProductService::class);
        //category repository binding
        $this->app->bind(\App\Repositories\CategoryRepositoryInterface::class,\App\Repositories\EloquentCategoryRepository::class);
        //category service binding
        $this->app->bind(\App\Services\Contracts\CategoryServiceInterface::class,\App\Services\CategoryService::class);
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
