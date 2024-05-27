<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>M&D Tech Service - Dodaj zgłoszenie</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="{{ asset('mystyles.css') }}" rel="stylesheet">

</head>

<body class="bg-gray">
    @include('shared.navbar')

    <div class="container-fluid d-flex flex-column align-items-center m-3">
        <h1>Zgłoszenie</h1>
        <div class="custom-container p-3 d-flex flex-column align-items-center">
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

            <div class="card" style="width:550px;">
                <div class="card-body w-100">
                    <h5 class="card-title">Naprawa #{{ $repair->id }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $repair->repair_title }}</h6>
                    <p class="card-text">
                        <strong>Status:</strong> {{ $repair->status }}<br>
                        <strong>Urządzenie:</strong> {{ $repair->device->brand }} {{ $repair->device->model }}<br>
                        <strong>Data zgłoszenia:</strong> {{ $repair->report_date }}<br>
                        <strong>Data zakończenia:</strong> {{ $repair->completion_date }}<br>
                        <strong>Notatki użytkownika:</strong> {{ $repair->user_notes }}
                    </p>
                    <a href="#" class="card-link">Szczegóły</a>
                </div>

            </div>
            <hr>
            <div class="container d-flex flex-column align-items-center border border-radius p-3">
                <hr>
                <h2>Notatki naprawy:</h2>
                <div class="slider m-3" style="overflow-y: scroll; height: 200px; width:550px;">
                    @foreach ($notes as $note)
                        <div class="note">
                            <p><strong>Data wysłania:</strong> {{ $note->sent_date }}</p>
                            <p><strong>Treść wiadomości:</strong> {{ $note->message_content }}</p>
                        </div>
                        <hr>
                    @endforeach
                </div>
                <hr>
            </div>
            <div class="container d-flex flex-column align-items-center border border-radius p-3">
                <hr>
                <h2>Opłać naprawę:</h2>
                @if($payment->status != 'completed')
                    <form method="POST" action="{{ route('userdashboard.repair.payment', ['id' => $payment->id]) }}">
                        @csrf
                        <input type="hidden" name="repair_id" value="{{ $repair->id }}">
                        <div class="form-group">
                            <label for="amount">Kwota naprawy: {{ $payment->amount }} [PLN]</label>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Metoda płatności</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="credit_card">Karta kredytowa</option>
                                <option value="paypal">PayPal</option>
                                <option value="cash">Gotówka</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Zapłać</button>
                    </form>
                @endif

                <hr>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>