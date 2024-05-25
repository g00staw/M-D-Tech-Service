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
    <div class="container mt-5 d-flex flex-column  border border-radius">
      <h2>Dodaj usługę</h2>
      <form id="deviceForm" method="POST" action="{{ route('admindashboard.add.service') }}">
    @csrf
    <div class="mb-3">
        <div class="mb-3">
            <label for="add_title" class="form-label">Tytuł usługi</label>
            <input class="form-control" id="add_title" name="title" type="text" required placeholder="Np. rozbity ekran" aria-label="titleHelp">
            <div id="titleHelp" class="form-text">Podaj tytuł usługi, np. "Wymiana ekranu w smartfonie".</div>
        </div>
        <div class="mb-3">
            <label for="add_min_p" class="form-label">Cena min. usługi</label>
            <input class="form-control" id="add_min_p" name="min_price" type="number" step="0.01" required placeholder="100" aria-label="titleHelp">
            <div id="titleHelp" class="form-text">Podaj cenę minimalną usługi.</div>
        </div>
        <div class="mb-3">
            <label for="add_max_p" class="form-label">Cena maks. usługi</label>
            <input class="form-control" id="add_max_p" name="max_price" type="number" step="0.01" required placeholder="200" aria-label="titleHelp">
            <div id="titleHelp" class="form-text">Podaj cenę maksymalną usługi.</div>
        </div>
        <div class="mb-1">
            <label for="add_dsc" class="form-label">Opis usługi</label>
            <textarea class="form-control" id="add_dsc" name="description" aria-describedby="dscHelp" rows="3"></textarea>
            <div id="dscHelp" class="form-text">Napisz opis odnośnie usługi. Na czym polega, o ile zostanie odnowiona gwarancja itp.</div>
        </div>
        <button type="submit" class="btn btn-primary">Zatwierdź zmiany</button>
    </div>
    </form>
    </div>


      <script>
        function fillForm() {
          var select = document.getElementById('service');
          var selectedOption = select.options[select.selectedIndex];

          document.getElementById('title').value = selectedOption.getAttribute('data-title');
          document.getElementById('cenmin').value = selectedOption.getAttribute('data-min-price');
          document.getElementById('cenmax').value = selectedOption.getAttribute('data-max-price');
          document.getElementById('exampleFormControlTextarea1').value = selectedOption.getAttribute('data-description');
        }
      </script>

    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>