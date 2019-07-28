<?php

require_once __DIR__ . '/../bootstrap.php';

use PhpCodeTest\GetBookList;

$getBookList = new GetBookList();
$json = $getBookList->getBooksByAuthor('Test Author', 1);

$getBookList = new GetBookList('xml');
$json = $getBookList->getBooksByAuthor('Test Author XML', 1);

print_r($json);
