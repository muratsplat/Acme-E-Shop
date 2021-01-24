<?php


namespace App\Services\OrderSrv;

use App\Exceptions\NotFoundException;
use App\Exceptions\ServerErrorException;
use App\Mail\OrderNotify;
use App\Repositories\Contracts\OrderPersistentRepo;
use App\Repositories\Contracts\TemporaryOrderRepo;
use App\Repositories\Model\Order as OrderModel;
use App\Services\CheckOutSrv\Contracts\CheckoutService;
use App\Services\OrderSrv\Dto\OrderRequest;
use App\Services\OrderSrv\Dto\ShippingOption;
use App\Services\PaymentSrv\Contracts\Payment;
use App\Services\PaymentSrv\Dto\Purchase;
use App\Services\PaymentSrv\Dto\Purchase as PurchaseDto;
use App\Repositories\Model\OrderShipping;
use App\Services\OrderSrv\Dto\OrderDetail;
use App\Services\PaymentSrv\PaymentFactory;
use App\Services\PaymentSrv\Providers\ProviderList;
use Illuminate\Foundation\Application;
use \App\Services\OrderSrv\Contracts\OrderService;
use Illuminate\Support\Facades\Mail;

class OrderServiceImpl implements OrderService
{
    private TemporaryOrderRepo $repo;
    private float $expressShippingPrice;
    private float $standardShippingPrice = 0.0;
    private CheckoutService $checkoutSrv;
    private PaymentFactory $paymentFactory;
    private OrderPersistentRepo $orderPersistentRepo;
    private string $adminEmail;

    public function __construct(
        TemporaryOrderRepo $repo,
        CheckoutService $checkoutSrv,
        PaymentFactory $paymentFactory,
        OrderPersistentRepo $orderPersistentRepo,
        Application $app
    ) {
        $this->repo = $repo;
        $this->expressShippingPrice = floatval($app['config']->get("app.express_shipping_price"));
        $this->adminEmail = $app['config']->get("app.admin_email");

        $this->checkoutSrv = $checkoutSrv;
        $this->paymentFactory = $paymentFactory;
        $this->orderPersistentRepo = $orderPersistentRepo;
    }

    /**
     * @param OrderRequest $request
     * @return OrderDetail
     */
    public function createOrderDetail(OrderRequest $request): OrderDetail
    {
        $request = $this->calculateShipping($request);
        $this->put($request);
        $detail = new OrderDetail();
        $checkOut = $this->checkoutSrv->getPage();
        $detail->setCheckOutPage($checkOut);
        $detail->setOrderRequest($request);
        $detail->setDepositAmount($request->getTotalShippingValue() + $checkOut->getTotalProductValue());
        return $detail;
    }

    /**
     * @return OrderDetail
     */
    public function getOrderDetail(): OrderDetail
    {
        $request = $this->get();
        $detail = new OrderDetail();
        $detail->setOrderRequest($request);
        $checkOut = $this->checkoutSrv->getPage();
        $detail->setCheckOutPage($checkOut);
        $detail->setDepositAmount($request->getTotalShippingValue() + $checkOut->getTotalProductValue());
        return $detail;
    }

    /**
     * @param OrderRequest $request
     * @return OrderShipping
     */
    private function mapPurchaseModel(OrderRequest $request): OrderShipping
    {
        $model = new OrderShipping();
        $model->setShippingOption($request->getShippingOption());
        $model->setAddress($request->getAddress());
        $model->setName($request->getName());
        $model->setTotalShippingValue($request->getTotalShippingValue());
        return $model;
    }

    /**
     * @param OrderRequest $request
     * @return OrderRequest
     */
    private function calculateShipping(OrderRequest $request): OrderRequest
    {
        $request->setTotalShippingValue($this->calculateShippingPrice($request));
        return $request;
    }

    /**
     * @param OrderRequest $request
     * @return float
     */
    private function calculateShippingPrice(OrderRequest $request): float
    {
        if ($request->getShippingOption() === ShippingOption::EXPRESS) {
            return $this->expressShippingPrice;
        }
        return $this->standardShippingPrice;
    }

    /**
     * @param OrderRequest $request
     */
    public function put(OrderRequest $request): void
    {
        $this->repo->put($this->mapPurchaseModel($request));
    }

    /**
     * @return  OrderRequest $request
     * @throw NotFoundException
     */
    public function get(): OrderRequest
    {
        $model = $this->repo->get();
        $dto = new OrderRequest();
        if (is_null($model)) {
            throw new NotFoundException(
                "Your order was expired. Add new items to checkout again!",
                404
            );
        }
        $dto->setName($model->getName());
        $dto->setAddress($model->getAddress());
        $dto->setShippingOption($model->getShippingOption());
        $dto->setTotalShippingValue($model->getTotalShippingValue());
        return $dto;
    }

    /**
     * @param OrderDetail $orderDetail
     * @param PurchaseDto $creditCard
     */
    public function completeOrder(OrderDetail $orderDetail, PurchaseDto $creditCard): void
    {
        $purchase = new Purchase();
        $purchase->setCvv($creditCard->getCurrency());
        $purchase->setCardNumber($creditCard->getCardNumber());
        $purchase->setAmount($creditCard->getAmount());
        $purchase->setExipreDate($creditCard->getExipreDate());
        $response =  $this->paymentProvider()->purchase($purchase);

        if ($response->isSuccess()) {
            $this->storeOrder($orderDetail);
            $this->sendEmail($orderDetail);
            $this->clearTempCheckoutData();
            return;
        }
        throw new ServerErrorException("Payment process was unsuccessful", 500);
    }

    /**
     * @param OrderDetail $orderDetail
     */
    private function storeOrder(OrderDetail $orderDetail): void
    {
        $model = new OrderModel();
        $model->setClientName($orderDetail->getOrderRequest()->getName());
        $model->setClientAddress($orderDetail->getOrderRequest()->getAddress());
        $model->setTotalShippingValue($orderDetail->getOrderRequest()->getTotalShippingValue());
        $model->setTotalProductValue($orderDetail->getCheckOutPage()->getTotalProductValue());
        if ($this->orderPersistentRepo->store($model)) {
            return;
        }
        throw new ServerErrorException("the order couldn't stored !", 500);
    }

    private function clearTempCheckoutData(): void
    {
       $this->checkoutSrv->clear();
    }

    private function sendEmail(OrderDetail $orderDetail): void
    {
        Mail::to($this->adminEmail)->send(new OrderNotify($orderDetail));
    }

    /**
     * Get a payment provider
     * @return Payment
     */
    protected function paymentProvider(): Payment {
        return $this->paymentFactory->provider(ProviderList::DUMMY);
    }

}
