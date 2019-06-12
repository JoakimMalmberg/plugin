(function ($) {
	'use strict';

	$(document).ready(function () {
		$('.widget_random-lolcat').each(function (i, widget) {
			$.post(
				get_random_lolcat.ajax_url, {
					action: 'random_lolcat__get'
				}
			).done(function (random_lolcat) {
				var output = "";
				output += '<img src="' + random_lolcat.data.image + '"><br><br>';
				$(widget).find('.content').html(output);
			}).fail(function (error) {
				console.log("something went wrong!", error);
			});
		});
	});
})(jQuery);
