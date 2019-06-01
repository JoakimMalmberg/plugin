<?php

/**
 * Function for communicationg with Weather API
 */

 define('OWM_APP_ID', '5ae275d1a0023fc435486dc31a45cd67');

function wapi_get_weather($city, $country){

	$result = wp_remote_get("http://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&units=metric&appid=" . OWM_APP_ID);
	
	if(is_wp_error($result) || wp_remote_retrieve_response_code($result) !== 200){
		return false;
	}

	$data = json_decode(wp_remote_retrieve_body( $result ));

	$current_weather = [];
	$current_weather['temperature'] = $data->main->temp;
	$current_weather['humidity'] = $data->main->humidity;
	$current_weather['city'] = $data->name;
	$current_weather['country'] = $data->sys->country;
	$current_weather['conditions'] = $data->weather;




	return $current_weather;

}