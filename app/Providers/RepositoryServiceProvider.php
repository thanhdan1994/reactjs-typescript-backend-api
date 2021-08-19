<?php

namespace App\Providers;

use App\Models\Categories\Repositories\CategoryRepository;
use App\Models\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Brands\Repositories\BrandRepository;
use App\Models\Brands\Repositories\Interfaces\BrandRepositoryInterface;
use App\Models\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Products\Repositories\ProductRepository;
use App\Models\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\Users\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }
}
