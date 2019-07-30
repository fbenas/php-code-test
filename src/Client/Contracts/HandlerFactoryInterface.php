<?php

namespace PhpCodeTest\Client\Contracts;

use PhpCodeTest\Client\Contracts\HandlerInterface;

/**
 * Inteface for creating a factory for handlers
 *
 * @author Phil Burton <phil@pgburton.com>
 */
interface HandlerFactoryInterface
{
    public function createHandler(): HandlerInterface;
}
