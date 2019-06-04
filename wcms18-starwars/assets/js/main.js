(function ($) {


})(jQuery);

function get_starwars(widget_id, sw_film) {

	// fire some async request
	console.log("Firing away request for starwars film in " + sw_film);
	console.log("widget id " + widget_id);

	jQuery.post(
		get_sw_trivia.ajax_url, // URL
		{
			action: 'get_starwars',
			film: sw_film,
			id: widget_id,
		},
		function (data) {
			var output = "";

			data.films.forEach(v => {
				output += "Episode: " + v.episode_id + " " + v.title + "<br>" + " by: " + v.director + "<br><br>";
			});

			jQuery('#' + widget_id + ' .starwars').html(output);
		}
	);
}