<?php

namespace PhpCodeTest\Model;

use PhpCodeTest\Client\Factory as ClientFactory;
use PhpCodeTest\Query\QueryFactory;
use PhpCodeTest\Query\QueryFactoryInterface;
use PhpCodeTest\Query\QueryInterface;
use StdClass;

abstract class Model implements ModelInterface
{
    protected $query;

    protected $endpoint;

    public function __construct(string $endpoint)
    {
        return $this->endpoint = $endpoint;
    }

    public function getQueryFactory(): QueryFactoryInterface
    {
        return new QueryFactory;
    }

    public function getQuery(): QueryInterface
    {
        if (!$this->query) {
            $this->query = (new QueryFactory())->createQuery();
        }

        return $this->query;
    }

    public function createFromQuery(QueryInterface $query)
    {
        $url = $this->endpoint . $query->toString();
        $httpClient = (new ClientFactory)->createClient();

        $result;
        try {
            $result = $httpClient->getParsed($url);
        } catch (ClientException $e) {
            throw new ModelException('Failed to create from query - ' . $e->getMessage());
        }

        // Handle hydrating module from response
        return $this->createFromStdClass($result);
    }

    public function createFromStdClass(StdClass $std)
    {
        $array = [];
        foreach ($std as $result) {
            $array[] = [
                'title' => (string) $result->book->name,
                'author' => (string) $result->book->author_name,
                'isbn' => (int) $result->book->isbn_number,
                'stock' => (int) $result->book->stock->number,
                'price' => (float) $result->book->stock->unit_price,
            ];
        }
        return $this->createFromArray($array[0]);
    }

    public function createFromArray(array $array)
    {
        $clone = clone $this;

        foreach ($array as $key => $item) {
            $clone->{'set' . ucfirst($key)}($item);
        }

        return $clone;
    }
}
