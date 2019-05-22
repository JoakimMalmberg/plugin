<?php

/**
 * Function for communicate with sw api
 */

function swapi_get_films(){

	//Do We Have The Films Catched?
	$films = get_transient('swapi_get_films');

	// If so return catched films
	if($films){
		return $films;
	}else{
		//Else retrive films from SW API
		$result = wp_remote_get('https://swapi.co/api/films/');

		if(wp_remote_retrieve_response_code($result) === 200){
			$data = json_decode(wp_remote_retrieve_body( $result ));
			$films = $data->results;
			set_transient('swapi_get_films', $films, 60*60);
			return $films;

		}else{
			return false;
		}
	}
}


function swapi_get_character($character_id){

	//Do We Have The Films Catched?
	$character = get_transient('swapi_get_character_' . $character_id);

	// If so return catched character
	if($character){
		return $character;
	}else{
		//Else retrive character from SW API
		$result = wp_remote_get('https://swapi.co/api/people/' . $character_id);

		if(wp_remote_retrieve_response_code($result) === 200){
			$character = json_decode(wp_remote_retrieve_body( $result ));
			set_transient('swapi_get_character_' . $character_id, $character, 60*60*24);
			return $character;
		}else{
			return false;
		}
	}
}