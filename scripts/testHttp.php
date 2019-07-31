<?php

require_once __DIR__ . '/../bootstrap.php';

use PhpCodeTest\Client\Factory as ClientFactory;
use PhpCodeTest\Client\ClientException;

$httpClient = (new ClientFactory)->createClient();

try {
    $response = $httpClient->get('pgburton.com?foo=bar&limit=1');
} catch (ClientException $e) {
    $error = $httpClient->getError();
    var_dump($error);
    die();
}

var_dump((string) $response->getBody());
die();
