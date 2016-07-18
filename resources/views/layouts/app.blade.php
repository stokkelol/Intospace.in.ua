<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('frontend.partials.meta')
    <meta name="keywords" content="music, deathmetal, blackmetal, sludge, doom, thrash metal, avantgarde, psychedelic, neformat">
    <meta name="robots" content="">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir('css/libs.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/styles.css') }}">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    @include('frontend.partials.navbar')
    @yield('tagline')
    @yield('random')
    @yield('toppost')
    @yield('content')
    @include('frontend.partials.footer')
    <!-- JavaScripts -->
    <script src="{{ elixir('js/all.js') }}"></script>
    @include('frontend.partials.analytics')
    <script>
    var popupSize = {
        width: 780,
        height: 550
    };

    $(document).on('click', '.social-buttons > a', function(e){

        var
            verticalPos = Math.floor(($(window).width() - popupSize.width) / 2),
            horisontalPos = Math.floor(($(window).height() - popupSize.height) / 2);

        var popup = window.open($(this).prop('href'), 'social',
            'width='+popupSize.width+',height='+popupSize.height+
            ',left='+verticalPos+',top='+horisontalPos+
            ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1');

        if (popup) {
            popup.focus();
            e.preventDefault();
        }

    });
    </script>
</body>
</html>
