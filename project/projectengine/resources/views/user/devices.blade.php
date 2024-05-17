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
    <div class="custom-container p-3">
      <div class="table-responsive">
          <table class="table table-striped table-hover">
              <thead>
                  <tr>
                      <th>Typ urządzenia</th>
                      <th>Marka</th>
                      <th>Model</th>
                      <th>Numer seryjny</th>
                      <th>Data zakupu</th>
                      <th>Koniec gwarancji</th>
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
                      <td><a class="text-primary" href="">Zobacz więcej</a></td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
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