var googleMap,
	geocoder;

function initMap() {
	var $ = jQuery,
		$wrapper = $('#wcms18-mappy-weather'),
		address = $wrapper.data('address'),
		$map = $wrapper.find('#map'),
		$weather = $wrapper.find('#weather'),
		map = $map[0],


		geocoder = new google.maps.Geocoder();
	geocoder.geocode({
		address: address
	}, function (results, status) {
		if (results.length > 0) {
			var latLng = results[0].geometry.location;
			googleMap = createMap(map, latLng);

			getWeather($weather, latLng);

			var centerMarker = new google.maps.Marker({
				position: latLng,
				map: googleMap
			});
		}
	});
}	

function createMap(mapElement, latLng) {
	return new google.maps.Map(map, {
		center: latLng,
		zoom: 11
	});
}

function getWeather(el, latLng) {
	var $ = jQuery;
	$.post(
			wcms18_mappy_weather_obj.ajax_url, 
			{
				action: 'wcms18_mappy_weather__get',
				lat: latLng.lat,
				lng: latLng.lng
			}
		)
		.done(function (res) {
			console.log("Success in getWeather", res);
			if (!res.success) {
				$(el).html('<div>Error getting weather</div>')
			}
			$(el).html('<strong>Temperature:</strong> ' + res.data.temperature + ' &deg;C<br><strong>Humidity:</strong> ' + res.data.humidity + ' %');
		})
		.fail(function (error) {
			console.error("Error getWeather", error);
		});
}