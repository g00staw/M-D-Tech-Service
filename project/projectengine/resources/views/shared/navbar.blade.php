<!-- Navbar -->
@php
  $user = null;
  $defaultImage = asset('src/man.png');
  if (Auth::guard('web')->check()) {
  $user = Auth::guard('web')->user();
  } elseif (Auth::guard('admin')->check()) {
  $user = Auth::guard('admin')->user();
  } elseif (Auth::guard('employee')->check()) {
  $user = Auth::guard('employee')->user();
  }
  $profileImage = $user && $user->profile_photo ? asset('storage/' . $user->profile_photo) : $defaultImage;
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-body-tertiary gradient-custom box-shadow">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Navbar brand -->
    @if (Auth::guard('admin')->check())
    <a class="navbar-brand btn" href="{{ route('admindashboard') }}"><img src="{{ asset('src/logo.png') }}"
      height="70"></a>
  @elseif (Auth::guard('web')->check())
  <a class="navbar-brand btn" href="{{ route('userdashboard') }}"><img src="{{ asset('src/logo.png') }}"
    height="70"></a>
@elseif (Auth::guard('employee')->check())
  <a class="navbar-brand btn" href="{{ route('employeedashboard') }}"><img src="{{ asset('src/logo.png') }}"
    height="70"></a>
@else
  <a class="navbar-brand btn" href="{{ route('userdashboard') }}"><img src="{{ asset('src/logo.png') }}"
    height="70"></a>
@endif


    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars text-light"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left links -->
      <ul class="navbar-nav me-auto d-flex flex-row mt-3 mt-lg-0">
        @if (Auth::guard('web')->check())
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
    @endif
        @if (Auth::guard('admin')->check())
      <li class="nav-item text-center mx-2 mx-lg-1 btn">
      <a class="nav-link active" aria-current="page" href="{{ route('admindashboard') }}">
        <div>
        <i class="fas fa-home fa-lg mb-1"></i>
        <img src="{{ asset('src/house.png') }}">
        </div>
        Pulpit
      </a>
      </li>
      <li class="nav-item text-center mx-2 mx-lg-1 btn">
      <a class="nav-link" href="{{ route('admindashboard.devices') }}">
        <div>
        <i class="far fa-envelope fa-lg mb-1"></i>
        <img src="{{ asset('src/responsive.png') }}" height="30">
        {{-- <span class="badge rounded-pill badge-notification bg-info">11</span> --}}
        </div>
        Urządzenia
      </a>
      </li>
      <li class="nav-item text-center mx-2 mx-lg-1 btn">
      <a class="nav-link" href="{{ route('admindashboard.repairs') }}">
        <div>
        <i class="far fa-envelope fa-lg mb-1"></i>
        <img src="{{ asset('src/settings.png') }}" height="30">
        {{-- <span class="badge rounded-pill badge-notification bg-warning">11</span> --}}
        </div>
        Naprawy
      </a>
      </li>
    @endif
    @if (Auth::guard('employee')->check())
      <li class="nav-item text-center mx-2 mx-lg-1 btn">
      <a class="nav-link active" aria-current="page" href="{{ route('employeedashboard') }}">
        <div>
        <i class="fas fa-home fa-lg mb-1"></i>
        <img src="{{ asset('src/house.png') }}">
        </div>
        Pulpit
      </a>
      </li> 
    @endif

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
        {{ Auth::guard('web')->user()->name }} (Użytkownik)
      </button>
      <ul class="dropdown-menu">
        <a class="nav-link text-dark" href="{{ route('userdashboard.profile') }}">Wyświetl profil</a>
        <a class="nav-link text-dark" href="{{ route('logout') }}">Wyloguj się... </a>
      </ul>
      </div>
    @elseif (Auth::guard('employee')->check())
    <div class="btn-group dropstart bg-opacity-50">
    <button type="button" class="btn bg-transparent btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
      aria-expanded="false">
      {{ Auth::guard('employee')->user()->name }} (Pracownik)
    </button>
    <ul class="dropdown-menu">
      <a class="nav-link text-dark" href="{{ route('employeedashboard.profile') }}">Wyświetl profil</a>
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
    <a class="nav-link text-dark" href="{{ route('admindashboard.profile') }}">Wyświetl profil</a>
    <a class="nav-link text-dark" href="{{ route('logout') }}">Wyloguj się... </a>
  </ul>
  </div>
@else
  <a class="nav-link" href="{{ route('login') }}">Zaloguj się...</a>
@endif
        <img src="{{ $profileImage }}" class="rounded-circle img-fluid" style="height: 50px;">
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