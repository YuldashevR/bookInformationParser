<?php

include_once("Fb2Parser.php");
include_once("EpubParser.php");
include_once("Render.php");

if ($argc != 2) {
    echo "Неверное количество аргументов";
    exit;
}

$filePath = $argv[1];
$path = pathinfo($filePath);
$pathExt = $path['extension'];

if ($pathExt != 'fb2' && $pathExt != 'epub') {
    echo 'Неверный формат файла';
    exit;
}

$pathExt = ucfirst($pathExt);
$parserClass = "{$pathExt}Parser";

try {
    $parser = new $parserClass($filePath);
    $book = $parser->parse();
}
catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

Render::renderFile('bookView', ['book' => $book]);
?>
