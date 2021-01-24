<?php

namespace App\Services\CheckOutSrv\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class CheckOutPage implements Arrayable
{
    private Collection $items;
    private float $totalProductValue;

    /**
     * @param float $totalProductValue
     */
    public function setTotalProductValue(float $totalProductValue): void
    {
        $this->totalProductValue = $totalProductValue;
    }

    /**
     * @return float
     */
    public function getTotalProductValue(): float
    {
        return $this->totalProductValue;
    }

    /**
     * @param Collection $items
     */
    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }

    /**
     * It includes CheckOutItem
     *
     * @return Collection includes CheckOutItem items
     */
    public function getItems(): Collection
    {
        if (is_null($this->items)) {
            return new Collection();
        }
        return $this->items;
    }

    /**
     * Determine if it is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->getItems()->isEmpty();
    }

    /**
     * @return array
     */
    public function toArray()
    {
       return [
           "items" => $this->getItems()->toArray(),
           "totalProductValue" => $this->getTotalProductValue()
       ];
    }
}
