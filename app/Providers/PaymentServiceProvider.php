<?php

namespace App\Providers;

use App\Services\PaymentSrv\Contracts\Factory;
use App\Services\PaymentSrv\PaymentFactory;
use App\Services\PaymentSrv\Providers\Dummy;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Factory::class, function (Application $app) {
           $factory = new PaymentFactory();
            /**
             * Add PSP providers
             */
           $factory->addProvider(new Dummy());
           return $factory;
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
