<?php

namespace PhpCodeTest\Client\Handler;

use PhpCodeTest\Client\Handler\Curl;
use PhpCodeTest\Client\Contracts\HandlerFactoryInterface;
use PhpCodeTest\Client\Contracts\HandlerInterface;

/**
 * A Factory for creating a Curl handler
 *
 * @author Phil Burton <phil@pgburton.com.com>
 */
class Factory implements HandlerFactoryInterface
{
    /**
     * Create and return a Curl handler
     *
     * @return PhpCodeTest\Contracts\HandlerInterface
     * @author Phil Burton <phil@pgburton.com>
     */
    public function createHandler(): HandlerInterface
    {
        return new Curl;
    }
}
