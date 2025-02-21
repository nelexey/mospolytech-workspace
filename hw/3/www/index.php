<?php

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../src/' . str_replace('\\', '/', $className) . '.php';
});

$author = new \MyProject\Models\Users\User('Васёк');
$article = new \MyProject\Models\Articles\Article('Заголовок', 'Текст', $author);

var_dump($article); 