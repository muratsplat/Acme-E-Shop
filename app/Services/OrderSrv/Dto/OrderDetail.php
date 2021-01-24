<?php

namespace App\Services\OrderSrv\Dto;

use App\Services\CheckOutSrv\Dto\CheckOutPage;

class OrderDetail
{
    private CheckOutPage $checkOutPage;
    private OrderRequest $orderRequest;
    private float $depositAmount;

    /**
     * @return CheckOutPage
     */
    public function getCheckOutPage(): CheckOutPage
    {
        return $this->checkOutPage;
    }

    /**
     * @param CheckOutPage $checkOutPage
     */
    public function setCheckOutPage(CheckOutPage $checkOutPage): void
    {
        $this->checkOutPage = $checkOutPage;
    }

    /**
     * @return float
     */
    public function getDepositAmount(): float
    {
        return $this->depositAmount;
    }

    /**
     * @param float $depositAmount
     */
    public function setDepositAmount(float $depositAmount): void
    {
        $this->depositAmount = $depositAmount;
    }

    /**
     * @param OrderRequest $purchaseRequest
     */
    public function setOrderRequest(OrderRequest $purchaseRequest): void
    {
        $this->purchaseRequest = $purchaseRequest;
    }

    /**
     * @return OrderRequest
     */
    public function getOrderRequest(): OrderRequest
    {
        return $this->purchaseRequest;
    }
}
