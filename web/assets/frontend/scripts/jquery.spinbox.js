(function ($) {

	$.fn.SS6 = $.fn.SS6 || {};
	$.fn.SS6.spinbox = $.fn.SS6.spinbox || {};
	
	$.fn.SS6.spinbox.init = function (formElement) {
		$('.js-spinbox').each($.fn.SS6.spinbox.bindSpinbox);
	}
	
	$.fn.SS6.spinbox.bindSpinbox = function () {
		var $input = $(this).find('input.js-spinbox-input');
		var $plus = $(this).find('.js-spinbox-plus');
		var $minus = $(this).find('.js-spinbox-minus');
		
		$input
			.bind('spinbox.plus', $.fn.SS6.spinbox.plus)
			.bind('spinbox.minus', $.fn.SS6.spinbox.minus);
		
		$plus
			.bind("mousedown.spinbox",function(e){
				repeater.startAutorepeat($input, 'spinbox.plus');
			})
			.bind("mouseup.spinbox mouseout.spinbox", function(e){
				repeater.stopAutorepeat();
			});
			
		$minus
			.bind("mousedown.spinbox",function(e){
				repeater.startAutorepeat($input, 'spinbox.minus');
			})
			.bind("mouseup.spinbox mouseout.spinbox", function(e){
				repeater.stopAutorepeat();
			});
		
	}
	
	$.fn.SS6.spinbox.plus = function() {
		var value = $.trim($(this).val())
		var max = $(this).data('spinbox-max');
		
		if (value.match(/^\d+$/)) {
			value = parseInt(value) + 1;
			if (max !== undefined && max < value) {
				value = max;
			}
			$(this).val(value);
			$(this).change();
		}
	}
	
	$.fn.SS6.spinbox.minus = function() {
		var value = $.trim($(this).val())
		var min = $(this).data('spinbox-min');
		
		if (value.match(/^\d+$/)) {
			value = parseInt(value) - 1;
			if (min !== undefined && min > value) {
				value = min;
			}
			$(this).val(value);
			$(this).change();
		}
	}
	
	var repeater = {
		timerDelay: null,
		timerRepeat: null,
		
		startAutorepeat: function($input, eventString) {
				$input.trigger(eventString);
				repeater.stopAutorepeat();
				repeater.timerDelay = setTimeout(function(){
					$input.trigger(eventString);
					repeater.timerRepeat = setInterval(function(){
						$input.trigger(eventString);
					}, 100);
				}, 500);
			},

		stopAutorepeat: function() {
			clearTimeout(repeater.timerDelay);
			clearInterval(repeater.timerRepeat);
		}
	};
	
	$(document).ready(function () {
		$.fn.SS6.spinbox.init();
	});
	
})(jQuery);
