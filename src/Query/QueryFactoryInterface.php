<?php

namespace PhpCodeTest\Query;

use PhpCodeTest\Query\QueryInterface;

class QueryFactoryInterface
{
    protected function createQuery(): QueryInterface;
}
