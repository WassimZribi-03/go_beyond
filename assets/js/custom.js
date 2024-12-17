(function ($) {
    "use strict";

    // Page loading animation
    $(window).on('load', function() {
        $('#js-preloader').addClass('loaded');
    });

    // Menu Dropdown Toggle
    if($('.menu-trigger').length){
        $(".menu-trigger").on('click', function() {	
            $(this).toggleClass('active');
            $('.header-area .nav').slideToggle(200);
        });
    }

    // Menu elevator animation
    $('.scroll-to-section a[href*=\\#]:not([href=\\#])').on('click', function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                var width = $(window).width();
                if(width < 991) {
                    $('.menu-trigger').removeClass('active');
                    $('.header-area .nav').slideUp(200);	
                }				
                $('html,body').animate({
                    scrollTop: (target.offset().top) - 80
                }, 700);
                return false;
            }
        }
    });

    // Page loading animation
    $(window).on('load', function() {
        if($('.cover').length){
            $('.cover').parallax({
                imageSrc: $('.cover').data('image'),
                zIndex: '1'
            });
        }

        $("#preloader").animate({
            'opacity': '0'
        }, 600, function(){
            setTimeout(function(){
                $("#preloader").css("visibility", "hidden").fadeOut();
            }, 300);
        });
    });

    // Header Scrolling Set White Background
    $(window).on('scroll', function() {
        var width = $(window).width();
        if(width > 991) {
            var scroll = $(window).scrollTop();
            if (scroll >= 30) {
                $(".header-area").addClass("header-sticky");
                $(".header-area .dark-logo").css('display', 'block');
                $(".header-area .light-logo").css('display', 'none');
            } else {
                $(".header-area").removeClass("header-sticky");
                $(".header-area .dark-logo").css('display', 'none');
                $(".header-area .light-logo").css('display', 'block');
            }
        }
    });

    // Scroll animation init
    window.sr = new scrollReveal();

})(window.jQuery); 