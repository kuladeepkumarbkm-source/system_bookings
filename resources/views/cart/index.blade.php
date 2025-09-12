@extends('layouts.app')
@section('content')
<h3>Cart</h3>
@if(session()->has('cart'))
    @php
        $cart = session('cart');
    @endphp
    <p>Cart item: {{ $cart['id'] }}</p>
@endif

  <div class="card p-3">
    <p>Type: {{ $cart['type'] }}</p>
    <p>ID: {{ $cart['id'] }}</p>
    <p>Price (INR): ₹{{ $cart['price_in_inr'] ?? ($cart['price_per_night_in_inr'] ?? 0) }}</p>
    @if(isset($cart['nights'])) <p>Nights: {{ $cart['nights'] }}</p> @endif
    <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to checkout</a>
    <form method="POST" action="{{ route('cart.clear') }}" class="d-inline">@csrf <button class="btn btn-danger">Clear</button></form>
  </div>
@else
  <p>No items in cart.</p>
@endif
@endsection
