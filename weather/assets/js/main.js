(function ($) {


})(jQuery);

function get_current_weather(widget_id, widget_city, widget_country){

	// fire some async request
	console.log("Firing away request for current weather in " + widget_city + ',' + widget_country + ' for widget: ' + widget_id);

	jQuery.post(
		weather_ajax_obj.ajax_url, // URL
		{
			action: 'get_current_weather',
			city: widget_city,
			country: widget_country,
		},
		function (data) {
			console.log("GOT RESPONSE for widget " + widget_id + "!!!! YAY!!", data);
			var output = "";
			output += '<strong>Temperature:</strong> ' + data.temperature + '&deg; C<br>';
			output += '<strong>Humidity:</strong> ' + data.humidity + '%<br>';
			jQuery('#' + widget_id + ' .current-weather').html(output);
		}
	);
}
