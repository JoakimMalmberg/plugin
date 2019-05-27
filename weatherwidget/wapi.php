<?php

/**
 * Function for communicationg with Weather API
 */

function wapi_get_weather(){
	//Do We Have The weather Catched?
	$weather = get_transient('wapi_get_weather');
	// If so return catched weather
	if($weather){
		return $weather;
	}else{
		//Else retrive weather from SW API
		$result = wp_remote_get('http://api.openweathermap.org/data/2.5/weather?q=malmoe&id=524901&APPID=5ae275d1a0023fc435486dc31a45cd67');
		if(wp_remote_retrieve_response_code($result) === 200){
			$data = json_decode(wp_remote_retrieve_body( $result ));
			$weather = $data->results;
			set_transient('wapi_get_weather', $weather, 60*60);
			return $weather;
		}else{
			return false;
		}
	}
}

















// function wapi_get_url($url){
// 	$response = wp_remote_get($url);
// 	if(is_wp_error($response)){
// 		return false;
// 	}else{
// 		return json_decode(wp_remote_retrive_body($response));
// 	}
// }

// function wapi_get($endpoint){
// 	$transient_key = "wapi_get_{$endpoint}";

// 	$items = get_transient($transient_key);

// 	if(!$items){
// 		$items = wapi_get_url("http://api.openweathermap.org/data/2.5/forecast?id=524901&APPID=5ae275d1a0023fc435486dc31a45cd67");
// 		while($url){
// 		$data = wapi_get_url($url);
// 		if(!$data){
// 			return false;
// 		}
// 		$items = array_merge($items, $data->results);
// 		$url = $data->next;
// 		}
// 		//set_transient($transient_key, $items, 60*60);
// 	}
// 	return $items;
// }

// function wapi_get_weather(){
// 	return wapi_get('weater');
// }