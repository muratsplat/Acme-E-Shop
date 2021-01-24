<?php

namespace App\Providers;

use App\Repositories\OrderRepo;
use App\Repositories\TemporaryOrderCacheRepo;
use App\Services\CheckOutSrv\Contracts\CheckoutService;
use App\Services\OrderSrv\Contracts\OrderService;
use App\Services\OrderSrv\OrderServiceImpl;
use App\Services\PaymentSrv\Contracts\Factory;
use App\Models\Order as OrderModel;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;


class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OrderService::class, function (Application $app) {
            $expireInMinutes = intval($app['config']->get("app.checkout_expire"), 10);
            $tmpOrderRepo = new TemporaryOrderCacheRepo($app['cache.store'], now()->addMinutes($expireInMinutes));
            $checkoutSrv = $app->make(CheckoutService::class);
            $paymentFactory = $app->make(Factory::class);
            $orderModel = new OrderModel();
            $oderPersistentRepo = new OrderRepo($orderModel->newInstance());
            return new OrderServiceImpl($tmpOrderRepo, $checkoutSrv, $paymentFactory, $oderPersistentRepo, $app);
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
