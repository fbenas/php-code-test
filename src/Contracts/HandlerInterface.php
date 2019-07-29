<?php

namespace PhpCodeTest\Contracts;

use PhPCodeTest\Contracts\HandlerInterface;

interface HandlerInterface
{
    public function request(string $method, string $uri);

    public function getResponseCode(): int;

    public function getResponseBody(): string;

    public function getResponseHeaders(): array;
}
