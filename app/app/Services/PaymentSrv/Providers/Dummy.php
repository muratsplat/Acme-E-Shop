<?php

namespace App\Services\PaymentSrv\Providers;

use App\Exceptions\NotImplementException;
use App\Services\PaymentSrv\Contracts\Payment;
use App\Services\PaymentSrv\Dto\Purchase;
use App\Services\PaymentSrv\Dto\Result;
use Faker\Factory;
use Faker\Generator;
use JetBrains\PhpStorm\Pure;

class Dummy implements Payment {

    /**
     * PurchaseRequest implementation method for Dummy provider.
     * @param Purchase $request
     * @return Result
     */
    public function purchase(Purchase $request): Result {
        $res = new Result();
        $res->setMessage("success");
        $res->setAuthcode($this->faker()->bothify('?????-#####'));
        $res->setReference($this->faker()->bothify('purchase-?????-#####'));
        $res->setStatus(200);
        return $res;
    }

    public function refund()
    {
        throw new NotImplementException("refund method is not implemented!");
    }

    /**
     * Create new Instance
     * @return $this
     */
    #[Pure]
    public function newInstance(): static
    {
       return new static;
    }

    public function name(): string
    {
        return ProviderList::DUMMY;
    }

    private function faker(): Generator {
        return Factory::create();
    }
}
