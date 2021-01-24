<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\ProductSrv\ProductServiceImpl;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductServiceImpl $productSrv;

    public function __construct(ProductServiceImpl $productSrv) {
        $this->productSrv = $productSrv;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $pagination = $this->productSrv->all(
            $request->input("pageId", 1)
        );
        $nextPageId =  $pagination->getPageId() +1;
        $backPageId =  $pagination->getPageId() <= 0 ? 0 : $pagination->getPageId() -1;

        return view('products',
            [
                "page" => $pagination,
                "nextPageId" => $nextPageId,
                "backPageId" => $backPageId,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        throw new NotFoundException("not found", 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        throw new NotFoundException("not found", 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        throw new NotFoundException("not found", 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        throw new NotFoundException("not found", 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        throw new NotFoundException("not found", 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        throw new NotFoundException("not found", 404);
    }
}
