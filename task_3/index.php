<?php
declare(strict_types=1);

require_once 'autoload.php';

use App\Classes\Database;
use App\Service\ArticleService;

$database = new Database('127.0.0.1', 'b2b', 'b2b', 'b2b_task');

$database->createNewMysqliConnection();

$connection = $database->getConnection();

// Сервис хранит логику работы со статьями
$articleServie = new ArticleService($connection);

// Создаем новую статью с id автора 5
$articleServie->createNewArticle(5);

// Получаем статьи автора с id 6
var_dump($articleServie->getArticlesByAuthorId(6));

// Получаем id автора по id статьи
var_dump($articleServie->getAuthorByArticleId(5));

// Изменяем автора у статьи с id 4 на автора с id 6
$articleServie->changeAuthorForArticle(4, 6);
