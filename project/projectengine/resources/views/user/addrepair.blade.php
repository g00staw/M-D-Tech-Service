<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>M&D Tech Service - Dodaj zgłoszenie</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link href="{{ asset('mystyles.css') }}" rel="stylesheet">

</head>

<body class="bg-gray">
  @include('shared.navbar')

  <div class="container-fluid d-flex flex-column align-items-center m-3">
    <h1>Dodaj zgłoszenie</h1>
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
    <form id="deviceForm" method="POST" action="{{route('userdashboard.add.repair.store')}}">
       @csrf
      <div class="mb-3">
        <label for="device_id">Wybierz urządzenie:</label>
        <select id="device_id" name="device_id" class="form-control">
            @foreach($devices as $device)
                <option value="{{ $device->id }}">{{ $device->brand }} {{ $device->model }}</option>
            @endforeach
        </select>
        <br>
        <div class="mb-3">
            <label for="title" class="form-label">Tytuł zgłoszenia</label>
            <input class="form-control" id="title" name="title" type="text" required placeholder="Np. rozbity ekran" aria-label="titleHelp">
            <div id="titleHelp" class="form-text">Podaj tytuł zgłoszenia, np. "rozbity ekran".</div>
        </div>
        <div class="mb-1">
            <label for="exampleFormControlTextarea1" class="form-label">Opis zgłoszenia</labe>
            <textarea class="form-control" id="exampleFormControlTextarea1" name="description" aria-describedby="dscHelp" rows="3"></textarea>
            <div id="dscHelp" class="form-text">Napisz szczegóły odnośnie zgłoszenia. Np. w jakim stanie znajduje się urządzenie, co się wydarzyło itp.</div>
        </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
  </div>
  @include('shared.footer')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>