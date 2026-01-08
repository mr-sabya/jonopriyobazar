/*===================================
Author       : Bestwebcreator.
Template Name: Shopwise - eCommerce Bootstrap 4 HTML Template
Version      : 1.0
===================================*/

document.addEventListener('livewire:navigated', (event) => {
	(function ($) {
		'use strict';

		/*===================================*
		01. LOADING JS
		/*===================================*/
		// On navigated, the window is already "loaded", so we run this immediately
		setTimeout(function () {
			$(".preloader").fadeOut(100).addClass('loaded');
		}, 100);

		/*===================================*
		02. BACKGROUND IMAGE JS
		*===================================*/
		$(".background_bg").each(function () {
			var attr = $(this).attr('data-img-src');
			if (typeof attr !== typeof undefined && attr !== false) {
				$(this).css('background-image', 'url(' + attr + ')');
			}
		});

		/*===================================*
		03. ANIMATION JS
		*===================================*/
		function ckScrollInit(items, trigger) {
			items.each(function () {
				var ckElement = $(this),
					AnimationClass = ckElement.attr('data-animation'),
					AnimationDelay = ckElement.attr('data-animation-delay');

				ckElement.css({
					'-webkit-animation-delay': AnimationDelay,
					'-moz-animation-delay': AnimationDelay,
					'animation-delay': AnimationDelay,
					opacity: 0
				});

				var ckTrigger = (trigger) ? trigger : ckElement;

				// Waypoints needs to be re-initialized on navigated
				if (typeof $.fn.waypoint !== 'undefined') {
					ckTrigger.waypoint(function () {
						ckElement.addClass("animated").css("opacity", "1");
						ckElement.addClass(AnimationClass);
					}, {
						triggerOnce: true,
						offset: '90%',
					});
				}
			});
		}

		ckScrollInit($('.animation'));
		ckScrollInit($('.staggered-animation'), $('.staggered-animation-wrap'));

		/*===================================*
		04. MENU JS
		*===================================*/
		$(window).off('scroll.menu').on('scroll.menu', function () {
			var scroll = $(window).scrollTop();
			if (scroll >= 150) {
				$('header.fixed-top').addClass('nav-fixed');
				$('.header_sticky_bar').removeClass('d-none');
			} else {
				$('header.fixed-top').removeClass('nav-fixed');
				$('.header_sticky_bar').addClass('d-none');
			}
		});

		$(document).off('click', '.dropdown-menu a.dropdown-toggler').on('click', '.dropdown-menu a.dropdown-toggler', function () {
			if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
			}
			var $subMenu = $(this).next(".dropdown-menu");
			$subMenu.toggleClass('show');
			$(this).parent("li").toggleClass('show');
			$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function () {
				$('.dropdown-menu .show').removeClass("show");
			});
			return false;
		});

		var navBar = $(".header_wrap");
		var navbarLinks = navBar.find(".navbar-collapse ul li a.page-scroll");
		$.each(navbarLinks, function () {
			var navbarLink = $(this);
			navbarLink.off('click').on('click', function () {
				navBar.find(".navbar-collapse").collapse('hide');
				$("header").removeClass("active");
			});
		});

		$('.navbar-toggler').off('click').on('click', function () {
			$("header").toggleClass("active");
			if ($('.search-overlay').hasClass('open')) {
				$(".search-overlay").removeClass('open');
				$(".search_trigger").removeClass('open');
			}
		});

		if ($('.header_wrap').hasClass("fixed-top") && !$('.header_wrap').hasClass("transparent_header") && !$('.header_wrap').hasClass("no-sticky")) {
			if ($(".header_sticky_bar").length === 0) {
				$(".header_wrap").before('<div class="header_sticky_bar d-none"></div>');
			}
		}

		var setHeight = function () {
			var height_header = $(".header_wrap").height();
			$('.header_sticky_bar').css({ 'height': height_header });
		};
		setHeight();
		$(window).on('resize', setHeight);

		$('.sidetoggle').off('click').on('click', function () {
			$(this).addClass('open');
			$('body').addClass('sidetoggle_active');
			$('.sidebar_menu').addClass('active');
			if ($("#header-overlay").length === 0) {
				$("body").append('<div id="header-overlay" class="header-overlay"></div>');
			}
		});

		$(document).off('click', '#header-overlay, .sidemenu_close').on('click', '#header-overlay, .sidemenu_close', function () {
			$('.sidetoggle').removeClass('open');
			$('body').removeClass('sidetoggle_active');
			$('.sidebar_menu').removeClass('active');
			$('#header-overlay').fadeOut('3000', function () {
				$('#header-overlay').remove();
			});
			return false;
		});

		// CATEGORY MENU PIECE (PRESERVED)
		$(".categories_btn").off('click.cat').on('click.cat', function () {
			$('.side_navbar_toggler').attr('aria-expanded', 'false');
			$('#navbarSidetoggle').removeClass('show');
		});

		$(".side_navbar_toggler").off('click.side').on('click.side', function () {
			$('.categories_btn').attr('aria-expanded', 'false');
			$('#navCatContent').removeClass('show');
		});

		$(".pr_search_trigger").off('click').on('click', function () {
			$(this).toggleClass('show');
			$('.product_search_form').toggleClass('show');
		});

		var rclass = true;
		$("html").off('click.outside').on('click.outside', function () {
			if (rclass) {
				$('.categories_btn').addClass('collapsed');
				$('.categories_btn,.side_navbar_toggler').attr('aria-expanded', 'false');
				$('#navCatContent,#navbarSidetoggle').removeClass('show');
			}
			rclass = true;
		});

		$(".categories_btn,#navCatContent,#navbarSidetoggle .navbar-nav,.side_navbar_toggler").off('click.inside').on('click.inside', function () {
			rclass = false;
		});

		/*===================================*
		05. SMOOTH SCROLLING JS
		*===================================*/
		var topheaderHeight = $(".top-header").innerHeight();
		var mainheaderHeight = $(".header_wrap").innerHeight();
		var headerHeight = mainheaderHeight - topheaderHeight - 20;

		$('a.page-scroll[href*="#"]:not([href="#"])').off('click').on('click', function (event) {
			$('a.page-scroll.active').removeClass('active');
			$(this).closest('.page-scroll').addClass('active');
			if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
				var target = $(this.hash),
					speed = $(this).data("speed") || 800;
				target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
				if (target.length) {
					event.preventDefault();
					$('html, body').animate({
						scrollTop: target.offset().top - headerHeight
					}, speed);
				}
			}
		});

		$('.more_slide_open').slideUp();
		$('.more_categories').off('click').on('click', function () {
			$(this).toggleClass('show');
			$('.more_slide_open').slideToggle();
		});

		/*===================================*
		06. SEARCH JS
		*===================================*/
		$(".close-search").off('click').on("click", function () {
			$(".search_wrap,.search_overlay").removeClass('open');
			$("body").removeClass('search_open');
		});

		var removeClass = true;
		if ($(".search_overlay").length === 0) {
			$(".search_wrap").after('<div class="search_overlay"></div>');
		}

		$(".search_trigger").off('click').on('click', function () {
			$(".search_wrap,.search_overlay").toggleClass('open');
			$("body").toggleClass('search_open');
			removeClass = false;
			if ($('.navbar-collapse').hasClass('show')) {
				$(".navbar-collapse").removeClass('show');
				$(".navbar-toggler").addClass('collapsed');
				$(".navbar-toggler").attr("aria-expanded", false);
			}
		});

		/*===================================*
		07. SCROLLUP JS
		*===================================*/
		$(window).off('scroll.up').on('scroll.up', function () {
			if ($(this).scrollTop() > 150) {
				$('.scrollup').fadeIn();
			} else {
				$('.scrollup').fadeOut();
			}
		});

		$(".scrollup").off('click').on('click', function (e) {
			e.preventDefault();
			$('html, body').animate({ scrollTop: 0 }, 600);
			return false;
		});

		/*===================================*
		08. PARALLAX JS
		*===================================*/
		if (typeof $.fn.parallaxBackground !== 'undefined') {
			$('.parallax_bg').parallaxBackground();
		}

		/*===================================*
		09. MASONRY JS
		*===================================*/
		var $grid_selectors = $(".grid_container");
		if ($grid_selectors.length > 0 && typeof $.fn.isotope !== 'undefined') {
			$grid_selectors.imagesLoaded(function () {
				if ($grid_selectors.hasClass("masonry")) {
					$grid_selectors.isotope({
						itemSelector: '.grid_item',
						layoutMode: "masonry",
					});
				} else {
					$grid_selectors.isotope({
						itemSelector: '.grid_item',
						layoutMode: "fitRows",
					});
				}
			});
		}

		/*===================================*
		10. SLIDER JS
		*===================================*/
		function carousel_slider() {
			$('.carousel_slider').each(function () {
				var $carousel = $(this);
				$carousel.owlCarousel({
					dots: $carousel.data("dots"),
					loop: $carousel.data("loop"),
					items: $carousel.data("items"),
					margin: $carousel.data("margin"),
					mouseDrag: $carousel.data("mouse-drag"),
					touchDrag: $carousel.data("touch-drag"),
					autoHeight: $carousel.data("autoheight"),
					center: $carousel.data("center"),
					nav: $carousel.data("nav"),
					rewind: $carousel.data("rewind"),
					navText: ['<i class="ion-ios-arrow-back"></i>', '<i class="ion-ios-arrow-forward"></i>'],
					autoplay: $carousel.data("autoplay"),
					animateIn: $carousel.data("animate-in"),
					animateOut: $carousel.data("animate-out"),
					autoplayTimeout: $carousel.data("autoplay-timeout"),
					smartSpeed: $carousel.data("smart-speed"),
					responsive: $carousel.data("responsive")
				});
			});
		}

		function slick_slider() {
			$('.slick_slider').each(function () {
				var $slick_carousel = $(this);
				$slick_carousel.slick({
					arrows: $slick_carousel.data("arrows"),
					dots: $slick_carousel.data("dots"),
					infinite: $slick_carousel.data("infinite"),
					centerMode: $slick_carousel.data("center-mode"),
					vertical: $slick_carousel.data("vertical"),
					fade: $slick_carousel.data("fade"),
					cssEase: $slick_carousel.data("css-ease"),
					autoplay: $slick_carousel.data("autoplay"),
					verticalSwiping: $slick_carousel.data("vertical-swiping"),
					autoplaySpeed: $slick_carousel.data("autoplay-speed"),
					speed: $slick_carousel.data("speed"),
					pauseOnHover: $slick_carousel.data("pause-on-hover"),
					draggable: $slick_carousel.data("draggable"),
					slidesToShow: $slick_carousel.data("slides-to-show"),
					slidesToScroll: $slick_carousel.data("slides-to-scroll"),
					asNavFor: $slick_carousel.data("as-nav-for"),
					focusOnSelect: $slick_carousel.data("focus-on-select"),
					responsive: $slick_carousel.data("responsive")
				});
			});
		}

		carousel_slider();
		slick_slider();

		/*===================================*
		11. CONTACT FORM JS
		*===================================*/
		$("#submitButton").off('click').on("click", function (event) {
			event.preventDefault();
			var mydata = $("form").serialize();
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "contact.php",
				data: mydata,
				success: function (data) {
					if (data.type === "error") {
						$("#alert-msg").removeClass("alert, alert-success").addClass("alert, alert-danger");
					} else {
						$("#alert-msg").addClass("alert, alert-success").removeClass("alert, alert-danger");
						$("#first-name, #email, #phone, #subject, #description").val("");
					}
					$("#alert-msg").html(data.msg).show();
				}
			});
		});

		/*===================================*
		12. POPUP JS
		*===================================*/
		if (typeof $.fn.magnificPopup !== 'undefined') {
			$('.image_gallery').each(function () {
				$(this).magnificPopup({ delegate: 'a', type: 'image', gallery: { enabled: true } });
			});
			$('.video_popup, .iframe_popup').magnificPopup({ type: 'iframe' });
		}

		/*===================================*
		13. Select dropdowns
		*===================================*/
		$.each($('select'), function (i, val) {
			var $el = $(val);
			if (!$el.val()) $el.addClass('not_chosen');
			$el.off('change.select').on('change.select', function () {
				(!$el.val()) ? $el.addClass('not_chosen') : $el.removeClass('not_chosen');
			});
		});

		/*===================================*
		17. COUNTDOWN JS
		*===================================*/
		if (typeof $.fn.countdown !== 'undefined') {
			$('.countdown_time').each(function () {
				var endTime = $(this).data('time');
				$(this).countdown(endTime, function (tm) {
					$(this).html(tm.strftime('<div class="countdown_box"><div class="countdown-wrap"><span class="countdown days">%D </span><span class="cd_text">Days</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown hours">%H</span><span class="cd_text">Hours</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown minutes">%M</span><span class="cd_text">Minutes</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown seconds">%S</span><span class="cd_text">Seconds</span></div></div>'));
				});
			});
		}

		/*===================================*
		18. List Grid JS
		*===================================*/
		$('.shorting_icon').off('click').on('click', function () {
			if ($(this).hasClass('grid')) {
				$('.shop_container').removeClass('list').addClass('grid');
			} else if ($(this).hasClass('list')) {
				$('.shop_container').removeClass('grid').addClass('list');
			}
			$(this).addClass('active').siblings().removeClass('active');
		});

		/*===================================*
		20. PRODUCT COLOR JS
		*===================================*/
		$('.product_color_switch span').each(function () {
			$(this).css("background-color", $(this).attr('data-color'));
		});
		$('.product_color_switch span,.product_size_switch span').off('click').on("click", function () {
			$(this).siblings().removeClass('active').end().addClass('active');
		});

		/*===================================*
		21. QUANTITY JS
		*===================================*/
		$(document).off('click', '.plus').on('click', '.plus', function () {
			var val = $(this).prev().val();
			$(this).prev().val(+val + 1);
		});
		$(document).off('click', '.minus').on('click', '.minus', function () {
			var val = $(this).next().val();
			if (val > 1) $(this).next().val(+val - 1);
		});

		/*===================================*
		22. PRICE FILTER JS
		*===================================*/
		if (typeof $.fn.slider !== 'undefined') {
			$('#price_filter').each(function () {
				var $fs = $(this);
				$fs.slider({
					range: true,
					min: $fs.data("min"),
					max: $fs.data("max"),
					values: [$fs.data("min-value"), $fs.data("max-value")],
					slide: function (event, ui) {
						$("#flt_price").html($fs.data("price-sign") + ui.values[0] + " - " + $fs.data("price-sign") + ui.values[1]);
						$("#price_first").val(ui.values[0]);
						$("#price_second").val(ui.values[1]);
					}
				});
			});
		}

		/*===================================*
		23. RATING STAR JS
		*===================================*/
		$('.star_rating span').off('click').on('click', function () {
			var onStar = parseFloat($(this).data('value'), 10);
			var stars = $(this).parent().children('.star_rating span');
			stars.removeClass('selected');
			for (var i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}
		});

		/*===================================*
		24. CHECKBOX CHECK
		*===================================*/
		$('#createaccount:checkbox').off('change').on('change', function () {
			$(this).is(":checked") ? $('.create-account').slideDown() : $('.create-account').slideUp();
		});
		$('#differentaddress:checkbox').off('change').on('change', function () {
			$(this).is(":checked") ? $('.different_address').slideDown() : $('.different_address').slideUp();
		});

	})(jQuery);
});