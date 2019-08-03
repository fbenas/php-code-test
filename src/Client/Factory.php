<?php

namespace PhpCodeTest\Client;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use PhpCodeTest\Client\Handler\Factory as HandlerFactory;
use PhpCodeTest\Client\Http;
use PhpCodeTest\Client\Contracts\ClientInterface;
use PhpCodeTest\Client\Contracts\ClientFactoryInterface;
use PhpCodeTest\Client\Contracts\ParserInterface;
use PhpCodeTest\Client\Contracts\HandlerFactoryInterface;
use PhpCodeTest\Client\Parser\Json;
use PhpCodeTest\Client\Parser\Xml;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * A factory class for creating a request, a response, a http client and/or a Handler Factory
 *
 * @author Phil Burton <phil@pgburton.com>
 */
class Factory implements ClientFactoryInterface
{
    /**
     * Create and return a new request
     *
     * @param string $method
     * @param string $uri
     * @return GuzzleHttp\Psr7\Request
     * @author Phil Burton <phil@pgburton.com>
     */
    public function createRequest(string $method, string $uri): RequestInterface
    {
        return new Request($method, $uri);
    }

    /**
     * Create and return a new response
     *
     * @param int $code
     * @param array $headers
     * @param string $body
     * @return GuzzleHttp\Psr7\Response
     * @author Phil Burton <phil@pgburton.com>
     */
    public function createResponse(int $code, array $headers, string $body): ResponseInterface
    {
        return new Response($code, $headers, $body);
    }

    /**
     * Create and return a new client
     *
     * @return PhpCodeTest\Client\Http
     * @author Phil Burton <phil@pgburton.com>
     */
    public function createClient(string $format = 'json'): ClientInterface
    {
        return (new Http)
            ->setHandler($this->createHandlerFactory()->createHandler())
            ->setParser($this->createParser($format));
    }

    /**
     * Create and return a new Handler Factory
     *
     * @return PhpCodeTest\Client\Handler\Factory
     * @author Phil Burton <phil@pgburton.com>
     */
    public function createHandlerFactory(): HandlerFactoryInterface
    {
        return new HandlerFactory;
    }

    public function createParser(string $format = 'json'): ParserInterface
    {
        if ($format == 'json') {
            return new Json;
        } elseif ($format == 'xml') {
            return new Xml;
        } else {
            throw new FactoryException('Format not supported: ' . $format);
        }
    }
}
