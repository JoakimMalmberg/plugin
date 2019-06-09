(function ($) {
	'use strict';

	$(document).ready(function () {
		$('.widget_random-animals').each(function (i, widget) {
			$.post(
				get_random_animal.ajax_url, {
					action: 'random_animal__get'
				}
			).done(function (random_animal) {
				var output = "";

				output += '<img src="' + random_animal.data.link + '"><br><br>';
				$(widget).find('.content').html(output);
			}).fail(function (error) {
				console.log("something went wrong!", error);
			});
		});
	});
})(jQuery);
