@extends('layouts.layouts')

@section('title')
    Mamateam/Celeste - Sito ufficiale
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('comingsoon/animate.css')}}">
    <link rel="stylesheet" href="{{asset('comingsoon/icomoon.css')}}">
    <link rel="stylesheet" href="{{asset('comingsoon/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('comingsoon/style.css')}}">
    <link rel="stylesheet" href="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.css"/>

    <!-- Scripts-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
            integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.js" defer></script>
    <script src="{{asset('comingsoon/modernizr-2.6.2.min.js')}}"></script>
@endsection

@section('content')
    <body>
    <div class="fh5co-loader"></div>
    <div id="page">
        <div id="fh5co-container" class="js-fullheight">
            <div class="countdown-wrap js-fullheight">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="display-t js-fullheight">
                            <div class="display-tc animate-box">
                                <nav class="fh5co-nav" role="navigation">
                                    <div class="loading-dots">
                                        <h1 id="fh5co-logo">Loading</h1>
                                        <h1 id="fh5co-logo">Loading</h1>
                                    </div>
                                </nav>
                                <h1>Stiamo tornando!</h1>
                                <!-- <div class="simply-countdown simply-countdown-one"></div> -->
                                <div class="row">
                                    <div class="col-md-12 desc">
                                        <h2>Il sito è in manutenzione. <br></h2>
                                        <ul class="fh5co-social-icons">
                                            <li><a href="https://www.facebook.com/MamaTeamCeleste"><i
                                                        class="icon-facebook"></i></a></li>
                                            <li><a href="https://www.instagram.com/mamateamceleste/"><i
                                                        class="icon-instagram"></i></a></li>
                                            <li>
                                                <a href="javascript:window.open('mailto:info@mamateamceleste.it', 'mail');event.preventDefault()"><i
                                                        class="icon-email"></i></a></li>
                                            <li><a href="tel:+39 348 247 7105"><i class="icon-phone"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-cover js-fullheight"
                 style="background-image:url({{asset('comingsoon/img_bg_1.jpg')}}"></div>
        </div>
    </div>

    <!-- jQuery Easing -->
    <script src="{{asset('comingsoon/jquery.easing.1.3.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('comingsoon/bootstrap.min.js')}}"></script>
    <!-- Waypoints -->
    <script src="{{asset('comingsoon/jquery.waypoints.min.js')}}"></script>
    <!-- Main -->
    <script src="{{asset('comingsoon/main.js')}}"></script>
    </body>
@endsection
