<?php

class EpubParser implements Parser
{
    const EXT_OPF = "opf";
    const AUTHOR = "creator";
    const BOOK_NAME = "title";
    const PUBLISHER = "publisher";
    const DATE_PUBLISHED = "date";

    private $zip;

    private $doc;

    /**
     * epubParser constructor.
     *
     */
    public function __construct($filePath)
    {
        $this->zip = zip_open($filePath);
        if (is_int($this->zip)) {
            throw new Exception("Ошибка при открытии файла");
        }
        $this->doc = new DOMDocument();
    }

    /** Формирует XML строку из OPF файла
     * @return string
     */
    private function findXML()
    {
        $xml = '';
        while ($zip_entry = zip_read($this->zip)) {
            $zip_entry_name = zip_entry_name($zip_entry);
            $path_info = pathinfo($zip_entry_name);
            if (isset($path_info['extension'])) {
                if ($path_info['extension'] == self::EXT_OPF) {
                    while($zip_content = zip_entry_read($zip_entry)){
                        $xml .= $zip_content;
                    }
                    zip_entry_close($zip_entry);
                    break;
                }
            }
        }
        return $xml;
    }

    /** Получение названия книги
     * @return string
     */
    private function parseBookName()
    {
        return $this->doc->getElementsByTagName(self::BOOK_NAME)->item(0)->nodeValue;
    }

    /** Возвращает список авторов
     * @return array
     */
    private function parseAuthors()
    {
        return array($this->doc->getElementsByTagName(self::AUTHOR)->item(0)->nodeValue);
    }

    /** Получние года издания
     * @return string
     */
    private function parsePublishDate()
    {
        return $this->doc->getElementsByTagName(self::DATE_PUBLISHED)->item(0)->nodeValue;
    }

    /** Получение названия Издательства
     * @return string
     */
    private function parsePublisher()
    {
        return $this->doc->getElementsByTagName(self::PUBLISHER)->item(0)->nodeValue;
    }

    /** Парсер
     * @return Book
     */
    public function parse()
    {
        $xml = $this->findXML();
        $this->doc->loadXML($xml);
        return (new BookBuilder)
                    ->addName($this->parseBookName())
                    ->addAuthors($this->parseAuthors())
                    ->addPublisher($this->parsePublisher())
                    ->addDatePublished($this->parsePublishDate())
                    ->build();
    }
}
