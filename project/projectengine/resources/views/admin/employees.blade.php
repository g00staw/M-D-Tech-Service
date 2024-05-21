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
    
    <div class="container mt-5 d-flex flex-column">
      <h1>Employees List</h1>
      <table class="table table-bordered">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Imię</th>
                  <th>E-mail</th>
                  <th></th>
                  <th></th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              @foreach ($employees as $employee)
                  <tr>
                      <td>{{ $employee->id }}</td>
                      <td>{{ $employee->name }}</td>
                      <td>{{ $employee->email }}</td>
                      <td class="d-flex"><a href="#" class="btn btn-primary">Zobacz więcej</a></td>
                      <td><a href="#" class="btn btn-warning">Edytuj</a></td>
                      <td><a href="#" class="btn btn-danger">Usuń</a></td>
                  </tr>
              @endforeach
          </tbody>
      </table>

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