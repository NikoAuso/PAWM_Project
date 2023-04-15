@extends('layouts.layouts')

@section('title')
    Mamateam/Celeste - Accedi
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/sb-admin-pro.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"
            crossorigin="anonymous"></script>

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
@endsection

@section('content')
    <body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header justify-content-center"><h3 class="fw-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Login form-->
                                    <form class="form" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmail"><i
                                                    class="fas fa-user"></i> {{ __('Username') }}
                                            </label>
                                            <input name="email" id="inputEmail" class="form-control" placeholder=" "
                                                   type="text" value="{{ old('email') }}" autofocus required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputPassword"><i
                                                    class="fas fa-lock"></i> {{ __('Password') }}
                                            </label>
                                            <input type="password" name="password" id="inputPassword"
                                                   class="form-control"
                                                   placeholder=" " required autocomplete="current-password">
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" id="rememberPasswordCheck"
                                                       type="checkbox"
                                                       name="remember">
                                                <label class="form-check-label"
                                                       for="rememberPasswordCheck">{{ __('Ricordati di me') }}</label>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2"
                                            type="submit" name="login_btn">Entra
                                        </button>
                                    </form>
                                    @if (session('status'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('status') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{$errors->first()}}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small mb-2">
                                        <a class="mb-2" href="{{route('password.request')}}">Password dimenticata?</a>
                                    </div>
                                    <div class="small ">
                                        <a class="mb-2" href="{{route('home')}}"><i class="fa-solid fa-arrow-left"></i> Ritorna alla home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    </body>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
            integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('assets/bootstrap/js/sb-admin-pro.js')}}"></script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
@endsection
