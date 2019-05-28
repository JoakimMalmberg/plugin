(function ($) {
	$(document).ready(function () {
		$.post(
			my_ajax_obj.ajax_url,
			{
				action: 'get_current_weather',
			},
			function (response) {
				console.log('got Response!!', response);
			}
		);
	});
})(jQuery);

