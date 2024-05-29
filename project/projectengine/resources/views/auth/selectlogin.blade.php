<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>M&D Tech Service - zaloguj się</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="{{ asset('mystyles.css') }}" rel="stylesheet">
</head>

<body class="body-grad">

    <div class="container text-center">
        <div id="start">
            <div id="carouselExampleCaptions" class="carousel slide d-flex pt-3">
                <div class="carousel-inner">
                    <div class="carousel-item d-flex justify-content-center align-items-center active">
                        <img src="/src/logowhite.png" class="d-block" alt="...">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <section class="vh-100">
                    <div class="container-fluid border-radius h-custom bg-white p-5 bg-opacity-50">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-md-9 col-lg-6 col-xl-5">
                                <img src="/src/name.png" class="img-fluid w-50" alt="Sample image">
                                <h2 class="text-white pt-3">Zaloguj się</h2>
                            </div>
                            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                                <form method="POST" action="{{ route('login.authenticate') }}">
                                    @csrf
                                    <input type="hidden" name="guard" value="employee">
                                    <!-- Email input -->
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input id="email" name="email" type="text" class="form-control form-control-lg bg-white bg-opacity-75 @if ($errors->first('email')) is-invalid @endif" value="{{ old('email') }}"
                                            placeholder="Podaj swój adres email" />
                                            <div class="invalid-feedback">Nieprawidłowy email!</div>
                                        <label class="form-label" for="email" :value="__('Email')">Adres email</label>
                                    </div>

                                    <!-- Password input -->
                                    <div data-mdb-input-init class="form-outline mb-3">
                                        <input id="password" name="password" type="password" class="bg-white bg-opacity-75 form-control @if ($errors->first('password')) is-invalid @endif"
                                            placeholder="Podaj hasło" />
                                            <div class="invalid-feedback">Nieprawidłowe hasło!</div>
                                        <label class="form-label" for="password" :value="__('Password')">Hasło</label>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-primary btn-lg"
                                            style="padding-left: 2.5rem; padding-right: 2.5rem;">{{ __('Zaloguj') }}</button>
                                            <div class="text-center justify-content-center">
                                                <p class="small fw-bold mt-2 pt-1 mb-0">Nie masz konta? <a href="{{ route('registerForm')   }}"
                                                class="link-danger">Zarejestruj się.</a></p>
                                            </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </section>

            </div>


        </div>
    </div>
</body>
@include('shared.footer')


</html>