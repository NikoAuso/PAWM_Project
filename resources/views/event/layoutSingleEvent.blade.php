@php use Carbon\Carbon; @endphp
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
            src="https://www.googletagmanager.com/gtag/js?id=UA-159245877-2"></script>
    <script type="text/plain" cookie-consent="tracking">
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-159245877-2');





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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/css/eventsLayout_v2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/flipTimer.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.wpcc.io/lib/1.0.2/cookieconsent.min.css"/>

    <style>
        .back-image {
            background-color: #65a3ff;
            z-index: 0;

            /* Set rules to fill background */
            min-height: 100%;
            min-width: 1024px;

            /* Set up proportionate scaling */
            width: 100%;
            height: auto;

            /* Set up positioning */
            position: fixed;

            /* Add the blur effect */
            filter: blur(6px);
            -webkit-filter: blur(6px);
        }
    </style>
</head>

<body>
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
@include('event.navbarSingleEvent')
@yield('content')

<!-- JQuery core JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>
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

        // Set the date we're counting down to
        let countDownDate = new Date("{{Carbon::parse($event->date)->format('F d, Y H:i:s')}}").getTime();

        // Update the count-down every 1 second
        let x = setInterval(function () {

            // Get today's date and time
            let now = new Date().getTime();

            // Find the distance between now and the count-down date
            let distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("countdown").innerHTML =
                "<div>" +
                "<span>days</span>" + days +
                "</div>" +
                "<div>" +
                "<span>hours</span>" + hours +
                "</div>" +
                "<div>" +
                "<span>min</span>" + minutes +
                "</div>" +
                "<div>" +
                "<span>sec</span>" + seconds +
                "</div>";
            // If the count-down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "<div class='countdown-expired'>EVENTO PASSATO</div>";
            }
        }, 1000);
    });
</script>
</body>
</html>
