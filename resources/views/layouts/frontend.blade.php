<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>শহীদ সাধন সঙ্গীত মহাবিদ্যালয়, পাবনা</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/image/logo.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/navbar-footer.css') }}" />
</head>
<body>
    <div class="container">
        
        @include('frontend.partials.hero') 

        @include('frontend.partials.header') 

        @yield('content') 

        @include('frontend.partials.footer') 

        <div id="popup-overlay"></div>
        <div id="popup-message">
            <div class="popup_img">
                <img src="{{ asset('assets/image/pop-up-poster.webp') }}" alt="Popup Image" />
            </div>
            <button id="popup-close">×</button>
        </div>

        <a class="gobtn" id="bt-top" href="#"><i class="fa-solid fa-arrow-up" style="color: #0e2d62"></i></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/css/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/navbar.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>