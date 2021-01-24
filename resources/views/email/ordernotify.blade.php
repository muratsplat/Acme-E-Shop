<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Order Received</title>
</head>
<body>


<div class="container">
    <h1 class="row justify-content-md-center">New order was received!</h1>
</div>

<div class="container">
    <h2 class="row justify-content-md-center">Order Details</h2>
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
        @if(!$orderDetail->getCheckOutPage()->isEmpty())
            @foreach($orderDetail->getCheckOutPage()->getItems() as $product)
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


<table class="table">
    <thead>
        <h3>Order Detail</h3>
        <tr>
            <th scope="col">Total Price Of Selected products</th>
            <th scope="col">Shipping</th>
            <th scope="col">Shipping Cost</th>
            <th scope="col">Final Total With Shipping</th>
        </tr>
    </thead>
    <tbody>

    @if(!$orderDetail->getCheckOutPage()->isEmpty())
        <tr>
            <td>{{$orderDetail->getCheckOutPage()->getTotalProductValue()}} Euro</td>
            <td>{{$orderDetail->getOrderRequest()->getShippingOptionAsString()}}</td>
            <td>{{$orderDetail->getOrderRequest()->getTotalShippingValue()}} Euro</td>
            <td>{{$orderDetail->getDepositAmount()}} Euro</td>
        </tr>
    @endif
    </tbody>
</table>

</body>
