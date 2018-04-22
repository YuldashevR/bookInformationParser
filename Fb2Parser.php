<?php

include_once("BookBuilder.php");
include_once("Parser.php");

class Fb2Parser implements Parser
{
    const AUTHOR = "author";
    const AUTHOR_FIRST_NAME = "first-name";
    const AUTHOR_LAST_NAME = "last-name";
    const AUTHOR_MIDDLE_NAME = "middle-name";
    const BOOK_NAME = "book-title";
    const PUBLISHER = "publisher";
    const DATE_PUBLISHED = "year";
    const TITLE = "title-info";
    const PUBLISH = "publish-info";

    private $doc;

    private $title;

    private $publish;

    /**
     * Parser constructor.
     *
     */
    public function __construct($filePath)
    {
        $this->doc = new DOMDocument();
        if (!$this->doc->load($filePath)) {
            throw new Exception("Ошибка при открытии файла");
        }
    }

    /** Получение ФИО автора
     * @param $author
     * @return string
     */
    private function getAuthorName($author)
    {
        $name = '';
        $partName = $author->getElementsByTagName($this::AUTHOR_FIRST_NAME)->item(0)->nodeValue;
        $name .= $partName ? "{$partName} " : '';
        $partName = $author->getElementsByTagName($this::AUTHOR_LAST_NAME)->item(0)->nodeValue;
        $name .= $partName ? "{$partName} " : '';
        $partName = $author->getElementsByTagName($this::AUTHOR_MIDDLE_NAME)->item(0)->nodeValue;
        $name .= $partName ? $partName : '';
        return $name;
    }

    /** Получение названия книги
     * @return string
     */
    private function parseBookName()
    {
        return $this->title->getElementsByTagName(self::BOOK_NAME)->item(0)->nodeValue;
    }

    /** Возвращает список авторов
     * @return array|null
     */
    private function parseAuthors()
    {
        $authorsNode = $this->title->getElementsByTagName(self::AUTHOR);
        $authors = [];
        if (empty($authorsNode))
        {
            return null;
        }
        foreach ($authorsNode as $author)
        {
            $authors[] = $this->getAuthorName($author);
        }
        return $authors;
    }

    /** Получние года издания
     * @return string
     */
    private function parsePublishDate()
    {
        return $this->publish->getElementsByTagName(self::DATE_PUBLISHED)->item(0)->nodeValue;
    }

    /** Получение названия Издательства
     * @return string
     */
    private function parsePublisher()
    {
        return $this->publish->getElementsByTagName(self::PUBLISHER)->item(0)->nodeValue;
    }

    /** Парсер
     * @return Book
     */
    public function parse()
    {
        $this->title = $this->doc->getElementsByTagName(self::TITLE)->item(0);
        $this->publish = $this->doc->getElementsByTagName(self::PUBLISH)->item(0);
        return (new BookBuilder)
                        ->addName($this->parseBookName())
                        ->addAuthors($this->parseAuthors())
                        ->addPublisher($this->parsePublisher())
                        ->addDatePublished($this->parsePublishDate())
                        ->build();
    }
}
