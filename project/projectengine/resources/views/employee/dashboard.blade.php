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

  <div class="container-fluid ">
    <div class="container d-flex flex-column justify-content-center ">
      <h2>Pulpit</h2>
      <div class="container d-flex justify-content-center flex-wrap">
        <div class="card bg-success bg-opacity-25 m-3  custom-card shadow" style="witdh:18rem;">
          <div class="card-header p-3 pt-2">
            <div
              class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Liczba wszystkich aktywnych napraw:</p>
              <h4 class="mb-0">{{$numberOfActiveRepairs}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
          </div>
        </div>
        <div class="card bg-primary bg-opacity-25 m-3  custom-card shadow" style="witdh:18rem;">
          <div class="card-header p-3 pt-2">
            <div
              class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Liczba twoich aktywnych napraw:</p>
              <h4 class="mb-0">{{$numberOfUnfinishedRepairs}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
          </div>
        </div>
        <div class="card bg-danger bg-opacity-25 m-3  custom-card shadow" style="witdh:18rem;">
          <div class="card-header p-3 pt-2">
            <div
              class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Liczba oczekujących napraw:</p>
              <h4 class="mb-0">{{$reportedRepairs}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
          </div>
        </div>

      </div>

      <div class="container mt-5 d-flex flex-column">
        <h2>Lista oczekujących zgłoszeń</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Opis zgłoszenia</th>
                <th>Data zgłoszenia</th>
                <th>Typ urzązenia</th>
                <th style="width: 10rem;">Nazwa urządzenia</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($repairs as $repair)
        <tr>
          <td> {{ $repair->id }}</td>
          <td> {{ $repair->repair_title }}</td>
          <td> {{ $repair->user_notes }}</td>
          <td> {{ $repair->report_date }}</td>
          <td> {{ $repair->device->type }}</td>
          <td> {{ $repair->device->brand }} {{ $repair->device->model }}</td>
        </tr>
      @endforeach
            </tbody>
          </table>
          <div class="col-12 d-flex justify-content-center">
                {{ $repairs->links('pagination::bootstrap-4') }}
          </div>

        </div>
      </div>
      <div class="container d-flex justify-content-center">
        <h3>Przypisz naprawe: </h3>
        <form id="assignRepairForm" action="{{ route('employeedashboard.assignRepairToEmployee') }}" method="POST">
          @csrf
          <input type="hidden" name="employee_id" value="{{ Auth::guard('employee')->user() }}">
          <select id="repair_id" name="repair_id" class="form-control text-sm" style="width: 12rem;">
            @foreach($repairs as $repair)
        <option class="text-sm" value="{{ $repair->id }}">
        <p class="text-sm">ID: {{ $repair->id }}, {{ $repair->device->brand }}
          {{ $repair->device->model }}
        </p>
        </option>
      @endforeach
          </select>
          <div class="dropdown-divider"></div>
          <button type="submit" class="btn m-2 btn-warning">Przypisz</button>
        </form>
      </div>

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


      <div class="container mt-5 d-flex flex-column">
        <h2>Lista oczekujących zgłoszeń</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Opis zgłoszenia</th>
                <th>Data zgłoszenia</th>
                <th>Typ urzązenia</th>
                <th style="width: 10rem;">Nazwa urządzenia</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($yourrepairs as $yrepair)
        <tr>
          <td> {{ $yrepair->id }}</td>
          <td> {{ $yrepair->repair_title }}</td>
          <td> {{ $yrepair->user_notes }}</td>
          <td> {{ $yrepair->report_date }}</td>
          <td> {{ $yrepair->device->type }}</td>
          <td> {{ $yrepair->device->brand }} {{ $yrepair->device->model }}</td>
          <td><a href="{{ route('employeedashboard.repair', ['id' => $yrepair->id]) }}" class="btn btn-primary">Przejdź</a></td>
        </tr>
      @endforeach
            </tbody>
          </table>
          <div>
          <div class="col-12 d-flex justify-content-center">
                {{ $yourrepairs->links('pagination::bootstrap-4') }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
@include('shared.footer')
</html>