<?php

namespace App\Services\OrderSrv\Contracts;

use App\Services\OrderSrv\Dto\OrderDetail;
use App\Services\OrderSrv\Dto\OrderRequest;
use App\Services\PaymentSrv\Dto\Purchase;
use App\Services\PaymentSrv\Dto\Purchase as PurchaseDto;

interface OrderService
{
    /**
     * @param OrderRequest $request
     * @return OrderDetail
     */
    public function createOrderDetail(OrderRequest $request): OrderDetail;

    /**
     * @return OrderDetail
     */
    public function getOrderDetail(): OrderDetail;


    /**
     * @param OrderRequest $request
     */
    public function put(OrderRequest $request);

    /**
     * @return  OrderRequest $request
     * @throw NotFoundException
     */
    public function get(): OrderRequest;

    /**
     * @param OrderDetail $orderDetail
     * @param PurchaseDto $creditCard
     */
    public function completeOrder(OrderDetail $orderDetail, PurchaseDto $creditCard): void;
}
