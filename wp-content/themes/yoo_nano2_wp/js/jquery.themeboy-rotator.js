// ThemeBoy Image Rotator
;(function($){
	$.fn.rotator = function(options) {
		var defaults = {
			delay: 4000
		};
		var options = $.extend(defaults, options);
		var self = this;
		var timeInterval = options.delay;
		var z = 0;
		var slide = 0;
		var autoSlide = 0;
		var busy = 0;
		var queue = null;
		$(self).find(".main_image .desc").show();
		$(self).find(".main_image ul li:first").show();
		$(self).find(".main_image ul li:first").siblings().hide();
		$(self).find(".image_thumb ul li:first").addClass('active');
		$(self).find(".image_thumb ul li").click(function(){
			if ($(this).is(".active") && queue != $(this).attr('data-slide')) {
				return false;
			} else if (busy) {
				$(self).find(".image_thumb ul li").removeClass('active');
				$(this).addClass('active');
				queue = $(this).attr('data-slide');
			} else {
				window.clearInterval(slideTimer);
				busy = 1;
				z++;
				$(self).find(".image_thumb ul li").removeClass('active');
				$(this).addClass('active');
				thisSlide = $(this).attr('data-slide');
				//pauseRotating();
				var imgDescHeight = $(self).find(".main_image ul li[data-slide="+slide+"] .block").height();
				$(self).find(".main_image ul li[data-slide="+slide+"]").css('z-index', z+1);
				$(self).find(".main_image ul li[data-slide="+slide+"] .block").animate({ opacity: 0, marginBottom: -imgDescHeight }, 300, function() {
					$(self).find(".main_image ul li[data-slide="+slide+"]").fadeOut(1000, function() {
						slide = thisSlide;
						autoSlide = thisSlide;
						$(self).find(".main_image ul li[data-slide="+thisSlide+"] .block").animate({ opacity: 1, marginBottom: 0 }, 300, function() {
							busy = 0;
							if (queue ==  null) {
								slideTimer = window.setInterval(nextSlide,Number(timeInterval));
							} else {
								$(self).find(".image_thumb ul li[data-slide="+queue+"]").click();
								queue = null;
							}
						});
					});
					$(self).find(".main_image ul li[data-slide="+thisSlide+"]").show().css('z-index', z);
					var imgDescHeight = $(self).find(".main_image ul li[data-slide="+thisSlide+"] .block").height();
					$(self).find(".main_image ul li[data-slide="+thisSlide+"] .block").css({ opacity: 0, marginBottom: -imgDescHeight }, 0);
				});
				return false;
			}
		}).hover(function(){
			$(this).addClass('hover');
		}, function() {
			$(this).removeClass('hover');
		});
		$(self).find(".image_thumb ul li .more a").click(function(){
			window.location = $(this).attr('href');
		});
		function nextSlide() {
			autoSlide++;
			if (autoSlide >= $(self).find(".image_thumb ul li").size()) autoSlide = 0;
			$(self).find(".image_thumb ul li[data-slide="+autoSlide+"]").click();
		}
		slideTimer = window.setInterval(nextSlide,Number(timeInterval));
	}
})(jQuery);