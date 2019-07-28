<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpCodeTest\GetBookList;

$getBookList = new GetBookList();
$json = $getBookList->getBooksByAuthor('Test Author', 1);

print_r($json);
