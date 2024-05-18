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
    <h1>Dodaj urządzenie</h1>
    <div class="custom-container p-3 d-flex flex-column align-items-center">
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
    <form id="deviceForm" method="POST" action="{{route('userdashboard.add.device.store')}}">
       @csrf
      <div class="mb-3">
        <label for="serialnumber" class="form-label">Numer seryjny:</label>
        <input type="text" class="form-control" id="serialnumber" name="serialnumber" aria-describedby="serialHelp">
        <div id="serialHelp" class="form-text">Numer seryjny powinien znajdować się na urządzeniu oraz na fakturze.</div>
      </div>
      <div class="mb-3">
        <label for="purchase-date" class="form-label">Data zakupu:</label>
        <input type="date" class="form-control" id="purchase-date" name="purchase-date">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>