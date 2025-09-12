@extends('layouts.app')
@section('content')
<h3>Checkout</h3>
<div class="card p-3">
  <p>Item: {{ $cart['type'] }} - {{ $cart['id'] }}</p>
  <p>Base Amount (INR): ₹{{ $baseAmount }}</p>
  <p>FX snapshot rate for {{ $currency }}: {{ $rate }}</p>
  <p>Total ({{ $currency }}): {{ $converted }}</p>

  <form method="POST" action="{{ route('checkout.confirm') }}">
    @csrf
    <input type="hidden" name="currency" value="{{ $currency }}">
    <div class="mb-2">
      <label>Name</label><input name="contact[name]" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Email</label><input name="contact[email]" type="email" class="form-control" required>
    </div>
    <div class="mb-2">
      <label>Phone</label><input name="contact[phone]" class="form-control" required>
    </div>
    <button class="btn btn-primary">Confirm Booking</button>
  </form>
</div>
@endsection
