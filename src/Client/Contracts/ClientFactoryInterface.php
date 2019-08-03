<?php

namespace PhpCodeTest\Client\Contracts;

use PhpCodeTest\Client\Contracts\ClientInterface;
use PhpCodeTest\Client\Contracts\HandlerFactoryInterface;
use PhpCodeTest\Client\Contracts\ParserInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface for a factory that handles creating client related concretes
 *
 * @author Phil Burton <phil@pgburton.com>
 */
interface ClientFactoryInterface
{
    public function createRequest(string $method, string $uri): RequestInterface;
    public function createResponse(int $code, array $headers, string $body): ResponseInterface;
    public function createClient(): ClientInterface;
    public function createHandlerFactory(): HandlerFactoryInterface;
    public function createParser(string $format = 'json'): ParserInterface;
}
