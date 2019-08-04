<?php

namespace PhpCodeTest\Query;

use PhpCodeTest\Query\QueryInterface;

interface QueryFactoryInterface
{
    public function createQuery(): QueryInterface;
}
