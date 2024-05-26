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
        <h1>Obsługa zgłoszenia</h1>
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

            <div class="card">
                <div class="card-body w-100">
                    <h5 class="card-title">Naprawa #{{ $repair->id }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $repair->repair_title }}</h6>
                    <p class="card-text">
                        <strong>Status:</strong> {{ $repair->status }}<br>
                        <strong>Data zgłoszenia:</strong> {{ $repair->report_date }}<br>
                        <strong>Data zakończenia:</strong> {{ $repair->completion_date }}<br>
                        <strong>Notatki użytkownika:</strong> {{ $repair->user_notes }}
                    </p>
                    <a href="#" class="card-link">Szczegóły</a>
                </div>

            </div>
            <hr>
            <div class="container d-flex flex-column align-items-center border border-radius p-3">
                <h2>Wybierz stan zgłoszenia</h2>
                <div class="form-group d-flex align-items-center justify-content-center">

                    <form id="deviceForm" method="POST" action="{{route('userdashboard.add.repair.store')}}">
                        @csrf
                        <select name="status" class="form-control">
                            <option value="w trakcie realizacji">W realizacji</option>
                            <option value="oczekiwanie na częsci">Oczekiwanie na częsci</option>
                            <hr>
                            <option value="ukończono">Ukończono</option>
                        </select>
                        <div id="dscHelp" class="form-text">Po wybraniu opcji ukończono zgłoszenie zostanie zablokowane,
                            zachowaj ostrożność.</div>
                        <button type="submit" class="btn btn-primary">Zmień status</button>
                    </form>

                </div>
                <div class="slider" style="overflow-y: scroll; height: 200px;">
                    @foreach ($notes as $note)
                        <div class="note">
                            <p><strong>Data wysłania:</strong> {{ $note->sent_date }}</p>
                            <p><strong>Treść wiadomości:</strong> {{ $note->message_content }}</p>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>

            <h2>Dodaj notatki do naprawy</h2>
            <form method="POST" action="{{ route('employeedashboard.addRepairNote', ['id' => $repair->id]) }}">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="repair_id" value="{{ $repair->id }}">
                    <label for="message_content">Treść notatki:</label>
                    <textarea name="message_content" class="form-control" id="message_content" rows="3"
                        required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Dodaj notatkę</button>
            </form>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>