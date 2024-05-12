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
    <div class="row justify-content-center align-items-center p-3 custom-row m-3">

      <div class="col-sm col-md-4 border border-primary p-3 border-radius">
        <div class="card text-bg-light">
          <img src="public/src/device.jpg" class="card-img" alt="...">
          <div class="card-img-overlay">
            <h5 class="card-title text-primary">Ostatnie naprawy</h5>
            <p class="card-text text-primary">Naciśnij "Zobacz więcej." przy urządzeniu aby
              zobaczyć szczegóły.</p>
            <p class="card-text"><small>Last updated 3 mins ago</small></p>
          </div>
        </div>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Urządzenie</th>
              <th>Marka</th>
              <th>Model</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Smartphone</td>
              <td>Samsung</td>
              <td>S23</td>
            </tr>
            <tr>
              <td>Smartphone</td>
              <td>Samsung</td>
              <td>S23</td>
            </tr>
            <tr>
              <td>Smartphone</td>
              <td>Samsung</td>
              <td>S23</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-sm col-md-4 border border-primary p-3 border-radius m-3">
        <div class="card text-bg-light">
          <img src="src/laptop.jpg" class="card-img" alt="...">
          <div class="card-img-overlay">
            <h5 class="card-title text-primary">Ostatnie naprawy</h5>
            <p class="card-text text-primary">Naciśnij "Zobacz więcej." przy naprawie aby
              zobaczyć jej szczegóły.</p>
            <p class="card-text"><small>Last updated 3 mins ago</small></p>
          </div>
        </div>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Urządzenie</th>
              <th>Marka</th>
              <th>Model</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>John</td>
              <td>Doe</td>
              <td>john@example.com</td>
            </tr>
            <tr>
              <td>Mary</td>
              <td>Moe</td>
              <td>mary@example.com</td>
            </tr>
            <tr>
              <td>July</td>
              <td>Dooley</td>
              <td>july@example.com</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row justify-content-center align-items-center p-3 custom-row ">
      <div class="col-sm col-md-8 border border-primary p-3 border-radius m-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
              role="tab" aria-controls="home" aria-selected="true">Opinie</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
              role="tab" aria-controls="profile" aria-selected="false">Dlaczego warto pisać opinie?</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
              role="tab" aria-controls="contact" aria-selected="false">Napisz swoją opinię!</button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
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