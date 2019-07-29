<?php

require_once __DIR__ . '/../bootstrap.php';

use GuzzleHttp\Psr7\Request;
use PhpCodeTest\Client\Http;
use PhpCodeTest\Client\Handlers\Curl;

$curlHandler = new Curl;

$httpClient = new Http($curlHandler);

$request = new Request("GET", 'pgburton.com');

$result = $httpClient->get($request);

var_dump($result);
die();
