<?php

namespace App\Services\OrderSrv;

use App\Exceptions\NotFoundException;
use App\Repositories\OrderRepo;
use App\Services\CheckOutSrv\Dto\CheckOutPage;
use App\Services\OrderSrv\Dto\ShippingOption;
use App\Services\OrderSrv\Dto\Order;
use App\Services\OrderSrv\Dto\OrderDetail;
use App\Services\ProductSrv\Dto\Product;
use Illuminate\Cache\Repository;
use Illuminate\Foundation\Application;

class OrderService {

    private OrderRepo $orderRepo;
    private int $pageSize;
    private float $expressShippingPrice = 10.00;

    public function __construct(OrderRepo $orderRepo, Application $app) {
        $this->orderRepo = $orderRepo;
        $this->pageSize = intval($app['config']->get("app.page_size"), 10);
        $this->expressShippingPrice = floatval($app['config']->get("app.express_shipping_price"));
    }

    /**
     * @param CheckOutPage $checkout
     * @param int $shippingType
     * @param string $clientName
     * @param string $clientAddress
     * @return OrderDetail
     */
    public function newOrder(
        CheckOutPage $checkout, int $shippingType = ShippingOption::FREE_STANDARD,
        string $clientName, string $clientAddress
    ): OrderDetail {
        $totalProductValue = $checkout->getTotalProductValue();
        $shippingAmount = 0.0;
        if ($shippingType == ShippingOption::EXPRESS) {
            $totalProductValue = $totalProductValue + $this->expressShippingPrice;
            $shippingAmount = $this->expressShippingPrice;
        }
        $details = new OrderDetail();
        $details->setCheckOutPage($checkout);
        $order = new Order();
        $order->setShippingType($shippingType);
        $order->setTotalProductValue($totalProductValue);
        $order->setTotalShippingValue($shippingAmount);
        $order->setClientName($clientName);
        $order->setClientAddress($clientAddress);
        $details->setOrder($order);
        return $details;
    }
}
