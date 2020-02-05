<?php
declare(strict_types=1);

namespace App\Entity;

use App\Classes\Model;

/**
 * Class User
 * @package App\Entity
 */
class User extends Model
{
    protected $table = 'users';

    /** @var $id */
    protected $id;

    /**
     * User constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function createArticle(string $title): Article
    {
        $article =  new Article();
        $article->setAuthorId($this->id);
        $article->setTitle($title);

        return $article;
    }
}
