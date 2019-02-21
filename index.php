<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

require 'config.php';

$app = new \Slim\App;

/**
 * @param mixed $data
 */
function log_data($data){
	if (is_array($data) || is_array($data)){
		$data = json_encode($data, JSON_PRETTY_PRINT);
	}
	$date = date('c');
	file_put_contents(__DIR__.'/log', "[$date] $data\n", FILE_APPEND);
}

/**
 * @param string $text
 * @return string
 */
function messageFromText($text){
	list($activity, $names) = explode(':', $text);

	if (empty($activity) || empty($names)){
		return 'Sorry, we couldn\'t find a valid question & names in your message';
	}

	$activity = str_replace(['Who', 'who'], '', $activity);
	$activity = trim($activity);

	if (empty($activity)){
		return 'Sorry we couldn\'t work out your activity - send messages like "who should xxx: name, name2, name3';
	}

	$names = trim($names);
	$names = str_replace(',', '', $names);
	$names = explode(' ', $names);

	if (empty($names)){
		return 'Sorry we couldn\'t read names in your message - put a colon before the list and separate them with spaces';
	}

	if (function_exists('random_int')){
		$rand = random_int(0, count($names)-1);
	}
	else {
		$rand = rand(0, count($names)-1);
	}
	$chosen = $names[$rand];
	$chosen = trim($chosen);

	$message = "$chosen $activity";

	return $message;
}

$handler = function (Request $request, Response $response){
	$params = $request->getParsedBody();
	// Fall back to query parameters if needed
	if (!count($params)){
		$params = $request->getQueryParams();
	}

	/*
	 * {
  "msisdn": "447700900001",
  "to": "447700900000",
  "messageId": "0A0000000123ABCD1",
  "text": "Hello world",
  "type": "text",
  "keyword": "Hello",
  "message-timestamp": "2020-01-01T12:00:00.000+00:00",
  "timestamp": "1578787200",
  "nonce": "aaaaaaaa-bbbb-cccc-dddd-0123456789ab",
  "concat": "true",
  "concat-ref": "1",
  "concat-total": "3",
  "concat-part": "2",
  "data": "abc123",
  "udh": "abc123"
}
	 */
	log_data($params);

	$text = $params['text'];

	$message = messageFromText($text);

	$basic = new \Nexmo\Client\Credentials\Basic(NEXMO_API, NEXMO_SECRET);
	$client = new \Nexmo\Client($basic);

	log_data("Sending message '$message'");

	$client->message()->send([
		'to' => $params['msisdn'],
		'from' => $params['to'],
		'text' => $message,
	]);

	return $response->withStatus(204);
};


$app->get('/webhooks/inbound-sms', $handler);
$app->post('/webhooks/inbound-sms', $handler);
$app->run();
