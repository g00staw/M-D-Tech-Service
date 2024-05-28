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
        <h1>Zarejestrowane urządzenia</h1>
        <div class="d-flex flex-column align-items-center">
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

            <div class="slider customslider m-3" style="overflow-y: scroll; ">
                <div class="container-fluid d-flex flex-column">
                    @if ($devices->isEmpty())
                    <h3>Brak urządzeń do wyświetlenia</h3>
                    @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="">Typ urządzenia</th>
                                    <th class="">Marka</th>
                                    <th class="">Model</th>
                                    <th class="">Numer seryjny</th>
                                    <th class="">Data zakupu</th>
                                    <th class="">Koniec gwarancji</th>
                                    <th class="">Nazwa właściciela</th>
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
                                        <td>
                                            @if (is_null($device->user))
                                                <p>brak danych</p>
                                            @else
                                                {{ $device->user->name }}
                                            @endif


                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Usuń urządzenie
                                                </button>
                                                <div class="dropdown-menu">
                                                    <form
                                                        action="{{ route('admindashboard.device.delete', ['id' => $device->id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Czy na pewno chcesz usunąć to urządzenie?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="device_id" value="{{ $device->id }}">
                                                        <label for="password" class=" text-danger">Podaj swoje hasło w celu
                                                            potwierdzenia:</label><br>
                                                        <input type="password" class=" rounded" id="password"
                                                            name="password" required><br>
                                                        <div class="dropdown-divider"></div>
                                                        <button type="submit" class="btn btn-danger">Usuń</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

            </div>

            <div class="container">
                <ul class="pagination pagination-sm justify-content-center">
                    @for ($i = 1; $i <= $devices->lastPage(); $i++)
                        <li class="page-item {{ ($devices->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $devices->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
        <!-- Linki do paginacji -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}"></script>
</body>
@include('shared.footer')
</html>