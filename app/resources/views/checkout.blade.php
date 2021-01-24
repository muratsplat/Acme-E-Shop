@extends('layouts.app')
@section('title', 'Checkout Form')
@section('navbar')
    @parent
@show
@section("content")
    <div class="container">
        <h2 class="row justify-content-md-center">Checkout Form</h2>
        <table class="table">
            <thead>
            <h3>Checkout Item List</h3>
            <tr>
                <th scope="col">Product Id</th>
                <th scope="col">Brand Name</th>
                <th scope="col">Product Name</th>
                <th scope="col">Count</th>
                <th scope="col">Price</th>
                <th scope="col">Total Price</th>
            </tr>
            </thead>
            <tbody>

            @if(!$page->isEmpty())
                @foreach($page->getItems() as $product)
                <tr>
                    <td>{{$product->getProductId()}}</td>
                    <td>{{$product->getBrandName()}}</td>
                    <td>{{$product->getName()}}</td>
                    <td>{{$product->getCount()}}</td>
                    <td>{{$product->getPrice()}} Euro</td>
                    <td>{{$product->getTotalPrice()}} Euro</td>
                </tr>
                @endforeach
            @endif

            </tbody>
        </table>
    </div>

    @if(!$page->isEmpty())
    <div class="container">
        <h3>Please fill the form to place an order! </h3>
        <form action="/order" method="post">
            @csrf
            <div class="mb-3">
                <label for="yourname" class="form-label">Name</label>
                <input type="name" name="name" class="form-control  @error('name') is-invalid @enderror" id="yourName1" aria-describedby="emailHelp">
                @error('name')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="name" class="form-text"> enter your name </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="name" name="address" class="form-control  @error('address') is-invalid @enderror" id="address1" aria-describedby="emailHelp">
                @error('address')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="name" class="form-text"> enter your address </div>
            </div>
            <div class="mb-3">
                <label for="shippingOptions" class="form-label">Shipping Option</label>
                <select class="form-select  @error('shipping_option') is-invalid @enderror" aria-label="Default select example" name="shipping_option" >
                    <option value="0">Free standard</option>
                    <option value="1">Express 10 EUR</option>
                </select>
                @error('shipping_option')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="name" class="form-text">Select shipping options </div>
            </div>
            <button type="submit" class="btn btn-primary">Buy Now !</button>
        </form>
    </div>
    @endif

@endsection
@section("script")
<script>
</script>
@endsection
