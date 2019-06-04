(function ($) {


})(jQuery);

function get_starwars(widget_id) {
	console.log("44" + get_sw_trivia.ajax_url);

	jQuery.post(
		get_sw_trivia.ajax_url, // URL
		{
			action: 'get_starwars',
			id: widget_id,
		},
		function (data) {
			var output = "";

			data.films.forEach(function (v) {
				output += "Episode: " + v.episode_id + "<br>" + v.title + "<br>" + " by: " + v.director + "<br><br>";
			});

			jQuery('#' + widget_id + ' .starwars').html(output);
		}
	);
}