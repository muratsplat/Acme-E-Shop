<?php

namespace App\Services\PaymentSrv\Contracts;

use App\Exceptions\NotImplementException;
use App\Exceptions\PSPProviderException;

interface Factory {

    /**
     * @param string $provider
     * @return Payment
     * @throws PSPProviderException
     */
    public function provider(string $provider): Payment;

    /**
     * @param Payment $provider
     * @throws NotImplementException
     */
    public function addProvider(Payment $provider): void;

}
