(function ($) {
	
	"use strict";

	// Page loading animation
	$(window).on('load', function() {
        $('#js-preloader').addClass('loaded');
    });

	// Header Scrolling Set White Background
	$(window).scroll(function() {
		var width = $(window).width();
		if(width > 991) {
			var scroll = $(window).scrollTop();
			if (scroll >= 30) {
				$(".header-area").addClass("header-sticky");
				$(".header-area .dark-logo").css('display', 'block');
				$(".header-area .light-logo").css('display', 'none');
			}else{
				$(".header-area").removeClass("header-sticky");
				$(".header-area .dark-logo").css('display', 'none');
				$(".header-area .light-logo").css('display', 'block');
			}
		}
	});

	// Menu Dropdown Toggle
	if($('.menu-trigger').length){
		$(".menu-trigger").on('click', function() {	
			$(this).toggleClass('active');
			$('.header-area .nav').slideToggle(200);
		});
	}

	// Event Countdown Timer
	function makeTimer() {
        var endTime = new Date(nextEventDate || "2024-12-31");			
        var endTime = (Date.parse(endTime)) / 1000;
        var now = new Date();
        var now = (Date.parse(now) / 1000);
        var timeLeft = endTime - now;
        
        if (timeLeft < 0) {
            $("#days").html("00");
            $("#hours").html("00");
            $("#minutes").html("00");
            $("#seconds").html("00");
            return;
        }
        
        var days = Math.floor(timeLeft / 86400); 
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

        if (hours < "10") { hours = "0" + hours; }
        if (minutes < "10") { minutes = "0" + minutes; }
        if (seconds < "10") { seconds = "0" + seconds; }
        if (days < "10") { days = "0" + days; }

        $("#days").html(days);
        $("#hours").html(hours);
        $("#minutes").html(minutes);
        $("#seconds").html(seconds);
    }
    
    // Initialize timer immediately and update every second
    if ($("#days").length) {
        makeTimer();
        setInterval(function() { makeTimer(); }, 1000);
    }

	// Initialize Owl Carousel
	$(document).ready(function() {
		if($('.owl-show-events').length){
			$('.owl-show-events').owlCarousel({
				loop:true,
				nav:true,
				dots: true,
				items:4,
				margin:30,
				autoplay:true,
				autoplayTimeout:5000,
				autoplayHoverPause:true,
				navText: [
					"<i class='fa fa-angle-left'></i>",
					"<i class='fa fa-angle-right'></i>"
				],
				responsive:{
					0:{
						items:1
					},
					600:{
						items:2
					},
					1000:{
						items:4
					}
				}
			});
		}
	});

	// Initialize ScrollReveal
	window.sr = ScrollReveal({
		origin: 'top',
		distance: '60px',
		duration: 2500,
		delay: 400,
		mobile: true,
		reset: false
	});

	sr.reveal('.main-banner', {});
	sr.reveal('.main-content', {delay: 500});
	sr.reveal('.show-events-carousel', {delay: 600});
	sr.reveal('.amazing-venues', {delay: 700});
	sr.reveal('.venue-tickets', {delay: 800});

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

	// Counter init
	$('.count-digit').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 4000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});

})(window.jQuery); 