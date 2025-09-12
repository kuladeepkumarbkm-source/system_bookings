@extends('layouts.app')
@section('content')
<h3>Admin Dashboard</h3>
<div class="row">
  <div class="col-md-3"><div class="card p-3">Total Bookings: {{ $totalBookings }}</div></div>
  <div class="col-md-3"><div class="card p-3">Flight: {{ $byType['flight'] ?? 0 }} | Hotel: {{ $byType['hotel'] ?? 0 }}</div></div>
  <div class="col-md-3"><div class="card p-3">Revenue (raw total): {{ $totalRevenueInr }}</div></div>
</div>

<h5 class="mt-3">Recent Bookings</h5>
<table class="table">
  <thead><tr><th>Code</th><th>Type</th><th>Customer</th><th>Total</th></tr></thead>
  <tbody>
    @foreach($latest as $b)
      <tr>
        <td>{{ $b->booking_code }}</td>
        <td>{{ $b->type }}</td>
        <td>{{ $b->customer->name ?? '—' }}</td>
        <td>{{ $b->total_amount }} {{ $b->currency }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection
