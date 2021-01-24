<?php

namespace App\Services\PaymentSrv\Contracts;

use App\Services\PaymentSrv\Dto\Purchase;
use App\Services\PaymentSrv\Dto\Result;

interface Payment {

    /**
     * Takes funds from the cardholder’s account.
     *
     * @param $request Purchase it is a purchase request
     * @return mixed
     */
    public function purchase(Purchase $request): Result;

    /**
     * TODO: this is just draft. It will a request and response model according to the business domains what will be!
     * Moves funds to the cardholder’s account, referring to an eligible purchase.
     */
    public function refund();

    /**
     * New instance
     * @return $this
     */
    public function newInstance(): static;

    /**
     * It must be unique for each provider
     *
     * @return string
     */
    public function name(): string;

}
