<?php

namespace App\Repositories\Model;

use App\Services\CheckOutSrv\Dto\CheckOutPage;
use Illuminate\Contracts\Support\Arrayable;
use Serializable;

class OrderShipping implements Serializable, Arrayable
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
     * @return CheckOutPage
     */
    public function getCheckout(): CheckOutPage
    {
        return $this->checkout;
    }

    /**
     * @return float
     */
    public function getTotalShippingValue(): float
    {
        if (is_null($this->totalShippingValue)) {
            return 0.0;
        }
        return $this->totalShippingValue;
    }

    /**
     * @param float $totalShippingValue
     */
    public function setTotalShippingValue(float $totalShippingValue): void
    {
        $this->totalShippingValue = $totalShippingValue;
    }

    public function serialize()
    {
        return json_encode($this->toArray());
    }

    public function unserialize($serialized)
    {
        $arr = json_decode($serialized, true);
        $this->setName($arr['name']);
        $this->setAddress($arr['address']);
        $this->setShippingOption($arr['shippingOption']);
        $this->setTotalShippingValue($arr['totalShippingValue']);

    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            "name" => $this->getName(),
            "address" => $this->getAddress(),
            "shippingOption" => $this->getShippingOption(),
            "totalShippingValue" => $this->getTotalShippingValue(),
        ];
    }


}
