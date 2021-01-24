<?php

namespace App\Services\OrderSrv\Dto;

class OrderRequest
{
    private string $name;
    private string $address;
    private int $shippingOption;
    private float $totalShippingValue;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param int $shippingOption
     */
    public function setShippingOption(int $shippingOption): void
    {
        $this->shippingOption = $shippingOption;
    }

    /**
     * @return int
     */
    public function getShippingOption(): int
    {
        return $this->shippingOption;
    }

    /**
     * @return String
     */
    public function getShippingOptionAsString(): String
    {
        if ($this->shippingOption === ShippingOption::EXPRESS) {
            return "Express";
        }
        return "Free Standard";
    }

    /**
     * @return float
     */
    public function getTotalShippingValue(): float
    {
        return $this->totalShippingValue;
    }

    /**
     * @param float $totalShippingValue
     */
    public function setTotalShippingValue(float $totalShippingValue): void
    {
        $this->totalShippingValue = $totalShippingValue;
    }
}
