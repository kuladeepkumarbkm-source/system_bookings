<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">BMGA</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('search.flights') }}">Flights</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('search.hotels') }}">Hotels</a></li>
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">
            Cart @if(session('cart')) <span class="badge bg-primary">1</span> @endif
        </a></li>
        @auth
            <li class="nav-item"><span class="nav-link">{{ auth()->user()->name }}</span></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
        @else
            <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
