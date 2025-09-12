@extends('layouts.app')
@section('content')
<h3>Search Flights</h3>
<form method="GET" action="{{ route('search.flights') }}" class="row g-2">
  <div class="col-md-3"><input name="origin" placeholder="Origin" class="form-control" required></div>
  <div class="col-md-3"><input name="destination" placeholder="Destination" class="form-control" required></div>
  <div class="col-md-2"><input name="date" type="date" class="form-control" required></div>
  <div class="col-md-2">
    <select name="sort" class="form-select">
      <option value="">Sort</option><option value="asc">Price asc</option><option value="desc">Price desc</option>
    </select>
  </div>
  <div class="col-md-2"><button class="btn btn-primary">Search</button></div>
</form>

@if(!empty($results))
  <hr>
  <div class="list-group">
    @foreach($results as $r)
      <div class="list-group-item">
        <h5>{{ $r['airline'] }} — {{ $r['origin'] }} → {{ $r['destination'] }}</h5>
        <p>Departure: {{ $r['departure'] }} — Price: ₹{{ $r['price_in_inr'] }}</p>
        <a href="{{ route('details', ['type'=>'flight','id'=>$r['id']]) }}" class="btn btn-sm btn-outline-primary">Details</a>
      </div>
    @endforeach
  </div>
@endif
@endsection
