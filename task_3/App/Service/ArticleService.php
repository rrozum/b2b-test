<?php
declare(strict_types=1);

namespace App\Service;

use App\Collection\ArticleCollection;
use App\Entity\Article;
use App\Entity\User;

class ArticleService
{
    /** @var \mysqli $connection */
    protected $connection;

    /**
     * ArticleService constructor.
     * @param \mysqli $connection
     */
    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Создать статью
     * @param int $userId
     * @return bool
     */
    public function createNewArticle(int $userId): bool
    {
        $user = new User($userId);

        $article = $user->createArticle('New art ' . rand(0, 100));

        $article->setConnection($this->connection);

        return $article->save();
    }

    /**
     * Получить все статьи пользователя
     * @param int $authorId
     * @return array|null
     */
    public function getArticlesByAuthorId(int $authorId): ?array
    {
        $articleCollectoin = new ArticleCollection();
        $articleCollectoin->setConnection($this->connection);

        return $articleCollectoin->getArticlesByUserId($authorId);
    }

    /**
     * Получить автора статьи
     * @param int $id
     * @return int
     */
    public function getAuthorByArticleId(int $id): int
    {
        $article = new Article();
        $article->setConnection($this->connection);

        return $article->getAuthorById($id);
    }

    /**
     * Изменить автора статьи
     * @param int $articleId
     * @param int $authorId
     * @return bool
     */
    public function changeAuthorForArticle(int $articleId, int $authorId): bool
    {
        $article = new Article();
        $article->setConnection($this->connection);

        return $article->updateAuthorId($articleId, $authorId);
    }
}
