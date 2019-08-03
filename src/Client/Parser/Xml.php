<?php

namespace PhpCodeTest\Client\Parser;

use PhpCodeTest\Client\Contracts\ParserInterface;

class Xml implements ParserInterface
{
    public function parse(string $string)
    {
        return $string;
    }
}
