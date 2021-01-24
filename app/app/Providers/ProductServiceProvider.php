<?php

namespace App\Providers;

use App\Models\Product as Model;
use App\Repositories\ProductRepo;
use App\Services\ProductSrv\Contracts\ProductService;
use App\Services\ProductSrv\ProductServiceImpl;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ProductService::class, function (Application $app) {
            $model = new Model();
            $repo = new ProductRepo($model->newInstance());
            return new ProductServiceImpl($repo, $app);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
