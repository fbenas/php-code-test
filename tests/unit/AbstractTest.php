<?php

namespace PhpCodeTest\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PhpCodeTest\GetBookList;

/**
 * An abstract test case
 *
 * @author Phil Burton <phil@pgburton.com>
 */
abstract class AbstractTest extends TestCase
{
    protected $instances = [];

    /**
     * Create and return an instance of GetBookList
     *
     * @return PhpCodeTest\GetBookList
     * @author Phil Burton <phil@pgburton.com>
     */
    protected function getNewInstance(string $format = null): GetBookList
    {
        if (!$format) {
            return new GetBookList;
        }

        return new GetBookList($format);
    }

    /**
     * Create new instace if required, returns the instance
     *
     * @param string $format
     * @return PhpCodeTest\GetBookList
     * @author Phil Burton <phil@pgburton.com>
     */
    protected function getInstance(string $format = null): GetBookList
    {
        if (!array_key_exists($format, $this->instances)) {
            $this->instances[$format] = $this->getNewInstance($format);
        }

        return $this->instances[$format];
    }

    /**
     * Invoke a method on an object
     * Uses reflection so we can bypass protected keywords and test all our class functions
     *
     * @param PhpCodeTest\GetBookList $object
     * @param string $methodName
     * @param array $parameters
     * @return mixed
     * @author Phil Burton <phil@pgburton.com>
     */
    protected function invokeMethod(GetBookList &$object, string $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
