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
    <h1>Pracownicy</h1>
    
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
                    <th style="width: 7rem;"></th>
                    <th style="width: 7rem;"></th>
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
                        <td><a href="#" class="btn text-center d-flex btn-primary btn-sm">Przypisz zgłoszenie</a></td>
                        <td><a href=" {{ route('admindashboard.employeeinfo', ['id' => $employee->id]) }} " class="btn text-center d-flex btn-primary btn-sm">Zobacz więcej</a></td>
                        <td><a href="#" class="btn text-center d-flex btn-warning btn-sm">Edytuj</a></td>
                        <td><a href="#" class="btn text-center d-flex btn-danger btn-sm">Usuń</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

      <!-- Linki do paginacji -->
      {{ $employees->links() }}
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>