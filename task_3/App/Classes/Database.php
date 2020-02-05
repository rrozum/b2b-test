<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Class Database
 * @package App\Classes
 */
class Database
{
    /** @var string $host */
    protected $host;
    /** @var string $userName */
    protected $userName;
    /** @var string $password */
    protected $password;
    /** @var string $dbname */
    protected $dbname;
    /** @var int $port */
    protected $port;
    /** @var \mysqli|null $connection */
    protected $connection = null;

    /**
     * Database constructor.
     * @param string $host
     * @param string $userName
     * @param string $password
     * @param string $dbname
     * @param int $port
     */
    public function __construct(string $host, string $userName, string $password, string $dbname, int $port = 3306)
    {
        $this->host = $host;
        $this->userName = $userName;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->port = $port;
    }

    /**
     * Создает новое подключение к бд, закрывая старое
     * @return \mysqli
     */
    public function createNewMysqliConnection(): \mysqli
    {
        if (!empty($this->connection)) {
            $this->connection->close();
        }

        $this->connection = new \mysqli($this->host, $this->userName, $this->password, $this->dbname, $this->port);

        return $this->connection;
    }

    /**
     * @return \mysqli|null
     */
    public function getConnection(): ?\mysqli
    {
        return $this->connection;
    }
}
