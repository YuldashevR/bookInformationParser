<?php

class Book
{

    private $name;

    private $authors;

    private $publisher;

    private $datePublished;

    /**
     * Book constructor.
     * @param BookBuilder $bookBuilder
     */
    public function __construct(BookBuilder $bookBuilder)
    {
        $this->name = $bookBuilder->name;
        $this->authors = $bookBuilder->authors;
        $this->publisher = $bookBuilder->publisher;
        $this->datePublished = $bookBuilder->datePublished;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * @param string $authors
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }

    /**
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @return string
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * @param string $datePublished
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;
    }
}
