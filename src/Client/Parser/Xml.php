<?php

namespace PhpCodeTest\Client\Parser;

use PhpCodeTest\Client\Contracts\ParserInterface;
use PhpCodeTest\Parser\ParserException;
use SimpleXMLElement;
use StdClass;

/**
 * Xml parser
 *
 * @author Phil Burton <phil@pgburton.com>
 */
class Xml implements ParserInterface
{
    /**
     * Parse a string
     *
     * @param string $string
     * @return mixed
     * @author Phil Burton <phil@pgburton.com>
     */
    public function parse(string $string)
    {
        if (!$string) {
            throw new ParserException('JSON: Cannot parse empty string');
        }

        $string =
            '<?xml version="1.0" encoding="utf-8"?>
            <bookstore>
                <book>
                    <name>Everyday Italian</name>
                    <author_name>Giada De Laurentiis</author_name>
                    <isbn_number>1234</isbn_number>
                    <stock>
                        <number>3</number>
                        <unit_price>30.12</unit_price>
                    </stock>
                </book>
            </bookstore>';

        $xml = new SimpleXMLElement($string);

        if (!$xml) {
            throw new ParserException('JSON: Failed to parse string');
        }

        $item = [];

        foreach ($xml as $result) {
            $item['title'] = (string) $result->name;
            $item['author'] = (string) $result->author_name;
            $item['isbn'] = (string) $result->isbn_number;
            $item['stock'] = (string) $result->stock->number;
            $item['price'] = (string) $result->stock->unit_price;
        }

        return $item;
    }
}
