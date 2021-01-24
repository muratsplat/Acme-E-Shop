@extends('layouts.app')
@section('title', 'Products')
@section('navbar')
    @parent
@show
@section("content")

    <div class="container">
        @error('message')

        <div class="alert alert-danger" role="alert">
            <div class="alert alert-danger">{{$message}}</div>
        </div>
        @enderror

        @if (session('message'))
            <div class="alert alert-success" role="alert">
                <div class="alert alert-success">{{session('message')}}</div>
            </div>
        @endif

    </div>
    <div class="container">
        <h2>Product List</h2>
        <table class="table">
            <thead>
            Click on the buy button what you want to buy !
            <tr>
                <th scope="col">Brand Name</th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($page->getItems() as $product)
                <tr>
                    <td>{{$product->getBrandName()}}</td>
                    <td>{{$product->getName()}}</td>
                    <td>{{$product->getPrice()}} Euro</td>
                    <td>
                        <a class="btn btn-primary click product" productId="{{$product->getId()}}" href="{{url('/checkout?productId=')}}{{$product->getId()}}" role="button">Buy</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm">
                <a class="btn btn-primary" href="{{url('/?pageId=')}}{{$backPageId}}" role="button">Back({{$backPageId}})</a>
            </div>
            <div class="col-sm">
                Total Products:{{$page->getTotal()}}
            </div>
            <div class="col-sm">
                <a class="btn btn-primary" href="{{url('/?pageId=')}}{{$nextPageId}}" role="button">Next({{$nextPageId}})</a>
            </div>
        </div>
    </div>

@endsection
@section("script")
<script>

    /*
        This is VanillaJS :)
     */
    const HOST = '{{url("")}}';
    const ADD_PRODUCT = HOST + "/checkout/add";
    const TOTAL_PRODUCT = HOST + "/checkout/total";
    let csrfToken;

    function httpResponseHandlerForAddingRequest() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                let checkOutMenuElement = document.getElementById("checkOutMenu");
                let res = JSON.parse(this.response);
                checkOutMenuElement.innerText = `Checkout(${res.totalItems})`
                alert("Item was added successfully!. You can continue to select products or complete the order by clicking Checkout Page!");
                return;
            }
            alert('There was a problem with the request.');
        }
    }

    function httpResponseHandlerForTotalRequest() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                let checkOutMenuElement = document.getElementById("checkOutMenu");
                let res = JSON.parse(this.response);
                checkOutMenuElement.innerText = `Checkout(${res.totalItems})`
                return;
            }
            alert('There was a problem with the request.');
        }
    }

    function addProduct(event) {
        event.preventDefault();
        const button = event.target;
        const httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = httpResponseHandlerForAddingRequest;
        httpRequest.open("PUT", ADD_PRODUCT)
        httpRequest.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        let params = {
            productId: button.getAttribute("productId"),
        }
        httpRequest.send(JSON.stringify(params));
    }

    function totalProduct() {
        const httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = httpResponseHandlerForTotalRequest;
        httpRequest.open("GET", TOTAL_PRODUCT)
        httpRequest.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        httpRequest.send();
    }

    window.addEventListener('DOMContentLoaded', (event) => {
        /**
         * Getting the total of product was added before.
         */
        totalProduct();

        const buttons = document.getElementsByTagName("a");
        for (let button of buttons) {
            if (button.className == "btn btn-primary click product") {
                button.addEventListener("click", addProduct);
            }
        }

        /**
         * Getting token for CSRF
         */
        let metas =  document.getElementsByTagName("meta");
        for (let meta of metas) {
            if (meta => meta.getAttribute("name") == "csrf-token") {
                csrfToken = meta.getAttribute("content");
            }
        }
    });
</script>
@endsection
