/* Index of this file

	(1) Hover Social Media Icons	
	(2) Mobile menu
	(3) Flickr Widget
	(4) Self Hosted Video, Audio
	(5) Ordered List
	(6) Tabs and Toggles Script
	(7) Simple and Accordation Toggles
	(8) Hide Info Boxes
	(9) Flex slider - Post Format Gallery, Logo, Recent Projects etc.
	(10) Rotate Testimonials
	(11) Portfolio	
	(12) Image Hover fade effect
	(13) Resize Media
	(14) Contact Form

*/

(function ($) {	$(document).ready(function(){
// Do not delete above line
/****************************************************************/
/****************************************************************/

$("a[data-rel^='prettyPhoto']").prettyPhoto();
$('.fitVids').fitVids();

/***************************************************************
* (1) Hover Social Media Icons *
****************************************************************/

$("ul.social_media_icons li,.social-icons ul li").fadeTo("normal", 0.4);
	$("ul.social_media_icons li,.social-icons ul li").hover(function(){
		$(this).stop().fadeTo("normal", 1);
	},function(){
		$(this).stop().fadeTo("normal", 0.4);
	});

/***************************************************************
* (2) Mobile menu *
****************************************************************/

 $('.sf-menu').tinyNav({
    active: 'active',  // class name of active link
    header: 'Navigation'  // default display text for dropdown
});

/***************************************************************
* (3) Flickr Widget *
****************************************************************/

$(".flickr_photos").append('<ul id="cbox" class="thumbs ">');
$(".flickr_photos2").append('<ul id="cbox2" class="thumbs ">');

$('#cbox,#cbox2').jflickrfeed({
	limit	: 8,
	qstrings: {
		id: '90291761@N02'  // replace example flickr id with your flickr id
	},
	itemTemplate: '<li>'+'<a class="fade-img3" href="{{image}}" title="{{title}}" data-rel="prettyPhoto[flickrGallery123]">' + '<img src="{{image_s}}" alt="{{title}}" />' + '</a>' + '</li>'
}, function(data) {
	$('#cbox a,#cbox2 a').prettyPhoto();
});


/***************************************************************
* (4) Self Hosted Video, Audio *
****************************************************************/

$('.jp-interface').append("<ul class='jp-controls'><li><a href='#' class='jp-play' tabindex='1'>play</i> </a></li><li><a href='#' class='jp-pause' tabindex='1'>Pause</a></li><li><a href='#' class='jp-mute' tabindex='1'>Mute</a></li><li><a href='#' class='jp-unmute' tabindex='1'>Unmute</a></li><li><a href='javascript:;' class='jp-full-screen pictos' tabindex='1' title='full screen'>`</a></li><li><a href='javascript:;' class='jp-restore-screen pictos' tabindex='1' title='restore screen'>*</a></li></ul><div class='jp-progress'><div class='jp-seek-bar'><div class='jp-play-bar'></div></div></div><div class='jp-volume-bar'><div class='jp-volume-bar-value'></div></div>");

$('.jp-interface2').append("<ul class='jp-controls'><li><a href='#' class='jp-play' tabindex='1' title='play'>play</a></li><li><a href='#' class='jp-pause' tabindex='1' title='pause'>pause</a></li><li><a href='#' class='jp-mute' tabindex='1' title='mute'>mute</a></li><li><a href='#' class='jp-unmute' tabindex='1' title='unmute'>unmute</a></li></ul><div class='jp-progress'><div class='jp-seek-bar'><div class='jp-play-bar'></div></div></div><div class='jp-volume-bar'><div class='jp-volume-bar-value'></div></div>");

/***************************************************************
* (5) Ordered List *
****************************************************************/

$("ul.ordered_list").each (function () {
    $("li", this).each (function (i) {
        $(this).prepend("<span>" + (i+1) + "</span>" );
    });
});

/***************************************************************
* (6) Tabs and Toggles Script *
****************************************************************/
$(".my_toggle").each( function () {
	if($(this).attr('data-id') == 'closed') {
		$(this).accordion({ header: '.my_toggle_title', collapsible: true, active: false  });
	} else {
		$(this).accordion({ header: '.my_toggle_title', collapsible: true});
	}
});

$(".my_toggle2").each( function () {
	if($(this).attr('data-id') == 'closed') {
		$(this).accordion({ header: '.my_toggle2_title', collapsible: true, active: false  });
	} else {
		$(this).accordion({ header: '.my_toggle2_title', collapsible: true});
	}
});

$(document).ready(function(){

$(".my_tab_style1").tabs({ fx: { opacity: 'show' } });
$(".my_tab_style2").tabs({ event: "mouseover" });

});

/***************************************************************
* (7) Pagination *
****************************************************************/
$(function() {

	/* initiate plugin assigning the desired button labels  */
    var itemsPerPage = parseInt($("div.holder").attr("data-itemsPerPage") || 9),
		pageNext = $("div.holder").attr("data-pageNext") || 'Next',
		pagePrev = $("div.holder").attr("data-pagePrev") || 'Prev';

	$('.portfolio').pajinate({
		items_per_page : itemsPerPage,
		nav_label_prev: pagePrev,
		nav_label_next: pageNext
	});

});

/***************************************************************
* (8) Hide Info Boxes *
****************************************************************/

function hide_boxes(){
	$('span.hide-boxes,span.hide-boxes2').click(function() {
		$(this).parent().fadeOut();
	});
}
hide_boxes();

/***************************************************************
* (9) Flex slider * - Post Format Gallery, Logo, Recent Projects etc.
****************************************************************/

// Post Format Gallery Slider

$(".swm_slider").each(function(){

	var $this				= $(this),
		autoslideOn			= $this.attr("data-autoSlide") || 0,
		autoslideInterval	= parseInt($this.attr("data-autoSlideInterval") || 7000),
		bulletNav			= $this.attr("data-bulletNavigation") || 0,
		arrowNav			= $this.attr("data-arrowNavigation") || 0;

	if(autoslideOn == "true") { autoslideOn = true; } else { autoslideOn = false; }
	if(bulletNav == "true") { bulletNav = true; } else { bulletNav = false; }
	if(arrowNav == "true") { arrowNav = true; } else { arrowNav = false; }
	
    $(this).flexslider({
		slideshow: autoslideOn,
		controlNav: bulletNav,
		directionNav : arrowNav,
		slideshowSpeed: autoslideInterval,
        smoothHeight: true
    });
	
});

// Recent Projects Slider

$(".rp_slider").each(function(){

	var $this				= $(this),
		autoslideOn			= $this.attr("data-autoSlide") || 0,
		autoslideInterval	= parseInt($this.attr("data-autoSlideInterval") || 7000);

	if(autoslideOn == "true") { autoslideOn = true; } else { autoslideOn = false; }

	$(this).imagesLoaded( function() {
        $(this).flexslider({
			slideshowSpeed: autoslideInterval,
			animation: "slide",
			animationLoop: true,
			itemWidth: 227,
			itemMargin: 10,
			slideshow: autoslideOn
        });
	});
});

// Logo Slider

$(".logo_slider").each(function(){

	var $this				= $(this),
		autoslideOn			= $this.attr("data-autoSlide") || 0,
		autoslideInterval	= parseInt($this.attr("data-autoSlideInterval") || 7000);

	if(autoslideOn == "true") { autoslideOn = true; } else { autoslideOn = false; }
	
	$(this).imagesLoaded( function() {
        $(this).flexslider({
			slideshowSpeed: autoslideInterval,
			animation: "slide",
			animationLoop: true,
			itemWidth: 148,
			itemMargin: 10,
			slideshow: autoslideOn
        });
	});
});

// Team Member Slider

$(".tm_slider").each(function(){

	var $this				= $(this),
		autoslideOn			= $this.attr("data-autoSlide") || 0,
		autoslideInterval	= parseInt($this.attr("data-autoSlideInterval") || 7000);

	if(autoslideOn == "true") { autoslideOn = true; } else { autoslideOn = false; }

	$(this).imagesLoaded( function() {
        $(this).flexslider({
			slideshowSpeed: autoslideInterval,
			animation: "slide",
			animationLoop: true,
			itemWidth: 180,
			itemMargin: 10,
			slideshow: autoslideOn
        });
	});
});

/***************************************************************
* (10) Rotate Testimonials *
****************************************************************/

$(".testimonials-bx-slider").each(function(){

	var $this				= $(this),
		animationType		= $this.attr("data-animationType") || 'fade',
		autoSlideshow		= $this.attr("data-autoSlideshow") || true,
		smoothHeight		= $this.attr("data-smoothHeight") || true,
		pauseHover			= $this.attr("data-pauseHover") || true,
		displayNavigation	= $this.attr("data-displayNavigation") || true,
		slideshowSpeed		= parseInt($this.attr("data-slideshowSpeed") || 500),
		slideshowInterval	= parseInt($this.attr("data-slideshowInterval") || 4000);

	if(autoSlideshow == "true") { autoSlideshow = true; } else { autoSlideshow = false; }
	if(smoothHeight == "true") { smoothHeight = true; } else { smoothHeight = false; }
	if(pauseHover == "true") { pauseHover = true; } else { pauseHover = false; }
	if(displayNavigation == "true") { displayNavigation = true; } else { displayNavigation = false; }

	$(this).bxSlider({
		mode: animationType,
		auto:autoSlideshow,
		autoHover:pauseHover,
		adaptiveHeight: smoothHeight,
		adaptiveHeightSpeed:500,
		speed:slideshowSpeed,
		pause:slideshowInterval,
		controls:displayNavigation
	});
});


/***************************************************************
* (11) Portfolio *
****************************************************************/

$(".pf_sort").imagesLoaded( function() {
	$('.pf_sort').isotope({
	itemSelector: '.pf_box',
	masonry: {
		//custom addition
	}
	});
});

$('.filter_menu a').click(function(){
	var selector = $(this).attr('data-filter');
	$('.pf_sort').isotope({filter: selector});
	$('.filter_menu a.active').removeClass('active');
	$(this).addClass('active');
	return false;
});

/***************************************************************
* (13) Image Hover fade effect *
****************************************************************/

$(document).ready(function(){

	$(".fade-img").show();
	$(".fade-img img").fadeTo('normal', 1, function() {
		$get_id = $(this).parent().parent().attr("data-lang");
		if($get_id !== ""){
			$(this).parent().parent().addClass($get_id);
			$(this).hover(function(){
				$(this).fadeTo('normal', 0.2);
			}, function() {
					$(this).fadeTo('normal', 1);
			});
		}
	});
		
	$(".fade-img2").show();
	$(".fade-img2 img").fadeTo('fast', 1.0, function() {
		$get_id = $(this).parent().parent().attr("data-lang");
		if($get_id !== ""){
			$(this).parent().parent().addClass($get_id);
			$(this).hover(function(){
				$(this).fadeTo('fast', 0.1);
			}, function() {
					$(this).fadeTo('fast', 1.0);
			});
		}
	});
		
	$(".fade-img3").show();
	$(".fade-img3").fadeTo('normal', 1, function() {
		$get_id = $(this).parent().parent().attr("a");
		if($get_id !== ""){
			$(this).parent().parent().addClass($get_id);
			$(this).hover(function(){
				$(this).fadeTo('normal', 0.7);
			}, function() {
					$(this).fadeTo('normal', 1);
			});
		}
	});
	
	$(".flexslider .slides > li .tm_hover").fadeTo("normal", 0);
	$(".flexslider .slides > li .tm_hover").hover(function(){
	$(this).stop().fadeTo("normal", 1.0);
	},function(){
	$(this).stop().fadeTo("normal", 0);
	});

});

/***************************************************************
* (14) Resize Media *
****************************************************************/

function responsive_media() {
    if( $().jPlayer && $('.jp-jplayer').length ){
        $(window).resize(function(){
            $('.jp-jplayer').each(function(){
                var self = $(this),
					old_width = parseInt(self.attr("data-mediaWidth") || 608),
					old_height = parseInt(self.attr("data-mediaHeight") || 349),
					new_width = old_width,
					new_height = old_height,
					w_width = $(window).width();
                
                if( w_width <= 939 ) { new_width = 442; }
                if( w_width <= 767 ) { new_width = 396; }
                if( w_width <= 480 ) { new_width = 233; }

                var ratio =  (new_width / old_width) * old_height;
                new_height = Math.round(ratio);

                if(self.hasClass('jp-jplayer')) {
                    self.jPlayer('option', 'size', { width: new_width, height: new_height });
                }
                if(self.hasClass('embed-video')) {
                    self.width(new_width).height(new_height);
                }
            });
        });
        $(window).trigger('resize');
    }
}
responsive_media();

/****************************************************************/
/****************************************************************/
}); })(jQuery);
// Do not delete above line


