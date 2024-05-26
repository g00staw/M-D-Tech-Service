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

  <div class="container-fluid m-3">

    <div class="container d-flex flex-column justify-content-center">
      <h2>Pulpit</h2>
      <div class="container m-3 d-flex justify-content-center border custom-card">
        <div class="card w-25 bg-primary bg-opacity-25 m-3 custom-card shadow">
          <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Przychody z ostatnich 30 dni</p>
              <h4 class="mb-0">{{$lastMonthIncome}} [PLN]</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
        </div>
        <div class="card w-25 bg-primary bg-opacity-25 m-3 custom-card shadow">
          <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
              <i class="material-icons opacity-10"></i>
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Przychody z ostatnich 7 dni</p>
              <h4 class="mb-0">{{$lastWeekIncome}} [PLN]</h4>
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
    </div>
    <div class="container d-flex flex-column justify-content-center">
        <h3>Dochód z ostatnich 7 dni</h3>
      <div class="m-1 d-flex justify-content-center border custom-card">
        @if ($hasData)
            <canvas class="w-50 h-50" id="barChart"></canvas>
        @else
            <p>No data available</p>
        @endif
      </div>
    </div>
    <div class="container d-flex flex-column justify-content-center">
        <h3>Dochód z ostatnich 30 dni</h3>
      <div class="m-1 d-flex justify-content-center border custom-card">
        @if ($hasData2)
            <canvas class="w-100 h-100" id="barChart2"></canvas>
        @else
            <p>No data available</p>
        @endif
      </div>
      <div class="container d-flex flex-column justify-content-center">
        <h3>Historia płatności</h3>
        <div class="m-1 d-flex justify-content-center border custom-card">
        <div class="table-responsive m-3">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="m-3"></th>
                            <th class="m-3">Marka</th>
                            <th class="m-3">Model</th>
                            <th class="m-3">Numer seryjny</th>
                            <th class="m-3">Data zakupu</th>
                            <th class="m-3">Koniec gwarancji</th>
                            <th class="m-3">Nazwa właściciela</th>
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
                                <td>{{ $device->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
  @if ($hasData2)
    <script>
      var ctx = document.getElementById('barChart2').getContext('2d');
      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: @json($data2['labels2']),
              datasets: [{
                  label: 'Dochód [PLN]',
                  data: @json($data2['data2']),
                  backgroundColor: 'rgba(38, 172, 62, 0.75)',
                  borderColor: 'rgba(15, 251, 58, 1)',
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

</html>