<?php

require 'vendor/autoload.php';
require_once './Api/Example/HttpClient.php';

$client = new \Augustash\Api\Example\HttpClient(['base_uri' => 'http://foo.dev/api', 'url' => 'bar']);

$dataFormat = 'xml'; // or 'json'
$response = $client->sayHello('Josh', $dataFormat);

$code = $response->getStatusCode(); // 200
$reason = $response->getReasonPhrase(); // OK

echo $response->getBody();
