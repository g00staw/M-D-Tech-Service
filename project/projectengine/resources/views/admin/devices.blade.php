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
        <h1>Zarejestrowane urządzenia</h1>
        <div class="custom-container p-3 d-flex flex-column align-items-center">
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
            <div class="table-responsive m-3">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="m-3">ID płatności</th>
                            <th class="m-3">Użytkownik</th>
                            <th class="m-3">ID naprawy</th>
                            <th class="m-3">Nazwa naprawy</th>
                            <th class="m-3">Metoda płatności</th>
                            <th class="m-3">Data płatności</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->user->name }}</td>
                                <td>{{ $payment->repair_id }}</td>
                                <td>{{ $payment->repair->repair_title }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->payment_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="container mt-5">
                <ul class="pagination pagination-sm justify-content-center">
                    @for ($i = 1; $i <= $payments->lastPage(); $i++)
                        <li class="page-item {{ ($payments->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $payments->url($i) }}">{{ $i }}</a>
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

</html>