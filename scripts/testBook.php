<?php

require_once __DIR__ . '/../bootstrap.php';

use PhpCodeTest\Library\Book;
use PhpCodeTest\Client\ClientException;

try {
    $book = new Book('http://pgburton.com');

    $book = $book->createFromQuery(
        $book->getQuery()
            ->setParam('limit', 20)
            ->setParam('author', 'test')
    );
} catch (ClientException $e) {
    var_dump($e->getMessage());
    die();
}
