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
      <h5 class="card-title">{{$service->title}}</h5>
      <h6 class="card-subtitle mb-2 text-body-secondary">Cena min*: {{$service->price_min}}</h6>
      <h6 class="card-subtitle mb-2 text-body-secondary">Cena max*: {{$service->price_max}}</h6>
      <p class="card-text">{{$service->description}}</p>
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

    <div class="container mt-5 d-flex flex-column  border border-radius">
      <h2>Edytuj usługę</h2>
      <form id="deviceForm" method="POST" action="{{ route('admindashboard.edit.service') }}">
        @csrf
        <div class="mb-3">
          <label for="service">Wybierz usługę:</label>
          <select id="service" name="service_id" class="form-control" onchange="fillForm()">
            @foreach($services as $service)
        <option value="{{ $service->id }}" data-title="{{ $service->title }}"
        data-min-price="{{ $service->price_min }}" data-max-price="{{ $service->price_max }}"
        data-description="{{ $service->description }}">{{ $service->title }}</option>
      @endforeach
          </select>
          <br>
          <div class="mb-3">
            <label for="title" class="form-label">Tytuł usługi</label>
            <input class="form-control" id="title" name="title" type="text" required placeholder="Np. rozbity ekran"
              aria-label="titleHelp">
            <div id="titleHelp" class="form-text">Podaj tytuł usługi, np. "Wymiana ekranu w smartfonie".</div>
          </div>
          <div class="mb-3">
            <label for="cenmin" class="form-label">Cena min. usługi</label>
            <input class="form-control" id="cenmin" name="min_price" type="number" required
              placeholder="100" aria-label="titleHelp">
            <div id="titleHelp" class="form-text">Podaj cenę minimalną usługi".</div>
          </div>
          <div class="mb-3">
            <label for="cenmax" class="form-label">Cena maks. usługi</label>
            <input class="form-control" id="cenmax" name="max_price" type="number" required
              placeholder="200" aria-label="titleHelp">
            <div id="titleHelp" class="form-text">Podaj cenę maksymalną usługi.</div>
          </div>
          <div class="mb-1">
            <label for="exampleFormControlTextarea1" class="form-label">Opis usługi</labe>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="description"
                aria-describedby="dscHelp" rows="3"></textarea>
              <div id="dscHelp" class="form-text">Napisz szczegóły odnośnie zgłoszenia. Np. w jakim stanie znajduje się
                urządzenie, co się wydarzyło itp.</div>
          </div>
          <button type="submit" class="btn btn-primary">Zatwierdź zmiany</button>
        </div>
      </form>

      <script>
        function fillForm() {
          var select = document.getElementById('service');
          var selectedOption = select.options[select.selectedIndex];

          document.getElementById('title').value = selectedOption.getAttribute('data-title');
          document.getElementById('cenmin').value = selectedOption.getAttribute('data-price-min');
          document.getElementById('cenmax').value = selectedOption.getAttribute('data-price-max');
          document.getElementById('exampleFormControlTextarea1').value = selectedOption.getAttribute('data-description');
        }
      </script>

    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>