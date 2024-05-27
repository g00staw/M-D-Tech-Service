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
    <h1>{{$device->brand}} {{$device->model}}</h1>
    <div class="custom-container p-3">
    <div class="card d-flex flex-column" style="">
      <div class="card-body">
          <h5 class="card-title">Typ urządzenia: {{$device->type}}</h5>
          <h5 class="card-title">Data zakupu: {{$device->purchase_date}}</h5>
          <h5 class="card-title">Koniec gwarancji: {{$device->end_of_warranty}},
            @if ($months_left > 0)
             <p class="text-success">pozostało {{$months_left}} miesięcy.</p> </h5>
            @else
             <p class="text-danger">gwarancja jest przedawniona.</p>
            @endif 
            
            <h6 class="card-subtitle mb-2 text-body-secondary">Numer seryjny: {{$device -> serial_number}}</h6>
          <!-- <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
          <a href="#" class="card-link">Card link</a>
          <a href="#" class="card-link">Another link</a> -->
        </div>
      </div>
    </div>
  </div>
  @include('shared.footer')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>