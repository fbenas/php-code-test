<?php

namespace PhpCodeTest\Tests\Unit;

use PhpCodeTest\Tests\Unit\AbstractTest;

/**
 * Some unit tests to cover the current GetBookList class
 * I've not tried to be to be exhaustive here, just to show that we could cover the current implementation with test
 * coverage if we want to refactor further and still mitigate some risk.
 *
 * Equally, as the current code has a few issues and doesn't really work or handle errors correctly, more coverage
 * at this stage is not-so useful.
 */
class GetBookListTest extends AbstractTest
{
    /**
     * Test getCurlUrl
     *
     * @dataProvider getCurlUrlData
     * @param string $author
     * @param int $limit
     * @param string $expected
     * @param string|null $format
     * @author Phil Burton <phil@d3r.com>
     */
    public function testGetCurlUrlReturnsExpectedUrl(
        string $author,
        int $limit,
        string $expected,
        string $format = null
    ) {
        $instance = $this->getInstance($format);
        $url = $this->invokeMethod($instance, 'getCurlUrl', [$author, 1]);
        $this->assertSame($expected, $url);
    }

    /**
     * Data for testing getCurlUrl
     *
     * @return mixed[]
     * @author Phil Burton <phil@d3r.com>
     */
    public function getCurlUrlData(): array
    {
        return [
            [
                'TestAuthor',
                1,
                'http://api.book-seller-example.com/by-author?q=TestAuthor&limit=1&format=json',
                'json',
            ],
            [
                'TestAuthor',
                1,
                'http://api.book-seller-example.com/by-author?q=TestAuthor&limit=1&format=json',
            ],
            [
                'TestAuthor',
                1,
                'http://api.book-seller-example.com/by-author?q=TestAuthor&limit=1&format=xml',
                'xml'
            ],
        ];
    }

    /**
     * Test getArrayFromXml
     *
     * @author Phil Burton <phil@d3r.com>
     */
    public function testGetArrayFromXmlStringReturnsExpectedArray()
    {
        $string =
            '<?xml version="1.0" encoding="utf-8"?>
            <bookstore>
                <book>
                    <name>Everyday Italian</name>
                    <author_name>Giada De Laurentiis</author_name>
                    <isbn_number>1234</isbn_number>
                    <stock>
                        <number>0</number>
                        <unit_price>30.12</unit_price>
                    </stock>
                </book>
            </bookstore>';

        $expected = [
            [
                'title' => 'Everyday Italian',
                'author' => 'Giada De Laurentiis',
                'isbn' => 1234,
                'quantity' => 0,
                'price' => 30.12
            ]
        ];

        $instance = $this->getInstance('xml');
        $array = $this->invokeMethod($instance, 'getArrayFromXmlString', [$string]);

        $this->assertEquals($expected, $array);
    }

    /**
     * Test getArrayFromJson
     *
     * @author Phil Burton <phil@d3r.com>
     */
    public function testGetArrayFromJsonStringReturnsExpectedArray()
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

        $expected = [
            [
                'title' => 'Everyday Italian',
                'author' => 'Giada De Laurentiis',
                'isbn' => 1234,
                'quantity' => 0,
                'price' => 30.12
            ]
        ];

        $instance = $this->getInstance('json');
        $array = $this->invokeMethod($instance, 'getArrayFromJsonString', [$string]);

        $this->assertEquals($expected, $array);
    }
}
