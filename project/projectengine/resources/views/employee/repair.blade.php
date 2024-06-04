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
                <h2>Wybierz stan zgłoszenia</h2>
                <div class="form-group d-flex align-items-center justify-content-center">

                    <form id="deviceForm" method="POST" action="{{route('employeedashboard.repair.changeStatus', ['id' => $repair->id])}}">
                        @csrf
                        <select name="status" class="form-control">
                            <option value="w trakcie realizacji">W realizacji</option>
                            <option value="oczekiwanie na części">Oczekiwanie na częsci</option>
                            <hr>
                        </select>
                        <button type="submit" class="btn btn-primary">Zmień status</button>
                    </form>

                </div>
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
                <h2>Dodaj notatki do naprawy</h2>
                <form method="POST" action="{{ route('employeedashboard.repair.addRepairNote', ['id' => $repair->id]) }}">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="repair_id" value="{{ $repair->id }}">
                        <label for="message_content">Treść notatki:</label>
                        <textarea name="message_content" class="form-control" style="width: 550px" id="message_content"
                            rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Dodaj notatkę</button>
                </form>
            </div>
        </div>
        <div class="container d-flex flex-column align-items-center border border-radius p-3">
            <h2>Zakończenie naprawy oraz wystawienie rachunku / płatności</h2>

            <form id="invoiceForm"  method="POST" action="{{route('employeedashboard.repair.addNewPayment', ['id' => $repair->id])}}">
                @csrf
                <input type="hidden" name="repair_id" value="{{ $repair->id }}">
                <input type="hidden" name="device_id" value="{{ $device->id }}">
                <input type="hidden" name="user_id" value="{{ $repair->user_id }}">
                <div class="form-group">
                    <label for="basePrice">Podstawowa cena usługi:</label>
                    <input type="number" id="basePrice" class="form-control" min="0" step="0.01">
                </div>
                <div class="form-group">
                    <label for="basePrice">O ile lat ma zostać odnowiona gwarancja:</label>
                    <select name="warranty_renewal" class="form-control">
                            <option value="1">1 rok</option>
                            <option value="2">2 lata</option>
                            <option value="3">3 lata</option>
                            <option value="4">5 lata</option>
                            <option value="5">5 lat</option>
                            <option value="0">Nie podlega odnowieniu</option>
                            <hr>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deviceRegistered">Czy urządzenie jest zarejestrowane?</label>
                    <input type="text" id="deviceRegistered" class="form-control"
                        value="{{ $device->is_registered ? 'Tak' : 'Nie' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="warrantyStatus">Status gwarancji:</label>
                    <input type="text" id="warrantyStatus" class="form-control"
                        value="{{ $device->end_of_warranty > now() ? 'Aktywna' : 'Wygasła' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="finalPrice">Końcowa cena usługi:</label>
                    <input type="number" name="final_price" id="finalPrice" class="form-control" readonly>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">Ukończ naprawę i wystaw rachunek</button>
            </form>
            <hr>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        window.onload = function () {
            var basePriceInput = document.getElementById('basePrice');
            var isRegistered = "{{ $device->is_registered }}";
            var endOfWarranty = new Date("{{ $device->end_of_warranty }}");
            var now = new Date();

            basePriceInput.addEventListener('input', function () {
                var basePrice = parseFloat(basePriceInput.value);
                var monthsAfterWarranty = Math.floor((now - endOfWarranty) / (1000 * 60 * 60 * 24 * 30));
                var discount = 0;

                if (isRegistered === "1") {
                    if (monthsAfterWarranty <= 0) {
                        discount = 100;
                    } else if (monthsAfterWarranty <= 1) {
                        discount = 75;
                    } else if (monthsAfterWarranty <= 3) {
                        discount = 50;
                    } else if (monthsAfterWarranty <= 6) {
                        discount = 25;
                    } else if (monthsAfterWarranty <= 12) {
                        discount = 15;
                    } else {
                        discount = 10;
                    }
                }

                var finalPrice = basePrice * (1 - discount / 100);
                document.getElementById('finalPrice').value = finalPrice.toFixed(2);
            });
        }
    </script>

</body>
@include('shared.footer')
</html>