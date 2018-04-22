<?php

echo "Название: {$book->getName()}".PHP_EOL;
echo "Автор: ";
foreach ($book->getAuthors() as $author)
    echo $author;
echo PHP_EOL;
echo "Издательство: {$book->getPublisher()}".PHP_EOL;
echo "Год издания: {$book->getDatePublished()}";
