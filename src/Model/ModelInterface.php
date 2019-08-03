<?php

namespace PhpCodeTest\Model;

use PhpCodeTest\Query\QueryFactoryInterface;

interface ModelInterface
{
    public function getQueryFactory(): QueryFactoryInterface;
}
