<!doctype html>
<!--[if IE 7 ]> <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]> <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]> <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Cookie Consent by https://www.CookieConsent.com -->
    <script type="text/javascript" src="//www.cookieconsent.com/releases/4.0.0/cookie-consent.js"
            charset="UTF-8"></script>
    <script type="text/javascript" charset="UTF-8">
        document.addEventListener('DOMContentLoaded', function () {
            cookieconsent.run({
                "notice_banner_type": "standalone",
                "consent_type": "express",
                "palette": "dark",
                "language": "it",
                "page_load_consent_levels": ["strictly-necessary"],
                "notice_banner_reject_button_hide": false,
                "preferences_center_close_button_hide": false,
                "website_name": "Mamateam/Celeste"
            });
        });
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script type="text/plain" cookie-consent="tracking" async
            src="https://www.googletagmanager.com/gtag/js?id=G-JJ6B3FWZQE"></script>
    <script type="text/plain" cookie-consent="tracking">
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-JJ6B3FWZQE');


    </script>
    <!-- end of Google Analytics-->

    <noscript>ePrivacy and GPDR Cookie Consent by <a href="https://www.CookieConsent.com/" rel="nofollow noopener">Cookie
            Consent</a></noscript>
    <!-- End Cookie Consent by https://www.CookieConsent.com -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Nicolo' Ausili">
    <meta name="keywords" content="mamateam, mmamia, miami, noir, celeste, dopestaff, discoteca, eventi">
    <meta name="description"
          content="Tutte le informazione degli eventi in programma al Mamamia, Miami e Noir le trovi qui. Che cosa aspetti? Entra!"/>
    <!--[if lt IE 9]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <![endif]-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{'/favicon.ico'}}" type="image/x-icon">

    <!-- Styles -->
    <link href="{{asset('assets/bootstrap/css/sb-admin-pro.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"
            crossorigin="anonymous"></script>
</head>
<body class="bg-white">
<div id="layoutError">
    <div id="layoutError_content">
        <main>
            <div class="container px-4">
                <div class="row align-items-center" style="top: 50%; transform: translateY(30%)">
                    <div class="col-xl-6 offset-xl-3">
                        <div class="text-center mt-4">
                            <img class="img-fluid p-4" src="{{asset('assets/img/error/')}}/@yield('image')"
                                 alt="@yield('title')"/>
                            <p class="lead">@yield('message')</p>
                            <a class="text-arrow-icon" href="{{url()->previous()}}">
                                <i class="ms-0 me-1" data-feather="arrow-left"></i>
                                Torna indietro
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="layoutError_footer">
        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 small text-center">Copyright &#169; {{date("Y")}}</div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Scripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('assets/bootstrap/js/sb-admin-pro.js')}}"></script>
<script type="text/javascript" src="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.js" defer></script>
</body>
</html>
