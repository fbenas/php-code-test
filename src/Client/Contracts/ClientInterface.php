<?php

namespace PhpCodeTest\Client\Contracts;

/**
 * Interface for creating a new client
 *
 * @author Phil Burton <phil@pgburton.com>
 */
interface ClientInterface
{
    public function request(string $method, string $uri);
}
