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

    <div class="container-fluid d-flex flex-column align-items-center ">
        <div class="container justify-content-center">
            <h1>Historia płatności</h1>
            <div class="container d-flex justify-content-center">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($payments->isEmpty())
                    <h3>Brak płatności do wyświetlenia</h3>
                @else
                    <div class="table-responsive m-3">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kwota</th>
                                    <th>Status</th>
                                    <th>Metoda płatności</th>
                                    <th>Data płatności</th>
                                    <th>Data utworzenia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td>{{ $payment->status }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->payment_date }}</td>
                                        <td>{{ $payment->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Aktywne płatności</h5>
                <p class="card-text">Liczba płatności oczekujących na zatwierdzenie: {{ $pendingPaymentsCount }}</p>
                @if ($pendingPaymentsCount>0)
                <a href="{{route('userdashboard.repairs')}}" class="btn btn-primary">Przejdź</a>
                @endif
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