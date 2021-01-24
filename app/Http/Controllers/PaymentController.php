<?php

namespace App\Http\Controllers;

use App\Rules\CreditCardExpiryDate;
use App\Rules\CreditCardNumber;
use App\Services\OrderSrv\Contracts\OrderService;
use App\Services\OrderSrv\Dto\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\PaymentSrv\Dto\Purchase as PurchaseDto;

class PaymentController extends Controller
{
    private OrderService $orderSrv;

    public function __construct(OrderService $orderSrv) {
        $this->orderSrv = $orderSrv;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        try {
            $this->validate($request, [
                'card_number' => [
                    "required", "numeric", new CreditCardNumber
                ],
                'cvv' => 'required|regex:/^[0-9]{3,4}$/',
                'expire_date'=> [
                    "required", "size:7", "regex:/^(([0-9]{2}-[0-9]{4}))$/", new CreditCardExpiryDate
                ],
                'card_holder' => 'required|max:256|min:3',
                'amount' => 'required:digits_between:1,100000',
                'currency' => 'required'
            ]);
        } catch (ValidationException $e) {
           return redirect("/payment")->withErrors($e->validator->getMessageBag());
        }

        $orderDetails =  $this->orderSrv->getOrderDetail();
        $dto = new PurchaseDto();
        $dto->setAmount($request->get("amount"));
        $dto->setCardHolder($request->get("card_holder"));
        $dto->setCurrency($request->get("currency"));
        $dto->setCardNumber($request->get("card_number"));
        $dto->setExipreDate($request->get("expire_date"));

        $dto->setCvv($request->get("cvv"));

        $this->orderSrv->completeOrder($orderDetails, $dto);

        return redirect("/")
            ->with("message", "The amount of the order was charged on your credit card account!");
    }

    /**
     * Handle Redirect request to show errors
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function handleRedirect()
    {
        $orderDetails =  $this->orderSrv->getOrderDetail();
        return view('purchase',
            [
                "orderDetails" => $orderDetails,
            ]
        );
    }

}
