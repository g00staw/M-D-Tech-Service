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
    <div class="container">
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
    </div>
    <div class="container mt-5 d-flex flex-column">
      <section style="background-color: #eee;">
        <div class="container py-5">
          <div class="row">
            <div class="col">
            </div>
          </div>

          <div class="row">
            <div class="col-lg-4">
              <div class="card mb-4">
                <div class="card-body text-center">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                    class="rounded-circle img-fluid" style="width: 150px;">
                  <h5 class="my-3">{{ $employee->name }}</h5>
                  <div class="d-flex justify-content-center mb-2">
                    <div class="btn-group">
                      <button type="button" class="btn btn-warning dropdown-toggle m-1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Zmień wynagrodzenie
                      </button>
                      <div class="dropdown-menu">
                        <form id="salaryForm"
                          action="{{ route('admindashboard.employee.updatesalary', ['id' => $employee->id]) }}"
                          method="POST">
                          @csrf
                         
                          <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                          <label for="salary" class="m-2 form-label">Nowa pensja:</label><br>
                          <input type="number" class="m-2 rounded form-label" id="salary" name="salary"><br>
                          <div class="dropdown-divider"></div>
                          <button type="submit" class="btn m-2 btn-warning">Potwierdź</button>
                        </form>
                      </div>
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-danger dropdown-toggle m-1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Zwolnij
                      </button>
                      <div class="dropdown-menu">
                        <form action="{{ route('admindashboard.employee.delete', ['id' => $employee->id]) }}"
                          method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć tego pracownika?');">
                          @csrf
                          @method('DELETE')
                          <label for="password" class="m-2 text-danger">Podaj swoje hasło w celu
                            potwierdzenia:</label><br>
                          <input type="password" class="m-2 rounded" id="password" name="password" required><br>
                          <div class="dropdown-divider"></div>
                          <button type="submit" class="btn m-2 btn-danger">Zwolnij pracownika</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="card mb-4">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Imię, Nazwisko:</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{ $employee->name }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{ $employee->email }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <p class="mb-0">Pensja:</p>
                    </div>
                    <div class="col-sm-9">
                      <p class="text-muted mb-0">{{ $employee->salary }} [PLN] / msc </p>
                    </div>
                  </div>
                  <hr>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4 mb-md-0">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <p class="mr-3" style="font-size: 1.25rem;">Aktywne naprawy: </p>
                        <p class="ml-1 text-primary" style="font-size: 1.25rem;">{{ $activeRepairs }}</p>
                      </div>
                      <hr>
                      <div class="d-flex justify-content-between">
                        <p class="mr-3" style="font-size: 1.25rem;">Liczba wykonanych napraw przez ostatnie 7 dni: </p>
                        <p class="ml-1 text-primary" style="font-size: 1.25rem;">{{ $compRepTWeek }}</p>
                      </div>
                      <hr>
                      <div class="d-flex justify-content-between">
                        <p class="mr-3" style="font-size: 1.25rem;">Liczba wykonanych napraw przez ostatnie 30 dni: </p>
                        <p class="ml-1 text-primary" style="font-size: 1.25rem;">{{ $compRepTMonth }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
          <script src="{{ asset('js/app.js') }}"></script>
          <script>
            $('.dropdown-toggle').dropdown()
          </script>
</body>
@include('shared.footer')
</html>