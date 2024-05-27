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

  <div class="container-fluid d-flex flex-column align-items-center m-3 justify-content-center">
    <div class="container mt-5 d-flex flex-column border border-radius">
      <h2>Dodaj opinię</h2>

      <!-- Display validation errors -->
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <!-- Display success message -->
      @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      @if ($repairs->isEmpty())
        <div class="alert alert-info">
          Brak ukończonych napraw do oceny.
        </div>
      @else
        <form id="reviewForm" method="POST" action="{{ route('userdashboard.add.review') }}">
          @csrf
          <div class="mb-3">
              <label for="repair_id" class="form-label">Wybierz naprawę</label>
              <select class="form-control" id="repair_id" name="repair_id" required>
                @foreach ($repairs as $repair)
                    <option value="{{ $repair->id }}">{{ $repair->repair_title }}</option>
                @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label for="rating" class="form-label">Ocena</label>
              <select class="form-control" id="rating" name="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
          </div>
          <div class="mb-3">
              <label for="review" class="form-label">Opinia</label>
              <textarea class="form-control" id="review" name="review" rows="3" placeholder="Napisz swoją opinię"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Zatwierdź opinię</button>
        </form>
      @endif
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
