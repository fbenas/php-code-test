<?php

namespace PhpCodeTest\Model;

use PhpCodeTest\Client\Factory as ClientFactory;
use PhpCodeTest\Query\QueryFactory;
use PhpCodeTest\Query\QueryFactoryInterface;
use PhpCodeTest\Query\QueryInterface;
use StdClass;

/**
 * Abstract base model class
 *
 * @author Phil Burton <phil@pgburton.com>
 */
abstract class Model implements ModelInterface
{
    /**
     * Query
     *
     * @var PhpCodeTest\Query\QueryInterface
     */
    protected $query;

    /**
     * URL endpoint
     *
     * @var string
     */
    protected $endpoint;

    /**
     * Constuct and set endpoint
     *
     * @param string $endpoint
     * @author Phil Burton <phil@pgburton.com>
     */
    public function __construct(string $endpoint)
    {
        return $this->endpoint = $endpoint;
    }

    /**
     * Create and return a query factory
     *
     * @return QueryFactoryInterface
     * @author Phil Burton <phil@pgburton.com>
     */
    public function getQueryFactory(): QueryFactoryInterface
    {
        return new QueryFactory;
    }

    /**
     * Create and/or return a query interface concrete
     *
     * @return QueryInterface
     * @author Phil Burton <phil@pgburton.com>
     */
    public function getQuery(): QueryInterface
    {
        if (!$this->query) {
            $this->query = $this->getQueryFactory()->createQuery();
        }

        return $this->query;
    }

    /**
     * Craete a Model from a query interface
     *
     * @param PhpCodeTest\Query\QueryInterface $query
     * @return PhpCodeTest\Model\ModelInterface
     * @author Phil Burton <phil@pgburton.com>
     */
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

        if (is_array($result)) {
            return $this->createFromArray($result);
        }

        return $this->createFromStdClass($result);
    }

    /**
     * Create Model from stdClass
     *
     * @param StdClass $std
     * @return PhpCodeTest\Query\QueryInterface
     * @author Phil Burton <phil@pgburton.com>
     */
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

    /**
     * Create Model from array
     *
     * @param array $array
     * @return PhpCodeTest\Query\QueryInterface
     * @author Phil Burton <phil@pgburton.com>
     */
    public function createFromArray(array $array)
    {
        $clone = clone $this;

        foreach ($array as $key => $item) {
            $clone->{'set' . ucfirst($key)}($item);
        }

        return $clone;
    }
}
