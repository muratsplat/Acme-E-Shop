<?php

namespace App\Services\CheckOutSrv\Contracts;

use App\Services\CheckOutSrv\Dto\CheckOutItem;
use App\Services\CheckOutSrv\Dto\CheckOutPage;
use Illuminate\Support\Collection;

interface CheckoutService
{
    /**
     * Add an item to checkout
     * @param CheckOutItem $item
     */
    public function addItem(CheckOutItem $item): void;

    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @return Collection includes CheckOutItemWithPrice item in
     */
    public function allOfItem(): Collection;

    /**
     * It represents a model describes listed items with total prices
     *
     * @return CheckOutPage
     */
    public function getPage(): CheckOutPage;

    /**
     * Clear Checkout data
     */
    public function clear(): void;
}
