<?php

namespace PhpCodeTest\Contracts;

use PhpCodeTest\Contracts\ModelInterface;
use Psr\Http\Message\RequestInterface;

interface ClientInterface
{
    public function get(RequestInterface $query);
    public function create(ModelInterface $model);
    public function delete(RequestInterface $query);
    public function update(RequestInterface $query, ModelInterface $model);
}
