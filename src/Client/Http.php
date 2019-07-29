<?php

namespace PhpCodeTest\Client;

use GuzzleHttp\Psr7\Response;
use PhpCodeTest\Contracts\ClientInterface;
use PhpCodeTest\Contracts\HandlerInterface;
use PhpCodeTest\Contracts\ModelInterface;
use Psr\Http\Message\RequestInterface;

class Http implements ClientInterface
{
    protected $handler;

    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function get(RequestInterface $request)
    {
        $this->handler->request($request->getMethod(), $request->getUri());

        $response = new Response(
            $this->handler->getResponseCode(),
            $this->handler->getResponseHeaders(),
            $this->handler->getResponseBody()
        );

        return (string) $response->getBody();
    }

    public function create(ModelInterface $model)
    {
        var_dump("not implemented");
        die();
    }

    public function delete(RequestInterface $query)
    {
        var_dump("not implemented");
        die();
    }

    public function update(RequestInterface $query, ModelInterface $model)
    {
        var_dump("not implemented");
        die();
    }
}
