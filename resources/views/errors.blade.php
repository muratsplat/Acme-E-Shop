@extends('layouts.app')
@section('title', 'Products')
@section('navbar')
    @parent
@show
@section("content")
    <div class="container">
        <h2>Error: {{$msg}} </h2>
    </div>
@endsection
