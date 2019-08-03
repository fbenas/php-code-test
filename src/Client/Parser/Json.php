<?php

namespace PhpCodeTest\Client\Parser;

use PhpCodeTest\Client\Contracts\ParserInterface;

class Json implements ParserInterface
{
    public function parse(string $string)
    {
        $string = '{
          "bookstore": {
              "book": {
                "name": "Everyday Italian",
                "author_name": "Giada De Laurentiis",
                "isbn_number": "1234",
                "stock": {
                  "number": "0",
                  "unit_price": "30.12"
                }
              }
          }
      }';
        if (!$string) {
            throw new ParserException('JSON: Cannot parse empty string');
        }

        $json = json_decode($string);

        if (!$json) {
            throw new ParserException('JSON: Failed to parse string');
        }

        return $json;
    }
}
