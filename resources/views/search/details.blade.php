@extends('layouts.app')
@section('content')
<h3>Details</h3>
<div class="card p-3">
  @if($type === 'flight')
    <h5>{{ $item['airline'] }} - {{ $item['id'] }}</h5>
    <p>{{ $item['origin'] }} → {{ $item['destination'] }}</p>
    <p>Departure: {{ $item['departure'] }}</p>
    <p>Price: ₹{{ $item['price_in_inr'] }}</p>
    <form method="POST" action="{{ route('cart.add') }}">
      @csrf
      <input type="hidden" name="type" value="flight">
      <input type="hidden" name="id" value="{{ $item['id'] }}">
      <input type="hidden" name="price_in_inr" value="{{ $item['price_in_inr'] }}">
      <button class="btn btn-primary">Add to cart</button>
    </form>
  @else
    <h5>{{ $item['name'] }} - {{ $item['id'] }}</h5>
    <p>Room: {{ $item['room_type'] }}</p>
    <p>Price / night: ₹{{ $item['price_per_night_in_inr'] }}</p>
    <form method="POST" action="{{ route('cart.add') }}">
      @csrf
      <input type="hidden" name="type" value="hotel">
      <input type="hidden" name="id" value="{{ $item['id'] }}">
      <input type="hidden" name="price_per_night_in_inr" value="{{ $item['price_per_night_in_inr'] }}">
      <div class="mb-2">
        <label>Nights</label>
        <input name="nights" type="number" min="1" value="1" class="form-control" />
      </div>
      <button class="btn btn-primary">Add to cart</button>
    </form>
  @endif
</div>
@endsection
