<?php

include_once("Book.php");

class BookBuilder
{
    public $name;

    public $authors;

    public $publisher;

    public $datePublished;

    /**
     * @param string $name
     * @return BookBuilder
     */
    public function addName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $authors
     * @return BookBuilder
     */
    public function addAuthors($authors)
    {
        $this->authors = $authors;
        return $this;
    }

    /**
     * @param string $publisher
     * @return BookBuilder
     */
    public function addPublisher($publisher)
    {
        $this->publisher = $publisher;
        return $this;
    }

    /**
     * @param string $datePublished
     * @return BookBuilder
     */
    public function addDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
        return $this;
    }

    /**
     * @return Book
     */
    public function build(): Book
    {
        return new Book($this);
    }
}
