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
            <section style="background-color: #eee;">
                <div class="container py-5">
                    <div class="row">
                        <div class="col">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                <img src="{{ Auth::guard('employee')->user()->profile_photo ? asset('storage/' .  Auth::guard('employee')->user()->profile_photo) : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp' }}" alt="Zdjęcie profilowe" class="rounded-circle img-fluid" style="width: 150px;">
                                    <h3>Twój awatar</h3>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Imię, Nazwisko:</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ Auth::guard('employee')->user()->name }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <p class="mb-0">Email</p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p class="text-muted mb-0">{{ Auth::guard('employee')->user()->email }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3>Zmień hasło</h3>
                            <form method="POST" action="{{ route('employeedashboard.profile.psschange') }}" class="p-5">
                                @csrf

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Obecne hasło</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Nowe hasło</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Potwierdź nowe hasło</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Zmień hasło</button>
                            </form>
                        </div>
                        <div>
                            <h3>Zmień email</h3>
                            <form method="POST" action="{{ route('employeedashboard.profile.emchange') }}" class="p-5">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Nowy e-mail</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Zmień e-mail</button>
                            </form>
                        </div>
                        <div>
                            <h3>Zmień zdjęcie profilowe</h3>
                            <form method="POST" action="{{ route('employeedashboard.profile.phchange') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="profile_photo" class="form-label">Zdjęcie profilowe</label>
                                    <input type="file" name="profile_photo" id="profile_photo" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Zaktualizuj profil</button>
                            </form>

                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                        crossorigin="anonymous"></script>
                    <script src="{{ asset('js/app.js') }}"></script>
                    <script>
                        $('.dropdown-toggle').dropdown()
                    </script>
</body>
@include('shared.footer')
</html>