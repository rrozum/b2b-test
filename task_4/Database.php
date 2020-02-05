<?php
declare(strict_types=1);

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

    public function getMysqliConnection(): mysqli
    {
        return new mysqli($this->host, $this->userName, $this->password, $this->dbname, $this->port);
    }
}
