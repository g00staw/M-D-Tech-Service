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
            <h2>Usuń usługę</h2>
            <form id="removeServiceForm" method="POST" action="{{ route('admindashboard.remove.service') }}">
                @csrf
                @method('DELETE')
                <div class="mb-3">
                    <label for="service">Wybierz usługę:</label>
                    <select id="service" name="service_id" class="form-control">
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-danger">Usuń usługę</button>
            </form>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>