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
    <h1>Naprawy</h1>
    <div class="custom-container p-3 d-flex flex-column align-items-center">
      @if ($repairs->isEmpty())
      <h3>Brak urządzeń do wyświetlenia</h3>
       @else
      <div class="table-responsive m-3">
          <table class="table table-striped table-hover">
              <thead>
                  <tr>
                      <th class="m-3">Tytuł zgłoszenia</th>
                      <th class="m-3">Typ urządzenia</th>
                      <th class="m-3">Marka</th>
                      <th class="m-3">Model</th>
                      <th class="m-3">Numer seryjny</th>
                      <th class="m-3">Status naprawy</th>
                      <th class="m-3">Data zgłoszenia</th>
                      <th class="m-3">Data ukończenia naprawy</th>
                      <th class="m-3">Opis zgłoszenia</th>
                      <th class="m-3">Osoba naprawiająca</th>
                      <th></th>
                  </tr>
                  @foreach ( $repairs as $repair )
                  <tr>
                        <td>{{$repair->repair_title}}</td>
                        @if($repair->device === null)
                          <td>Brak danych / urządzenie zostało usunięte</td>
                          <td>Brak danych / urządzenie zostało usunięte</td>
                          <td>Brak danych / urządzenie zostało usunięte</td>
                          <td>Brak danych / urządzenie zostało usunięte</td>
                        @else
                        <td>{{$repair->device->type}}</td>
                        <td>{{$repair->device->brand}}</td>
                        <td>{{$repair->device->model}}</td>
                        <td>{{$repair->device->serial_number}}</td>
                        @endif
                        <td>{{$repair->status}}</td>
                        <td>{{$repair->report_date}}</td>
                        <td>{{$repair->completion_date}}</td>
                        <td>{{$repair->user_notes}}</td>
                       
                        <td>
                        @if ($repair->status == 'zgłoszone')
                        <p>Nie przypisano</p>
                        @else
                        {{$repair->employee->name}}
                        @endif
                        </td>
                  </tr>
                  @endforeach
              </thead>
              <tbody>

              </tbody>
          </table>
          
      </div>
      @endif
      <div class="container mt-5">
      <ul class="pagination pagination-sm justify-content-center">
        @for ($i = 1; $i <= $repairs->lastPage(); $i++)
      <li class="page-item {{ ($repairs->currentPage() == $i) ? 'active' : '' }}">
      <a class="page-link" href="{{ $repairs->url($i) }}">{{ $i }}</a>
      </li>
    @endfor
      </ul>
    </div>
    </div>
    
    <div class="d-flex justify-content-center">

    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
@include('shared.footer')
</html>