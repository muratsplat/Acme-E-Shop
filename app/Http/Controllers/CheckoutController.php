<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\CheckOutSrv\Contracts\CheckoutService;
use App\Services\CheckOutSrv\Dto\CheckOutItem;
use App\Services\ProductSrv\ProductServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class CheckoutController extends Controller
{
    protected ProductServiceImpl $productSrv;
    protected CheckoutService $checkout;

    public function __construct(ProductServiceImpl $productSrv, CheckoutService $checkout) {
        $this->productSrv = $productSrv;
        $this->checkout = $checkout;
    }

    /**
     * It presents Checkout page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $page = $this->checkout->getPage();
        return view('checkout',
            [
                "page" => $page,
            ]
        );
    }

    /**
     * Add item to the list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request){
        try {
            $productId = $request->json("productId", null);
            $product = $this->productSrv->findById($productId);
            $this->checkout->addItem($this->createItem($productId));
            $total = $this->checkout->all()->count();

            return response()->json([
                "productId" => $product->getId(),
                "totalItems"=>  $total,
            ]);
        } catch (NotFoundException $s) {
            return response()->json([
                "error" => $s->getMessage(),
                "status"=>  "failed",
            ], 400);
        } catch (Exception $ex) {
            return response()->json([
                "error" => $ex->getMessage(),
                "status"=>  "failed",
            ], 500);
        }
    }


    /**
     * Add item to the list
     *
     * @return Response
     */
    public function total()
    {
        $total = $this->checkout->all()->count();
        return response()->json([
            "totalItems"=>  $total,
        ]);
    }

    private function createItem(string $productId): CheckOutItem {
        $item = new CheckOutItem();
        $item->setProductId(intval($productId));
        $item->setCount(1);
        return $item;
    }
}
