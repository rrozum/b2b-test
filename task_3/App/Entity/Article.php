<?php
declare(strict_types=1);

namespace App\Entity;

use App\Classes\Model;

/**
 * Class Article
 * @package App\Entity
 */
class Article extends Model
{
    /** @var string $table */
    protected $table = 'articles';

    /** @var string$title */
    protected $title;

    /** @var int $authorId */
    protected $authorId;

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * Сохранаяет модель в бд
     * @return bool
     */
    public function save(): bool
    {
        $stmt = $this->connection
            ->prepare("INSERT INTO {$this->table} (author_id, title) values (?, ?)");

        $stmt->bind_param('is', $this->authorId, $this->title);

        return $stmt->execute();
    }

    /**
     * @param int $id
     * @return int|null
     */
    public function getAuthorById(int $id): ?int
    {
        $stmt = $this->connection
            ->prepare("SELECT author_id FROM {$this->table} WHERE id=?");

        $stmt->bind_param('i', $id);

        $stmt->execute();
        $object = $stmt->get_result()->fetch_object();

        $authorId = (int)$object->author_id ?? null;

        $this->authorId = $authorId;

        return $authorId;
    }

    /**
     * @param int $articleId
     * @param int $authorId
     * @return bool
     */
    public function updateAuthorId(int $articleId, int $authorId): bool
    {
        $stmt = $this->connection
            ->prepare("UPDATE {$this->table} SET author_id=? WHERE id=?");
        $stmt->bind_param('ii', $authorId, $articleId);

        $this->authorId = $authorId;

        return $stmt->execute();
    }
}
