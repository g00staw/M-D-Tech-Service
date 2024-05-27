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

  <div class="container-fluid d-flex flex-column align-items-center">
    <h1>Dodaj urządzenie zarejestrowane w serwisie</h1>
    <div class=" p-3 d-flex flex-column align-items-center">
      @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif
      @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
      <form id="deviceForm" method="POST" action="{{route('userdashboard.add.device.fs')}}">
        @csrf
        <div class="mb-3">
          <label for="serialnumber" class="form-label">Numer seryjny:</label>
          <input type="text" class="form-control" id="serialnumber" name="serialnumber" aria-describedby="serialHelp">
          <div id="serialHelp" class="form-text">Numer seryjny powinien znajdować się na urządzeniu oraz na fakturze.
          </div>
        </div>
        <div class="mb-3">
          <label for="purchase-date" class="form-label">Data zakupu:</label>
          <input type="date" class="form-control" id="purchase-date" name="purchase-date">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <div class="p-3 d-flex flex-column align-items-center">
      <h1>Dodaj urządzenie z poza serwisu</h1>
      <form id="deviceForm" method="POST" action="{{route('userdashboard.add.device.fo')}}">
        @csrf
        <div class="mb-3">
          <label for="brand" class="form-label">Marka:</label>
          <input required type="text" class="form-control" id="serialnumber" name="brand" aria-describedby="serialHelp">
          <div id="serialHelp" class="form-text">Np. Samsung
          </div>
          <label for="model" class="form-label">Model:</label>
          <input required type="text" class="form-control" id="serialnumber" name="model" aria-describedby="serialHelp">
          <div id="serialHelp" class="form-text">np. Galaxy S23
          </div>
          <label for="model" class="form-label">Typ urządzenie:</label>
          <input required type="text" class="form-control" id="serialnumber" name="type" aria-describedby="serialHelp">
          <div id="serialHelp" class="form-text">np. smartfon
          </div>
          <label for="serialnumber" class="form-label">Numer seryjny:</label>
          <input required type="text" class="form-control" id="serialnumber" name="serial_number"
            aria-describedby="serialHelp" pattern=".{9}" title="Numer seryjny musi mieć dokładnie 9 znaków.">
          <div id="serialHelp" class="form-text">Numer seryjny powinien znajdować się na urządzeniu oraz na
            fakturze/paragonie.</div>

        </div>
        <div class="mb-3">
          <label for="purchase-date" class="form-label">Data produkcji:</label>
          <input type="date" class="form-control" id="purchase-date" name="purchase-date" max="">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
  @endforeach
    </ul>
    </div>
  @endif

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //Styczeń to 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("purchase-date").max = today;
  </script>
</body>

</html>