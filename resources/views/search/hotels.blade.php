@extends('layouts.app')
@section('content')
<h3>Search Hotels</h3>
<form method="GET" action="{{ route('search.hotels') }}" class="row g-2">
  <div class="col-md-3"><input name="city" placeholder="City" class="form-control" required></div>
  <div class="col-md-2"><input name="checkin" type="date" class="form-control" required></div>
  <div class="col-md-2"><input name="checkout" type="date" class="form-control" required></div>
  <div class="col-md-2">
    <select name="sort" class="form-select">
      <option value="">Sort</option><option value="asc">Price asc</option><option value="desc">Price desc</option>
    </select>
  </div>
  <div class="col-md-3"><button class="btn btn-primary">Search</button></div>
</form>

@if(!empty($results))
  <hr>
  <div class="list-group">
    @foreach($results as $r)
      <div class="list-group-item">
        <h5>{{ $r['name'] }} — {{ $r['room_type'] }}</h5>
        <p>City: {{ $r['city'] }} — Price / night: ₹{{ $r['price_per_night_in_inr'] }}</p>
        <a href="{{ route('details', ['type'=>'hotel','id'=>$r['id']]) }}" class="btn btn-sm btn-outline-primary">Details</a>
      </div>
    @endforeach
  </div>
@endif
@endsection
