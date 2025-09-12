@extends('layouts.app')
@section('content')
<h3>Booking Details</h3>
<div class="card p-3">
  <p>Booking Code: {{ $booking->booking_code }}</p>
  <p>Type: {{ $booking->type }}</p>
  <p>Currency: {{ $booking->currency }} — Total: {{ $booking->total_amount }}</p>
  <p>Customer: {{ $booking->customer->name }}</p>
  <h5>Pricing</h5>
  <p>Base INR: ₹{{ $booking->pricing->base_amount_in_inr }}</p>
  <p>FX at booking: {{ $booking->pricing->fx_rate_at_booking }}</p>
  <h5>Passenger / Contact</h5>
  @foreach($booking->passengers as $p)
    <p>{{ $p->name }} — {{ $p->email ?? '' }} — {{ $p->phone ?? '' }}</p>
  @endforeach
</div>
@endsection
