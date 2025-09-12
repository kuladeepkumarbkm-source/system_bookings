<!-- resources/views/layouts/navigation.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ url('/') }}">BMGA</a>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('search.flights') }}">Flights</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('search.hotels') }}">Hotels</a></li>
      </ul>

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart.index') }}">
            Cart @if(session('cart')) <span class="badge bg-primary">1</span> @endif
          </a>
        </li>

        @guest
          {{-- Guest links: only shown when NOT authenticated --}}
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') ?? url('/register') }}">Register</a></li>
        @else
          {{-- Authenticated user --}}
          <li class="nav-item"><span class="nav-link">{{ Auth::user()->name }}</span></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-link nav-link" style="display:inline; padding:0;">
                Logout
              </button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
