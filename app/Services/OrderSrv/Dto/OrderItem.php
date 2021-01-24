<?php

namespace App\Services\OrderSrv\Dto;

use Serializable;

/**
 * Class OrderItem
 * @package App\Services\OrderSrv\Dto
 */
class OrderItem {

    private int $productId;

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }
}
