<?php

namespace PhpCodeTest\Client;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use PhpCodeTest\Client\Contracts\ClientInterface;
use PhpCodeTest\Client\Contracts\HandlerInterface;
use PhpCodeTest\Client\Contracts\ParserInterface;
use PhpCodeTest\Client\Handler\CurlException;
use PhpCodeTest\Client\Factory;
use PhpCodeTest\Client\ClientException;
use PhpCodeTest\Client\Parser\ParserException;
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
     * @var PhpCodeTest\Client\Contracts\HandlerInterface
     */
    protected $handler;

    /**
     * Object that will do the heavy lifiting
     *
     * @var PhpCodeTest\Client\Contracts\ParserInterface
     */
    protected $parser;

    protected $response;

    /**
     * Set the hander solid on this client
     *
     * @param PhpCodeTest\Client\Contracts\HandlerInterface $handler
     * @author Phil Burton <phil@pgburton.com>
     */
    public function setHandler(HandlerInterface $handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Set the parser solid on this client
     *
     * @param PhpCodeTest\Client\Contracts\Parser $parser
     * @author Phil Burton <phil@pgburton.com>
     */
    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;

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
            throw new ClientException('Handler failed: ' . $e->getMessage());
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

        $this->response = (new Factory)->createResponse($code, $headers, $body);

        return $this->response;
    }

    public function getParsed(string $uri)
    {
        try {
            $response = $this->get($uri);
            return $this->parseResponse($this->response->getBody());
        } catch (ParserException $e) {
            throw new ClientException('Failed to parse response - ' . $e->getMessage());
        }
    }

    private function parseResponse(string $body)
    {
        try {
            return $this->parser->parse($body);
        } catch (ParserException $e) {
            throw new ClientException('Failed to parse response - ' . $e->getMessage());
        }
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
}
