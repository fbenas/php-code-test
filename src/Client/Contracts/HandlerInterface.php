<?php

namespace PhpCodeTest\Client\Contracts;

use Psr\Http\Message\RequestInterface;

/**
 * Interface for creating a handler
 *
 * @author Phil Burton <phil@pgburton.com>
 */
interface HandlerInterface
{
    public function request(RequestInterface $request);
}