/***************************************************************
* (15) Contact Form *
****************************************************************/

jQuery(document).ready(function(){
	jQuery("input:text, input:password, textarea").forminput();
	jQuery("#contact_form").contact_form({
			response: "#msg",
			submit: "#submit",
			timer: 4500,
			easing: "",
			speedIn: 700,
			speedOut: 700
	});
});
// Input Field Script
(function($) {
	$.fn.forminput = function() {
		return this.each(function() {
			var $root = $(this);
			var inputValue = $root.val();
			
			function reset() {
				var value = $root.val();
				if(inputValue == value) {
					$root.val("");
				}
			}
			
			function blur() {
				var value = $root.val();
				if(value === ""){
					$root.val(inputValue);
				}
			}
			
			$root.focus(function() {
				reset();
			});
			$root.blur(function() {
				blur();
			});
		});
	};
})(jQuery);

// Form Script
(function($) {
	$.fn.contact_form = function(options) {
		var defaults = {
			response: "#msg",
			submit: "#submit",
			timer: 4500,
			easing: "",
			speedIn: 700,
			speedOut: 700
		};
		var options = $.extend({}, defaults, options);
		
		return this.each(function () {
			var $root = $(this);
			var $response = $(options.response);
			var $submit = $(options.submit);
			
			function showMsg($timer) {
				$response.css("opacity", 0);
				$response.show().stop().animate({
					opacity: 1
				}, options.speedIn, options.easing, function(){
					interval = setInterval(hideMsg, $timer);
				});
			}
			
			function hideMsg() {
				clearInterval(interval);
				$response.stop().animate({
					opacity:0
				}, options.speedIn, options.easing, function() {
					$response.hide();
					$submit.fadeIn(700);
				});
			}
			
			$root.submit(function(){
				$.ajax({
					type: "POST",
					url: "sendmail.php",
					data: $(this).serialize(),
					success: function(output) {
						$(document).ajaxComplete(function() {
							if(output == 'ok') {
								$('#contactdiv').html("<div id='smessage'></div>");
								$('#smessage').html("<h3>Contact Form Submitted!</h3>").append("<p>We will be in touch soon.</p>").hide().fadeIn(1500, function() {
								$('#smessage').append("");
								});
							} else {
								$('#msg').html(output);
								showMsg(options.timer);
							}
						});
					}
				});
				return false;
			});
		});
	};
})(jQuery);
