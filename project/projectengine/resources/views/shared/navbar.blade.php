<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-body-tertiary gradient-custom box-shadow">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Navbar brand -->
    <a class="navbar-brand btn" href="#"><img src="{{ asset('src/logo.png') }}" height="70"></a>

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars text-light"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left links -->
      <ul class="navbar-nav me-auto d-flex flex-row mt-3 mt-lg-0">
        <li class="nav-item text-center mx-2 mx-lg-1 btn">
          <a class="nav-link active" aria-current="page" href="{{ route('userdashboard') }}">
            <div>
              <i class="fas fa-home fa-lg mb-1"></i>
              <img src="{{ asset('src/house.png') }}">
            </div>
            Pulpit
          </a>
        </li>
        <li class="nav-item text-center mx-2 mx-lg-1 btn">
          <a class="nav-link" href="{{ route('userdashboard.devices') }}">
            <div>
              <i class="far fa-envelope fa-lg mb-1"></i>
              <img src="{{ asset('src/responsive.png') }}" height="30">
              {{-- <span class="badge rounded-pill badge-notification bg-info">11</span> --}}
            </div>
            Urządzenia
          </a>
        </li>
        <li class="nav-item text-center mx-2 mx-lg-1 btn">
          <a class="nav-link" href="{{ route('userdashboard.repairs') }}">
            <div>
              <i class="far fa-envelope fa-lg mb-1"></i>
              <img src="{{ asset('src/settings.png') }}" height="30">
              {{-- <span class="badge rounded-pill badge-notification bg-warning">11</span> --}}
            </div>
            Naprawy
          </a>
        </li>
        {{-- <li class="nav-item text-center mx-2 mx-lg-1 btn">
          <a class="nav-link" aria-disabled="true" href="">
            <div>
              <i class="far fa-envelope fa-lg mb-1"></i>
              <img src="{{ asset('src/mail.png') }}" height="30">
              <span class="badge rounded-pill badge-notification bg-danger">11</span>
            </div>
            Zgłoszenia
          </a>
        </li> --}}
      </ul>
      <!-- Left links -->

      <!-- Right links -->
      <div class="navbar-nav ms-auto d-flex flex-row mt-lg-0">
        @if (Auth::guard('web')->check())
          <div class="btn-group dropstart bg-opacity-50">
            <button type="button" class="btn bg-transparent btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
              aria-expanded="false">
              {{ Auth::guard('web')->user()->name }} (User)
            </button>
            <ul class="dropdown-menu">
              <a class="nav-link text-dark" href="{{ route('logout') }}">Wyloguj się... </a>
            </ul>
          </div>
        @elseif (Auth::guard('employee')->check())
          <div class="btn-group dropstart bg-opacity-50">
            <button type="button" class="btn bg-transparent btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
              aria-expanded="false">
              {{ Auth::guard('employee')->user()->name }} (Employee)
            </button>
            <ul class="dropdown-menu">
              <a class="nav-link text-dark" href="{{ route('logout') }}">Wyloguj się... </a>
            </ul>
          </div>
        @elseif (Auth::guard('admin')->check())
          <div class="btn-group dropstart bg-opacity-50">
            <button type="button" class="btn bg-transparent btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
              aria-expanded="false">
              {{ Auth::guard('admin')->user()->name }} (Admin)
            </button>
            <ul class="dropdown-menu">
              <a class="nav-link text-dark" href="{{ route('logout') }}">Wyloguj się... </a>
            </ul>
          </div>
        @else
          <a class="nav-link" href="{{ route('login') }}">Zaloguj się...</a>
        @endif
        <img src="{{ asset('src/man.png') }}" height="50">
      </div>
      <!-- Right links -->

      <!-- Search form -->
    </div>
    <!-- Collapsible wrapper -->
    @include('shared.success-toast')
  </div>
  <!-- Container wrapper -->

</nav>
<!-- Navbar -->
