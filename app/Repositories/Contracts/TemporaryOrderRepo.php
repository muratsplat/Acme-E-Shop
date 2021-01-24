<?php

namespace App\Repositories\Contracts;

use App\Repositories\Model\OrderShipping;

/**
 * Simple Temporary Order Repository implementation.
 *
 * Interface CheckOutRepo
 * @package App\Repositories\Contracts
 */
interface TemporaryOrderRepo
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

    /**
     * Clear cache
     */
    public function clear(): void;
}
