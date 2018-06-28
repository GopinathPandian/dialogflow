<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->place;

	switch ($text) {
		case 'hi':
			$speech = "Hi, Nice to meet you";
			break;

		case 'bye':
			$speech = "Bye, good night";
			break;

		case 'anything':
			$speech = "Yes, you can type anything here.";
			break;
		default:
			$res = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q={$text}&APPID=282def8ec7a8888ee244ce7c3b9880a0");
			$response = json_decode($res);
			#if (array_key_exists("cod",$response))
			#{
			#	$speech = "Sorry, I don't that. Please ask me someother place.";
			#}
			#else
			#{	
				$long = $response->coord->lon;
				$lat = $response->coord->lat;
				$speech = "Longitude is {$long} and Latitude is {$lat}";
				#$speech = "http://api.openweathermap.org/data/2.5/weather?q={$text}&APPID=282def8ec7a8888ee244ce7c3b9880a0";
			#}
			break;
	}

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>
