<?php

namespace PhpCodeTest\Client\Handlers;

use PhpCodeTest\Contracts\HandlerInterface;

class Curl implements HandlerInterface
{
    private $responseCode;
    private $responseHeaders;
    private $responseBody;

    public function request(string $method, string $uri, array $options = [])
    {
        // START STUFF
        $curl = curl_init();

        // REQUEST STUFF
        // Set the url
        curl_setopt($curl, CURLOPT_URL, $uri);
        // Get curl to return the result not print it
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Get headers
        curl_setopt($curl, CURLOPT_HEADER, true);

        // EXEC STUFF
        $curlResponse = curl_exec($curl);

        // RESPONSE STUFF
        // get the http response code
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Get response header size
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $responseHeader = substr($curlResponse, 0, $headerSize);
        $responseBody = substr($curlResponse, $headerSize);

        // Get headers
        $headers = [];
        foreach (explode("\r\n", $responseHeader) as $line) {
            $parts = explode(':', $line, 2);

            if (count($parts) > 1) {
                $headers[trim($parts[0])][] = isset($parts[1])
                    ? trim($parts[1])
                    : null;
            }
        }

        $this->responseCode = $responseCode;
        $this->responseHeaders = $headers;
        $this->responseBody = $responseBody;

        // FINISH STUFF
        // Get the error so we can check how the exec went
        $error = curl_error($curl);
        curl_close($curl);
    }

    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }
}
