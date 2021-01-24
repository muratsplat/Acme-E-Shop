<?php

namespace App\Services\OrderSrv\Dto;

use App\Services\ProductSrv\Dto\Product;

/**
 * Class Order
 * @package App\Services\OrderSrv\Dto
 */
class Order {

    private int $Id;
    private float $totalProductValue;
    private float $totalShippingValue;
    private string $clientName;
    private string $clientAddress;
    private int $shippingType;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->Id;
    }

    /**
     * @param string $clientAddress
     */
    public function setClientAddress(string $clientAddress): void
    {
        $this->clientAddress = $clientAddress;
    }

    /**
     * @return string
     */
    public function getClientAddress(): string
    {
        return $this->clientAddress;
    }

    /**
     * @param string $clientName
     */
    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
    }

    /**
     * @param int $Id
     */
    public function setId(int $Id): void
    {
        $this->Id = $Id;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return string
     */
    public function getClientName(): string
    {
        return $this->clientName;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return int 1 is FREE_STANDARD and 2 is EXPRESS as EXPRESS as shipping options.
     */
    public function getShippingType(): int
    {
        return $this->shippingType;
    }

    /**
     * @param int $shippingType 1 is FREE_STANDARD and 2 as EXPRESS as shipping options.
     */
    public function setShippingType(int $shippingType): void
    {
        $this->shippingType = $shippingType;
    }

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
     * @param float $totalShippingValue
     */
    public function setTotalShippingValue(float $totalShippingValue): void
    {
        $this->totalShippingValue = $totalShippingValue;
    }

    /**
     * @return float
     */
    public function getTotalShippingValue(): float
    {
        return $this->totalShippingValue;
    }
}
