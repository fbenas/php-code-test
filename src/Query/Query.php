<?php

namespace PhpCodeTest\Query;

use PhpCodeTest\Query\QueryInterface;

/**
 * Query Concrete
 *
 * @author Phil Burton <phil@pgburton.com>
 */
class Query implements QueryInterface
{
    /**
     * Query params
     *
     * @var mixed[]
     */
    protected $params;

    /**
     * Construct and set defaults
     *
     * @author Phil Burton <phil@pgburton.com>
     */
    public function __construct()
    {
        $this->params = [];
        $this->setDefaults();
    }

    /**
     * Set default params
     *
     * @author Phil Burton <phil@pgburton.com>
     */
    protected function setDefaults()
    {
        $this->params['limit'] = 10;
    }

    /**
     * Convert query to string
     *
     * @return string
     * @author Phil Burton <phil@pgburton.com>
     */
    public function toString(): string
    {
        $string = '';
        foreach ($this->params as $key => $param) {
            $string .= '&' . $key . '=' . $param;
        }

        return '?' . ltrim($string, '&');
    }

    /**
     * Set a param
     *
     * @param string $param
     * @param $data
     * @author Phil Burton <phil@pgburton.com>
     */
    public function setParam(string $param, $data)
    {
        $this->params[$param] = $data;

        return $this;
    }
}
