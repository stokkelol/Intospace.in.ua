<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('frontend.partials.meta')
    <meta name="keywords" content="music, deathmetal, blackmetal, sludge, doom, thrash metal, avantgarde, psychedelic, neformat">
    <meta name="robots" content="">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <!-- Styles -->

    <link href="{{ elixir('css/libs.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    @include('frontend.partials.navbar')
    @yield('random')
    @yield('toppost')
    @yield('content')
    @include('frontend.partials.footer')
    <!-- JavaScripts -->
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
<script>
jQuery(document).ready(function($) {
var MQL = 1170;

//primary navigation slide-in effect
if ($(window).width() > MQL) {
    var headerHeight = $('.navbar-custom').height();
    $(window).on('scroll', {
            previousTop: 0
        },
        function() {
            var currentTop = $(window).scrollTop();
            //check if user is scrolling up
            if (currentTop < this.previousTop) {
                //if scrolling up...
                if (currentTop > 0 && $('.navbar-custom').hasClass('is-fixed')) {
                    $('.navbar-custom').addClass('is-visible');
                } else {
                    $('.navbar-custom').removeClass('is-visible is-fixed');
                }
            } else {
                //if scrolling down...
                $('.navbar-custom').removeClass('is-visible');
                if (currentTop > headerHeight && !$('.navbar-custom').hasClass('is-fixed')) $('.navbar-custom').addClass('is-fixed');
            }
            this.previousTop = currentTop;
        });
}

// Initialize tooltips
$('[data-toggle="tooltip"]').tooltip();
});
</script>
<script src="{{ elixir('js/all.js') }}"></script>
</body>
</html>
