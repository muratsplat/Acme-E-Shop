<?php

namespace App\Repositories\Contracts;


use App\Repositories\Model\OrderShipping;

/**
 * Simple Checkout Repository implementation.
 *
 * Interface CheckOutRepo
 * @package App\Repositories\Contracts
 */
interface PurchaseRepo
{
    /**
     * Put item into cache
     *
     * @param OrderShipping $purchase
     */
    public function put(OrderShipping $purchase): void;

    /**
     * get item
     *
     * @return OrderShipping|null
     */
    public function get(): OrderShipping|null;
}
