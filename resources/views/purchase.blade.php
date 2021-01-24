@extends('layouts.app')
@section('title', 'Checkout Form')
@section('navbar')
    @parent
@show
@section("content")
    <div class="container">
        <h2 class="row justify-content-md-center">Purchase</h2>
        <table class="table">
            <thead>
            <h3>Order Details</h3>
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
            @error('error')

            <div class="alert alert-danger" role="alert">
                <div class="alert alert-danger">{{$message}}
                    Navigate to <a class="btn btn-primary" href="{{url("/")}}" role="button">Products</a></div>
            </div>
            @enderror

            @if(!$orderDetails->getCheckOutPage()->isEmpty())
                @foreach($orderDetails->getCheckOutPage()->getItems() as $product)
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

    <div class="container">
        <h2 class="row justify-content-md-center">Shipping Details</h2>
        <table class="table">
            <thead>
            <h3>Deposit Details</h3>
            <tr>
                <th scope="col">Total Price Of Selected products</th>
                <th scope="col">Shipping</th>
                <th scope="col">Shipping Cost</th>
                <th scope="col">Final Total With Shipping</th>
            </tr>
            </thead>
            <tbody>

            @if(!$orderDetails->getCheckOutPage()->isEmpty())
            <tr>
                <td>{{$orderDetails->getCheckOutPage()->getTotalProductValue()}} Euro</td>
                <td>{{$orderDetails->getOrderRequest()->getShippingOptionAsString()}}</td>
                <td>{{$orderDetails->getOrderRequest()->getTotalShippingValue()}} Euro</td>
                <td>{{$orderDetails->getDepositAmount()}} Euro</td>
            </tr>
            @endif

            </tbody>
        </table>

    </div>

    @if(!$orderDetails->getCheckOutPage()->isEmpty())
    <div class="container">
        <h3>Please fill the form for Credit Card payment! </h3>
        <form action="/payment" method="post">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="name" readonly name="amount" class="form-control  @error('amount') is-invalid @enderror" id="yourName1" aria-describedby="emailHelp" value="{{$orderDetails->getDepositAmount()}}">
                @error('amount')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="name" class="form-text">Amount will be charged </div>
            </div>
            <div class="mb-3">
                <label for="currency" class="form-label">Currency</label>
                <input type="name" readonly name="currency" class="form-control  @error('currency') is-invalid @enderror" id="yourName1" aria-describedby="emailHelp" value="EUR">
                @error('currency')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="name" class="form-text">Currency will be charged </div>
            </div>
            <div class="mb-3">
                <label for="cardNumber" class="form-label">Card Number</label>
                <input type="name" required name="card_number" class="form-control  @error('card_number') is-invalid @enderror" id="yourName1" aria-describedby="emailHelp" placeholder="4111111111111111">
                @error('card_number')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="name" class="form-text"> Enter your credit card number </div>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="name" required name="cvv" class="form-control  @error('cvv') is-invalid @enderror" id="address1" aria-describedby="emailHelp" placeholder="123">
                @error('cvv')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="cvv" class="form-text"> Enter your credit card CVV  </div>
            </div>

            <div class="mb-3">
                <label for="cvv" class="form-label">Expire Date</label>
                <input type="name" required name="expire_date" class="form-control  @error('expire_date') is-invalid @enderror" id="address1" aria-describedby="emailHelp" placeholder="03-2025">
                @error('expire_date')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="cvv" class="form-text"> Enter your credit card expire date</div>
            </div>
            <div class="mb-3">
                <label for="card_holder" class="form-label">Card Holder</label>
                <input type="name" required name="card_holder" class="form-control  @error('card_holder') is-invalid @enderror" id="address1" aria-describedby="emailHelp" placeholder="Albert Einstein">
                @error('card_holder')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <div id="cvv" class="form-text"> Enter your Name and Surname on your credit card.</div>
            </div>
            <button type="submit" class="btn btn-primary">Accept !</button>
        </form>
    </div>
    @endif

@endsection
@section("script")
<script>
</script>
@endsection
