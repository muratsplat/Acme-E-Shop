<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Acme Shop - @yield('title')</title>
</head>
<body>
<h1 class="row justify-content-md-center">Acme Shop</h1>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

@yield("script")

@section('navbar')
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="{{ (request()->is('')) ? 'nav-link active' : 'nav-link' }}" aria-current="page" href="{{ url('/') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="{{ (request()->is('checkout')) ? 'nav-link active' : 'nav-link' }}" aria-current="page" href="{{ url('/checkout') }}" id="checkOutMenu">Checkout</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
    </div>
@show


<div class="container">
    @yield('content')
</div>

</body>
</html>
