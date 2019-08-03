<?php

namespace PhpCodeTest\Query;

use PhpCodeTest\Query\Query;

class QueryFactory
{
    public function createQuery(): QueryInterface
    {
        return new Query;
    }
}
