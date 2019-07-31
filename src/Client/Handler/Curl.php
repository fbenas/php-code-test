<?php

namespace PhpCodeTest\Client\Handler;

use PhpCodeTest\Client\Contracts\HandlerInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Use curl to make HTTP requests
 *
 * @author Phil Burton <phil@pgburton.com>
 */
class Curl implements HandlerInterface
{
    /**
     * HTTP response code
     *
     * @var int
     */
    private $responseCode;

    /**
     * Headers from response
     *
     * @var array
     */
    private $responseHeaders;

    /**
     * Body of response
     *
     * @var string
     */
    private $responseBody;

    /**
     * Make a http request
     *
     * @param Psr\Http\Message\RequestInterface $request
     * @author Phil Burton <phil@pgburton.com>
     */
    public function request(RequestInterface $request)
    {
        // Curl initation
        $curl = curl_init();

        // Build request

        curl_setopt($curl, CURLOPT_URL, $request->getUri());
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);

        // Execute request
        $curlResponse = curl_exec($curl);

        // Build response
        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $responseHeader = substr($curlResponse, 0, $headerSize);
        $responseBody = substr($curlResponse, $headerSize);

        // Handle headers
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

        // Shutdown curl
        // $error = curl_error($curl);
        curl_close($curl);
    }

    /**
     * Return the http response code
     *
     * @return int
     * @author Phil Burton <phil@pgburton.com>
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    /**
     * Return the body of the http response
     *
     * @return string
     * @author Phil Burton <phil@pgburton.com>
     */
    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    /**
     * Return the http response headers
     *
     * @return array
     * @author Phil Burton <phil@pgburton.com>
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }
}
