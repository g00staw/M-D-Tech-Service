<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>M&D Tech Service - Panel użytkownika</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link href="{{ asset('mystyles.css') }}" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  

</head>

<body class="bg-gray">
  @include('shared.navbar')

  <div class="container-fluid">

    <div class="container d-flex flex-column justify-content-center">
      <h2>Pulpit</h2>
      <div class="container d-flex flex-wrap justify-content-center">
        <div class="card bg-primary bg-opacity-25 m-3 custom-card shadow" style="width: 18rem;">
          <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Przychody z ostatnich 7 dni</p>
              <h4 class="mb-0">{{$lastWeekIncome}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"> 
              @if ($comparison['percentage_change'] > 0)
                  +{{ $comparison['percentage_change'] }}%
              @elseif ($comparison['percentage_change'] < 0)
                  {{ $comparison['percentage_change'] }}%
              @else
                  brak zmiany
              @endif</span>względem poprzedniego tygodnia.</p>
          </div>
    </div>
    <div class="card bg-success bg-opacity-25 m-3  custom-card shadow" style="width: 18rem;">
          <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Liczba wszystkich użytkowników:</p>
              <h4 class="mb-0">{{$numberOfUsers}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
            
          </div>
    </div>
    <div class="card bg-warning bg-opacity-25 m-3  custom-card shadow" style="width: 18rem;">
          <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Liczba wszystkich pracowników:</p>
              <h4 class="mb-0">{{$numberOfEmployees}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
          </div>
    </div>
    <div class="card bg-danger bg-opacity-25 m-3  custom-card shadow" style="width: 18rem;">
          <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Liczba aktywnych zgłoszeń:</p>
              <h4 class="mb-0">{{$numberOfActiveRepairs}}</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
           
          </div>
    </div>
      </div>
      
    </div>
    <div class="container d-flex flex-column justify-content-center">
      <h3>Dochód z ostatnich 7 dni</h3>
      <div class="d-flex justify-content-center">
        @if ($hasData)
            <canvas class="" id="barChart"></canvas>
        @else
            <p>No data available</p>
        @endif
      </div>
    </div>

    <div class="container d-flex flex-column">
      <h2>Skróty</h2>
      <div class="d-flex justify-content-center flex-wrap">
        <div class="card m-3 custom-card shadow" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Pracownicy</h5>
            <h6 class="card-subtitle mb-2 text-muted">Dashboard do zarządzania pracownikami</h6>
            <p class="card-text">Zobacz podsumowanie pracowników, zarządzaj pracownikami.</p>
            <a href="{{ route('admindashboard.employees') }}" class="btn btn-primary">Przejdź</a>
          </div>
        </div>
        <div class="card m-3 custom-card shadow" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Usługi</h5>
            <h6 class="card-subtitle mb-2 text-muted">Dashboard do zarządzania usługami.</h6>
            <p class="card-text">Zobacz dostępne usługi, zarządzaj usługami.</p>
            <a href="{{ route('admindashboard.services') }}" class="btn btn-primary">Przejdź</a>
          </div>
        </div>
        <div class="card m-3 custom-card shadow" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Urządzenia</h5>
            <h6 class="card-subtitle mb-2 text-muted">Dashboard do zarządzania urządzeniami.</h6>
            <p class="card-text">Zobacz podsumowanie urządzeń, zarządzaj urządzeniami.</p>
            <a href="{{ route('admindashboard.devices') }}" class="btn btn-primary">Przejdź</a>
          </div>
        </div>
        <div class="card m-3 custom-card shadow" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Naprawy / zgłoszenia</h5>
            <h6 class="card-subtitle mb-2 text-muted">Dashboard do zarządzania naprawami / zgłoszeniami.</h6>
            <p class="card-text">Zobacz podsumowanie napraw oraz zgłoszeń, zarządzaj zgłoszeniami.</p>
            <a href="{{ route('admindashboard.repairs') }}" class="btn btn-primary">Przejdź</a>
          </div>
        </div>
        <div class="card m-3 custom-card shadow" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Finanse</h5>
            <h6 class="card-subtitle mb-2 text-muted">Dashboard do zarządzania naprawami / zgłoszeniami.</h6>
            <p class="card-text">Zobacz podsumowanie napraw oraz zgłoszeń, zarządzaj zgłoszeniami.</p>
            <a href="{{ route('admindashboard.finanse') }}" class="btn btn-primary">Przejdź</a>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  @if ($hasData)
    <script>
      var ctx = document.getElementById('barChart').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: @json($data['labels']),
              datasets: [{
                  label: 'Dochód [PLN]',
                  data: @json($data['data']),
                  backgroundColor: 'rgba(42, 167, 255, 0.5)',
                  borderColor: 'rgba(42, 60, 255, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
    </script>
  @endif
</body>
@include('shared.footer')
</html>