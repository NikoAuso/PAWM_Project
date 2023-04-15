@extends('layouts.layouts')

@section('title')
    Mamateam/Celeste - Sito ufficiale
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/css/styles_v2.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.css"/>
@endsection

@section('content')
    <body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="0" class="scrollspy-example" tabindex="0">
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    @include('layouts.navbar')

    <!-- Video Background -->
    <div class="container-fluid d-flex justify-content-center align-items-center align-content-center"
         id="home" style="height: 100vh;overflow: hidden;">
        <div class="row">
            <div class="col-12">
                <img id="logoImg" class="img-fluid" src="{{asset('assets/img/logo.png')}}"
                     alt="logo"
                     data-aos="fade-down" data-aos-duration="1000" data-aos-delay="1000">
            </div>
        </div>
    </div>

    <!--Main-->
    <div id="wrapper">
        @include('layouts.home.event_display')

        @include('layouts.home.history')

        @include('layouts.home.team')

        @include('layouts.home.footer')
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
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script type="text/javascript" src="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.js" defer></script>
    <!-- Other -->
    <script type="text/javascript">
        AOS.init();
        $(document).ready(function () {
            $('body').addClass('loaded');
            setTimeout(function () {
                $('#navbar').css('display', 'block');
            }, 800);
        });
        // Scrolling Effect
        $(window).scroll(function () {
            $('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
        });
    </script>
@endsection
