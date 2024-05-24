<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>M&D Tech Service - Panel użytkownika</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link href="{{ asset('mystyles.css') }}" rel="stylesheet">

</head>

<body class="bg-gray">
  @include('shared.navbar')

  <div class="container-fluid d-flex flex-column align-items-center m-3 justify-content-center">
    <h1>Usługi</h1>
    <div class="container mt-5 d-flex flex-wrap border border-radius">
            @foreach ($services as $service)
              <div class="card card-effect m-3" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">{{$service -> title}}</h5>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Cena min*: {{$service -> price_min}}</h6>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Cena max*: {{$service -> price_max}}</h6>
                  <p class="card-text">{{$service -> description}}</p>
                  <div class="mt-auto p-2">
                  </div>
                </div>
              </div>
            @endforeach
    </div>
    <div class="container mt-5">
        <ul class="pagination pagination-sm justify-content-center">
            @for ($i = 1; $i <= $services->lastPage(); $i++)
        <li class="page-item {{ ($services->currentPage() == $i) ? 'active' : '' }}">
        <a class="page-link" href="{{ $services->url($i) }}">{{ $i }}</a>
        </li>
      @endfor
        </ul>
    </div>

  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>