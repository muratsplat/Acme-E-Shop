<?php

namespace App\Providers;

use App\Repositories\CheckOutCacheRepo;
use App\Repositories\PurchaseRepo;
use App\Services\CheckOutSrv\CheckoutServiceImpl;
use App\Services\CheckOutSrv\Contracts\CheckoutService;
use App\Services\ProductSrv\Contracts\ProductService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CheckoutService::class, function (Application $app) {
            $expireInMinutes = intval($app['config']->get("app.checkout_expire"), 10);
            $repo = new CheckOutCacheRepo($app['cache.store'], now()->addMinutes($expireInMinutes));
            $productService = $app->make(ProductService::class);
            return new CheckoutServiceImpl($repo, $productService);
        });
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
