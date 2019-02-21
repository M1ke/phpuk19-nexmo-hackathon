<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
$app = new \Slim\App;

function log($data){
	if (is_array($data) || is_array($data)){
		$data = json_encode($data, JSON_PRETTY_PRINT);
	}
	$date = date('c');
	file_put_contents(__DIR__.'/log', "[$date] $data\n");
}

$handler = function (Request $request, Response $response){
	$params = $request->getParsedBody();
	// Fall back to query parameters if needed
	if (!count($params)){
		$params = $request->getQueryParams();
	}
	log($params);

	$body = \Slim\Http\Stream::

	$response->withBody()

	return $response->withStatus(204);
};


$app->get('/webhooks/inbound-sms', $handler);
$app->post('/webhooks/inbound-sms', $handler);
$app->run();
