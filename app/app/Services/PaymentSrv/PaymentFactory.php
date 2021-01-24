<?php

namespace App\Services\PaymentSrv;

use App\Exceptions\NotImplementException;
use App\Services\PaymentSrv\Contracts\Factory;
use App\Services\PaymentSrv\Contracts\Payment;
use App\Exceptions\PSPProviderException;
use \Illuminate\Support\Collection;

class PaymentFactory implements Factory {

    private Collection $providers;

    public function __construct() {
        $this->providers = new Collection();
    }

    /**
     * @param string $provider
     * @return Payment
     * @throws PSPProviderException
     */
    public function provider(string $provider): Payment
    {
        if ($this->providers->has($provider)) {
            /**
             * @var $provider Payment
             */
            $provider = $this->providers->get($provider);
            return $provider->newInstance();
        }
        throw new PSPProviderException( "$provider is not found!", 500);
    }

    /**
     * @param Payment $provider
     * @throws NotImplementException
     */
    public function addProvider(Payment $provider): void {
        if ($this->providers->has($provider->name())) {
            throw new NotImplementException("given psp provider was already added!", 500);
        }
        $this->providers->put($provider->name(), $provider);
    }

}
