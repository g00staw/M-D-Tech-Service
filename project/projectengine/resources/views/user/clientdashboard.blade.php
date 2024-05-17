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
    <div class="custom-container">
      <div id="carouselExampleCaptions" class="carousel slide p-3" data-bs-ride="false">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner justify-content-center">
          <div class="carousel-item active justify-content-center">
            <img class="d-block border-radius" src="/src/fix.jpg" alt="Naprawa elektroniki" />
            <div class="carousel-caption d-none d-md-block text-dark bg-white bg-opacity-50 border-radius">
              <h5>Naprawy</h5>
              <p>Zobacz swoje aktywne naprawy. Naciśnij <a href="" class="text-primary">zobacz więcej</a> aby przejść do
                tabeli z naprawami.</p>
            </div>
          </div>
          <div class="carousel-item justify-content-center">
            <img class="d-block border-radius" src="/src/phone2.jpg" alt="Telefon" />
            <div class="carousel-caption d-none d-md-block text-dark bg-white bg-opacity-50 border-radius">
              <h5>Urządzenia</h5>
              <p>Zobacz swoje urządzenia. Naciśnij <a href="" class="text-primary">zobacz więcej</a> aby przejść do
                tabeli z urządzeniami.</p>
            </div>
          </div>
          <div class="carousel-item justify-content-center">
            <img class="d-block border-radius" src="/src/mail.jpg" alt="mail" />
            <div class="carousel-caption d-none d-md-block text-dark bg-white bg-opacity-50 border-radius">
              <h5>Tickety / Zgłoszenia</h5>
              <p>Zobacz swoje tickety. Naciśnij <a href="" class="text-primary">zobacz więcej</a> aby przejść do strony
                z ticketami.</p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
          data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
          data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>

    <div class="container border border-primary bg border-radius">
      <div class="d-flex flex-column align-items-center p-3 ">
        <h2>Dostępne usługi</h2>
        <div class="container d-flex flex-wrap justify-content-center">
            @foreach ($services as $service)
              <div class="card m-3" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">{{$service -> title}}</h5>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Cena min*: {{$service -> price_min}}</h6>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Cena max*: {{$service -> price_max}}</h6>
                  <p class="card-text">{{$service -> description}}</p>
                  <div class="mt-auto p-2">
                    <a href="#" class="card-link text-primary">Zobacz więcej.</a>
                  </div>
                </div>
              </div>
            @endforeach
            
        </div>
        <h6 class="card-subtitle mb-2 text-body-secondary">* - cena proponowana, zależna od urządzenia oraz wartości części</h6>
      </div>
    </div>

    <div class="row justify-content-center align-items-center p-3 custom-row">
      <div class="col-sm col-md-8 border border-primary p-3 border-radius m-3 custom-container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
              role="tab" aria-controls="home" aria-selected="true">Opinie</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
              role="tab" aria-controls="profile" aria-selected="false">Dlaczego warto pisać opinie?</button>
          </li>
        </ul>
        <div class="tab-content p-3 flex-column justify-content-center" id="myTabContent">
          <div class="flex-column tab-pane fade show active justify-content-center" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="d-inline-flex justify-content-center">
              @foreach ($ratings as $rating)
               <div class="card text-bg-primary m-1" style="max-width: 18rem;">
                   <div class="card-header">
                     <p class="font-weight-light">Użytkownik:</p>
                     <h5>{{ $rating->user->name }}</h5>
                   </div>
                   <div class="card-body">
                       <p class="font-weight-light">Tytuł naprawy:</p>
                       <h5 class="card-title">{{ $rating->repair->repair_title }}</h5>
                       <h5 class="card-title">Ocena: {{ $rating->rating }} / 5</h5>
                       <p class="card-text">Komenatrz: {{ $rating->review }}</p>
                   </div>
               </div>
              @endforeach
            </div>
        
            <ul class="pagination pagination-sm justify-content-center">
              @for ($i = 1; $i <= $ratings->lastPage(); $i++)
                  <li class="page-item {{ ($ratings->currentPage() == $i) ? 'active' : '' }}">
                      <a class="page-link" href="{{ $ratings->url($i) }}">{{ $i }}</a>
                  </li>
              @endfor
           </ul>

          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container">
              <div class="row">
                <div class="col">
                <h3 class="fs-1 fs-2 fs-4">Dlaczego warto oceniać produkty?</h3>
                  <p class="fs-1 fs-2 fs-4">
                  Pomagasz innym klientom zdecydować się na naprawę swoich urządzeń.  <br>
                  Przekazujesz nam cenne wskazówki o ofercie i jakości usług. <br>
                  Dołączysz do grona ekspertów naszego serwisu! <br>
                  </p>
                  <p class="fs-4">
                    Napisz swoją opinię! <a class="text-primary">Zobacz więcej.</a>
                  </p>
                </div>
                <div class="col">
                  <img src="/src/like.jpg" class="img-fluid border-radius">
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
</body>

</html>