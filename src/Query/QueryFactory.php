<?php

namespace PhpCodeTest\Query;

use PhpCodeTest\Query\Query;

/**
 * Factoy for query
 *
 * @author Phil Burton <phil@d3r.com>
 */
class QueryFactory implements QueryFactoryInterface
{
    /**
     * Create and return instance of query
     *
     * @return QueryInterface
     * @author Phil Burton <phil@pgburton.com>
     */
    public function createQuery(): QueryInterface
    {
        return new Query;
    }
}
