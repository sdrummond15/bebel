/* ----------------------------------------

	* Ideal Forms 1.02
	* Copyright 2011, Cedric Ruiz
	* Free to use under the GPL license.
	* http://www.spacirdesigns.com

-----------------------------------------*/

/* ---------------------------------------
	Set min-width
----------------------------------------*/
var setMinWidth = function (el) {
	var minWidth = 0;
	el
	.each(function () {
		var width = $(this).width();
		if (width > minWidth) {
			minWidth = width;
		}
	})
	.width(minWidth);
};

/* ---------------------------------------
	Start plugin
----------------------------------------*/
(function ($) {

	$.fn.idealforms = function () {
		this.each(function () {

			var $idealform,
			$labels;

			$idealform = $(this);
			$idealform.addClass('idealform');

/* ---------------------------------------
	Label
----------------------------------------*/

			$labels = $idealform.find('div').children('label').addClass('main-label');
			$labels.filter('.required').prepend('<span>*</span>');
			setMinWidth($labels);

		});

	};
})(jQuery);