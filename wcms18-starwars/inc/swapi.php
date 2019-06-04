<?php
/**
 * Function for communicate with sw api
 */
function swapi_get_films(){


	$result = wp_remote_get('https://swapi.co/api/films/');
	
	if(is_wp_error($result) || wp_remote_retrieve_response_code($result) !== 200){
		return false;
	}

	$data = json_decode(wp_remote_retrieve_body( $result ));

	$films = [];

	$films['films'] = $data->results;

	return $films;
}
