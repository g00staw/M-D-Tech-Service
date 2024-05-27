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

  <div class="container-fluid d-flex flex-column align-items-center justify-content-center">
    <h1>Pracownicy | Zgłoszenia</h1>
    <div class="container mt-5 d-flex border custom-card justify-content-between">
      <h4 class="text-sm mb-0 text-capitalize">Liczba aktywnych zgłoszeń:</h4>
      <h4 class="text-primary">{{$numberOfActiveRepairs}}</h4>
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
        <ul class="pagination pagination-sm justify-content-center">
          @for ($i = 1; $i <= $repairs->lastPage(); $i++)
      <li class="page-item {{ ($repairs->currentPage() == $i) ? 'active' : '' }}">
        <a class="page-link" href="{{ $repairs->url($i) }}">{{ $i }}</a>
      </li>
    @endfor
        </ul>
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
        <h2>Lista pracowników</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>E-mail</th>
                <th>Ilość przypisanych napraw</th>
                <th>Il. ukoń. napraw w ciągu 7 dni</th>
                <th style="width: 10rem;"></th>
                <th style="width: 9rem;"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($employees as $employee)
        <tr>
          <td>{{ $employee->id }}</td>
          <td>{{ $employee->name }}</td>
          <td>{{ $employee->email }}</td>
          <td>{{ $employee->activeRepairsCount }}</td>
          <td>{{ $employee->completedRepairsThisWeek }}</td>
          <td>
          <div class="btn-group">
            <button type="button" class="btn btn-sm btn-warning dropdown-toggle m-1" data-bs-toggle="dropdown"
            aria-expanded="false">
            Przypisz zgłoszenie
            </button>
            <div class="dropdown-menu p-1">
            <form id="assignRepairForm"
              action="{{ route('admindashboard.employees.assignRepairToEmployee') }}" method="POST">
              @csrf
              <input type="hidden" name="employee_id" value="{{ $employee->id }}">

              <select id="repair_id" name="repair_id" class="form-control text-sm" style="width: 12rem;">
              @foreach($repairs as $repair)
        <option class="text-sm" value="{{ $repair->id }}">
          <p class="text-sm">ID: {{ $repair->id }}, {{ $repair->device->brand }}
          {{ $repair->device->model }}</p>
        </option>
      @endforeach
              </select>
              <div class="dropdown-divider"></div>
              <button type="submit" class="btn m-2 btn-warning">Przypisz</button>
            </form>
            </div>
          </div>
          </td>
          <td><a href=" {{ route('admindashboard.employeeinfo', ['id' => $employee->id]) }} "
            class="btn text-center d-flex btn-primary btn-sm">Zobacz więcej</a></td>
        </tr>
      @endforeach
            </tbody>
          </table>
          <ul class="pagination pagination-sm justify-content-center">
            @for ($i = 1; $i <= $employees->lastPage(); $i++)
        <li class="page-item {{ ($employees->currentPage() == $i) ? 'active' : '' }}">
        <a class="page-link" href="{{ $employees->url($i) }}">{{ $i }}</a>
        </li>
      @endfor
          </ul>
        </div>

      </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>