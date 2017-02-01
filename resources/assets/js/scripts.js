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


$(document).ready(function() {
    if (navigator.userAgent.indexOf("Chrome") != -1)
    {
      $("#sidebar").stick_in_parent()
        .on('sticky_kit:bottom', function(e) {
          $(this).parent().css('position', 'static');
        })
        .on('sticky_kit:unbottom', function(e) {
          $(this).parent().css('position', 'relative');
        })
    }
    if (navigator.userAgent.indexOf("Firefox") != -1)
    {

    }
});

$(document).ready(function() {
  $('.js-lazyYT').lazyYT();
});
