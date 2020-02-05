<?php
declare(strict_types=1);

class Users
{
    /** @var Database $db */
    protected $db;
    /** @var string $userIds */
    protected $userIds;

    /**
     * Users constructor.
     * @param Database $db
     * @param string $userIds
     */
    public function __construct(Database $db, string $userIds)
    {
        $this->db = $db;
        $this->userIds = $userIds;
    }

    /**
     * @return array
     */
    public function loadUsersData(): array
    {
        $userIdsArray = explode(',', $this->userIds);

        $userIdsArray = $this->prepareUserIds($userIdsArray);

        $userIdsCount = count($userIdsArray);

        $in = str_repeat('?, ', $userIdsCount - 1) . '?';
        $sql = "SELECT `id`, `name` FROM `users` WHERE id IN ($in)";

        $connection = $this->db->getMysqliConnection();

        $stmt = $connection->prepare($sql);
        $types = str_repeat('i', $userIdsCount);

        $stmt->bind_param(
            $types,
            ...$userIdsArray
        );

        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $connection->close();

        return $result;
    }

    /**
     * @param array $userIds
     * @return array
     */
    protected function prepareUserIds(array $userIds): array
    {
        $userIds = array_map('intval', $userIds);
        $userIds = array_unique($userIds);

        return $userIds;
    }
}
