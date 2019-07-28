<?php

namespace PhpCodeTest;

use SimpleXMLElement;
use Exception;

class GetBookList
{
    private $format;

    public function __construct(string $format = 'json')
    {
        $this->format = $format;
    }

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
