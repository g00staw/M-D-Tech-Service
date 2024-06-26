<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>M&D Tech Service - Choose login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="{{ asset('mystyles.css') }}" rel="stylesheet">
</head>

<body class="body-grad">

    <div class="container text-center">
        <section class="vh-100">
            <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                            <div class="card" style="border-radius: 15px;">
                                <div class="card-body p-5">

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

                                    <h2 class="text-uppercase text-center mb-5">Stwórz konto</h2>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" name="name" id="form3Example1cg" minlength="4"
                                                class="form-control form-control-lg" placeholder="np. Jan Kowalski" />
                                            <label class="form-label" for="form3Example1cg">Twoje imię i
                                                nazwisko</label>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="email" name="email" id="form3Example3cg"
                                                class="form-control form-control-lg" placeholder="twoj@email.com" />
                                            <label class="form-label" for="form3Example3cg">Twój Email</label>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="password" name="password" minlength="8" id="form3Example4cg"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="form3Example4cg">Hasło</label>
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="password" name="password_confirmation" minlength="8" id="form3Example4cdg"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="form3Example4cdg">Powtórz hasło</label>
                                            @error('password_confirmation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Zarejestruj</button>
                                        </div>

                                        <p class="text-center text-muted mt-5 mb-0">Masz konto? <a
                                                href="{{ route('login') }}" class="fw-bold text-body"><u>Zaloguj
                                                    się</u></a></p>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <div class="footer">
            <div class="row">
                <ul>
                    <li>
                        <a>Autor: </a>
                        <a>Konrad Pluta</a>
                    </li>
                    <li>
                        <a>E-mail:</a>
                        <a>adres@email.com</a>
                    </li>
                    <li>
                        <a>Numer telefonu:</a>
                        <a>+48 123 456 789</a>
                    </li>
                    <li>
                        <a>Zgłoś:</a>
                        <a href="">Formularz zgłoszeniowy</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                Strona stworzona na potrzeby projektu z przedmiotu: Aplikacje Internetowe.
            </div>
        </div>
    </footer>

</body>


</html>
