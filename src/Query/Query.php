<?php

namespace PhpCodeTest\Query;

use PhpCodeTest\Query\QueryInterface;

class Query implements QueryInterface
{
    protected $params;

    public function __construct()
    {
        $this->params = [];
        $this->setDefaults();
    }

    protected function setDefaults()
    {
        $this->params['limit'] = 10;
    }

    public function toString(): string
    {
        $string = '';
        foreach ($this->params as $key => $param) {
            $string .= '&' . $key . '=' . $param;
        }

        return '?' . ltrim($string, '&');
    }

    public function setParam(string $param, $data)
    {
        $this->params[$param] = $data;

        return $this;
    }

    public function getParam(string $param)
    {
        if (!array_key_exists($param, $this->params)) {
            return false;
        }

        return $this->params[$param];
    }
}
