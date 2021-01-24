<?php

namespace App\Repositories\Contracts;

use App\Repositories\Model\Item;
use Illuminate\Support\Collection;

/**
 * Simple Checkout Repository implementation.
 *
 * Interface CheckOutRepo
 * @package App\Repositories\Contracts
 */
interface CheckOutRepo
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Put item into cache
     *
     * @param Item $item
     */
    public function put(Item $item): void;

    /**
     * Clear cache
     */
    public function clear(): void;
}
