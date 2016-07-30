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
    @yield('review')
    @yield('toppost')
    @yield('content')
    @include('frontend.partials.footer')
    <!-- JavaScripts -->
    <script src="{{ elixir('js/all.js') }}"></script>

    <script>
    $(document).ready(function() {
$('#lightSlider').lightSlider({
    item:6,
    auto:true,
    loop:true,
    slideMove:2,
    easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
    speed:600,
    onSliderLoad: function() {
            $('#lightSlider').removeClass('cS-hidden');
        },
    responsive : [
        {
            breakpoint:800,
            settings: {
                item:3,
                slideMove:1,
                slideMargin:6,
              }
        },
        {
            breakpoint:480,
            settings: {
                item:2,
                slideMove:1
              }
        }
    ]
});
});
    </script>
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
    <script type="text/javascript">
	$(document).ready(function() {
        $(".fancybox").fancybox({
            openEffect	: 'elastic',
            closeEffect	: 'elastic',
            padding: 0,
            helpers : {
                overlay : {
                    css : {
                        'background' : 'rgba(73, 69, 69, 0.95)'
                    }
                }
            }
        });
	});
</script>

</body>
</html>
