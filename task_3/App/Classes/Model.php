<?php
declare(strict_types=1);

namespace App\Classes;

class Model
{
    /** @var string $table */
    protected $table;
    /** @var \mysqli $connection */
    protected $connection = null;

    /**
     * @param \mysqli $connection
     */
    public function setConnection(\mysqli $connection): void
    {
        $this->connection = $connection;
    }

    /**
     * @return \mysqli|null
     */
    public function getConnection(): ?\mysqli
    {
        return $this->connection;
    }
}
