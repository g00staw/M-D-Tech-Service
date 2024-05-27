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

  <div class="container-fluid d-flex flex-column align-items-center m-3">
    <h1>Twoje urządzenia</h1>
    <div class="custom-container p-3 d-flex flex-column align-items-center">
      @if(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

      @if(session('info'))
    <div class="alert alert-info">
      {{ session('info') }}
    </div>
  @endif

      @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
      <div class="card" style="max-width: 50rem;">
        <div class="card-header">
          Dodaj urządzenie
        </div>
        <div class="card-body">
          <h5 class="card-title">Dodaj urządzenie do swojego konta.</h5>
          <p class="card-text">Jeśli posiadasz zakupione urządzenie, możesz dodać je do swojego konta poprzez podanie
            numeru seryjnego oraz daty zakupu.</p>
          <a href="{{route('userdashboard.add.device')}}" class="btn btn-primary">Dodaj urządzenie</a>
        </div>
      </div>
      @if ($devices->isEmpty())
    <h3>Brak urządzeń do wyświetlenia</h3>
  @else
  <div class="table-responsive m-3">
    <table class="table table-striped table-hover">
    <thead>
      <tr>
      <th class="m-3">Typ urządzenia</th>
      <th class="m-3">Marka</th>
      <th class="m-3">Model</th>
      <th class="m-3">Numer seryjny</th>
      <th class="m-3">Data zakupu</th>
      <th class="m-3">Koniec gwarancji</th>
      <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($devices as $device)
    <tr>
    <td>{{ $device->type }}</td>
    <td>{{ $device->brand }}</td>
    <td>{{ $device->model }}</td>
    <td>{{ $device->serial_number }}</td>
    <td>{{ $device->purchase_date }}</td>
    <td>{{ $device->end_of_warranty }}</td>
    <td><a class="text-primary" href="{{route('userdashboard.device', $device->id)}}">Zobacz więcej</a></td>
    </tr>
  @endforeach
    </tbody>
    </table>

  </div>
@endif
    </div>
    <!-- Linki do paginacji -->
    <div class="d-flex justify-content-center">
      {{ $devices->links() }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>