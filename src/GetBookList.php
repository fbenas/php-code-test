<?php

namespace PhpCodeTest;

use SimpleXMLElement;
use Exception;

/**
 * A all-in-one client for getting and handling an api GET
 *
 * @author Phil Burton <phil@d3r.com>
 */
class GetBookList
{
    /**
     * What format will we return?
     *
     * @var string xml|json
     */
    protected $format;

    /**
     * Construct our object; set the format
     *
     * @param string $format
     * @author Phil Burton <phil@d3r.com>
     */
    public function __construct(string $format = 'json')
    {
        $this->format = $format;
    }

    /**
     * Make an API call to get a list of authors
     * Convert the result into an array
     *
     * @param string $authorName
     * @param int $limit
     * @return array
     * @author Phil Burton <phil@d3r.com>
     */
    public function getBooksByAuthor(string $authorName, int $limit = 10): array
    {
        $return = [];

        $output = $this->runCurl($authorName, $limit);

        if ($this->format == 'json') {
            $return = $this->getArrayFromJsonString($output);
        } elseif ($this->format == 'xml') {
            $return = $this->getArrayFromXmlString($output);
        }

        return $return;
    }

    /**
     * Convert a string of JSON to an array
     *
     * @param string $string
     * @return array
     * @author Phil Burton <phil@d3r.com>
     */
    protected function getArrayFromJsonString(string $string): array
    {
        $json = json_decode($string);

        if (!$json) {
            return [];
        }

        $array = [];
        foreach ($json as $result) {
            $array[] = [
                'title' => $result->book->title,
                'author' => $result->book->author,
                'isbn' => $result->book->isbn,
                'quantity' => $result->stock->level,
                'price' => $result->stock->price,
            ];
        }

        return $array;
    }

    /**
     * Convert a string of XML to an array
     *
     * @param string $string
     * @return array
     * @author Phil Burton <phil@d3r.com>
     */
    protected function getArrayFromXmlString(string $string): array
    {
        try {
            // For now just hope everything works, if not, return silently
            $xml = new SimpleXMLElement($string);

            $array = [];
            foreach ($xml as $result) {
                $array[] = [
                    'title' => $result->book['name'],
                    'author' => $result->book['author_name'],
                    'isbn' => $result->book['isbn_number'],
                    'quantity' => $result->book->stock['number'],
                    'price' => $result->book->stock['unit_price'],
                ];
            }
        } catch (Exception $e) {
            // Make sure we return correctly
            return [];
        }

        return $array;
    }

    /**
     * Return the URL to make the response to
     *
     * @return string
     * @author Phil Burton <phil@d3r.com>
     */
    protected function getCurlUrl(): string
    {
        // return 'pgburton.com';
        return "http://api.book-seller-example.com/by-author?q="
            . $authorName
            . '&limit='
            . $limit
            . '&format='
            . $this->format;
    }

    /**
     * Execute a curl request, return the output, silently handle errors
     *
     * @param string $authorName
     * @param int $limit
     * @return string
     * @author Phil Burton <phil@d3r.com>
     */
    protected function runCurl(string $authorName, int $limit): string
    {
        $curl = curl_init();

        // Set the url
        curl_setopt($curl, CURLOPT_URL, $this->getCurlUrl($authorName, $limit));
        // Get curl to return the result not print it
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Store the output
        $output = curl_exec($curl);

        // Get the error so we can check how the exec went
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            // Return a valid array
            return '';
        }

        return $output;
    }
}
