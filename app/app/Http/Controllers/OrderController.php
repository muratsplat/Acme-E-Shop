<?php

namespace App\Http\Controllers;

use App\Services\OrderSrv\Contracts\OrderService;
use App\Services\OrderSrv\Dto\OrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $oderSrv;


    public function __construct(OrderService $oderSrv)
    {
        $this->oderSrv = $oderSrv;
    }

    /**
     * Validate order and if is valid, redirect to purchase page
     * to complete the order.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request){
        $request->validate([
            'name' => 'required|max:64|min:3',
            'address'=> 'required|max:256|min:3',
            'shipping_option' => 'required|boolean'
        ]);

        $dto = new OrderRequest();
        $dto->setName($request->get("name"));
        $dto->setAddress($request->get("address"));
        $dto->setShippingOption($request->get("shipping_option"));
        $orderDetails = $this->oderSrv->createOrderDetail($dto);


        return view('purchase',
            [
                "orderDetails" => $orderDetails,
            ]
        );
    }
}
