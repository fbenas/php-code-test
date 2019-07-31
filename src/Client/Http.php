<?php

namespace PhpCodeTest\Client;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use PhpCodeTest\Client\Contracts\ClientInterface;
use PhpCodeTest\Client\Contracts\HandlerInterface;
use PhpCodeTest\Client\Handler\CurlException;
use PhpCodeTest\Client\Factory;
use PhpCodeTest\Client\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * An http Client
 * Uses a handler to do the heavy lifiting
 *
 * @author Phil Burton <phil@pgburton.com>
 */
class Http implements ClientInterface
{
    /**
     * Object that will do the heavy lifiting
     *
     * @var PhpCodeTest\Contracts\HandlerInterface
     */
    protected $handler;

    /**
     * Any extra error information
     *
     * @var string
     */
    protected $error;

    /**
     * Set the hander solid on this client
     *
     * @param PhpCodeTest\Contracts\HandlerInterface $handler
     * @author Phil Burton <phil@pgburton.com>
     */
    public function setHandler(HandlerInterface $handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Build a request and get the handler to make the request
     * Build and return a response
     *
     * @param string $method
     * @param string $uri
     * @return Psr\Http\Message\ResponseInterface
     * @author Phil Burton <phil@pgburton.com>
     */
    public function request(string $method, string $uri): ResponseInterface
    {
        // Build a request from the params
        $request = (new Factory)->createRequest($method, $uri);
        $this->handleRequest($request);
        $response = $this->getResponse();

        return $response;
    }

    /**
     * Transfer request to handler
     *
     * @param Psr\Http\Message\RequestInterface $request
     * @author Phil Burton <phil@pgburton.com>
     */
    protected function handleRequest(RequestInterface $request)
    {
        try {
            $this->handler->request($request);
        } catch (CurlException $e) {
            $this->error = 'Curl Exception: ' . $e->getMessage();
            throw new ClientException('Handler failed');
        }
    }

    /**
     * Build and return response from our handler
     *
     * @return Psr\Http\Message\ResponseInterface
     * @author Phil Burton <phil@pgburton.com>
     */
    protected function getResponse(): ResponseInterface
    {
        $code = $this->handler->getResponseCode();
        $headers = $this->handler->getResponseHeaders();
        $body = $this->handler->getResponseBody();

        return (new Factory)->createResponse($code, $headers, $body);
    }

    /**
     * Run a GET request
     *
     * @param string $uri
     * @return Psr\Http\Message\ResponseInterface
     * @author Phil Burton <phil@pgburton.com>
     */
    public function get(string $uri): ResponseInterface
    {
        return $this->request('GET', $uri);
    }

    /**
     * Return error string
     *
     * @return string
     * @author Phil Burton <phil@pgburton.com>
     */
    public function getError()
    {
        return $this->error;
    }
}
