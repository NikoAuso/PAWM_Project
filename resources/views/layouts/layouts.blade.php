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
    <meta name="keywords" content="mamateam, mamamia, miami, noir, celeste, discoteca, eventi">
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
    @yield('styles')
</head>
@yield('content')

<!-- Scripts-->
@yield('scripts')
</html>
