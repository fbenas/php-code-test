<?php

namespace PhpCodeTest\Library;

use PhpCodeTest\Model\Model;

class Book extends Model
{
    protected $author;
    protected $title;
    protected $publisher;
    protected $stock;
    protected $isbn;
    protected $price;

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher)
    {
        $this->publisher = $publisher;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(string $stock)
    {
        $this->stock = $stock;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn)
    {
        $this->isbn = $isbn;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(string $price)
    {
        $this->price = $price;
    }
}
