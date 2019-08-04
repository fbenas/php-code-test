<?php

namespace PhpCodeTest\Client\Parser;

use PhpCodeTest\Client\Contracts\ParserInterface;
use PhpCodeTest\Parser\ParserException;

/**
 * Parse JSON
 *
 * @author Phil Burton <phil@pgburton.com>
 */
class Json implements ParserInterface
{
    /**
     * Parse string
     *
     * @param string $string
     * @return mixed
     * @author Phil Burton <phil@pgburton.com>
     */
    public function parse(string $string)
    {
        $string = '{
            "bookstore": {
                "book": {
                    "name": "Everyday Italian",
                    "author_name": "Giada De Laurentiis",
                    "isbn_number": "1234",
                    "stock": {
                        "number": "3",
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
