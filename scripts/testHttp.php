<?php

require_once __DIR__ . '/../bootstrap.php';

use PhpCodeTest\Client\Factory as ClientFactory;

$httpClient = (new ClientFactory)->createClient();

$response = $httpClient->get('pgburton.com?foo=bar&limit=1');

var_dump((string) $response->getBody());
die();
