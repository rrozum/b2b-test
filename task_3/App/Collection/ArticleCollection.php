<?php
declare(strict_types=1);

namespace App\Collection;

use App\Classes\Model;

class ArticleCollection extends Model
{
    protected $table = 'articles';

    /**
     * @param int $userId
     * @return array|null
     */
    public function getArticlesByUserId(int $userId): ?array
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE author_id=?");
        $stmt->bind_param('i', $userId);

        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return is_array($result) ? $result : null;
    }
}
