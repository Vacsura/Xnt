<?php
namespace Xnt\Database;

class Statement
{
    /** @var \PDO */
    protected $connection;

    /**
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param string $sql    SQL statement
     * @param array $vars    optional, default value: array()
     * @param array $types   optional, default value: array()
     * @throws \PDOException
     * @return \PDOStatement prepared and executed statement
     */
    public function execute($sql, array $vars = array(), array $types = array())
    {
        $statement = $this->connection->prepare($sql);
        $this->bindValuesToStatement($statement, $vars, $types);
        $statement->execute($vars);
        return $statement;
    }

    /**
     * @param \PDOStatement $sql
     * @param array $vars        optional, default value: array()
     * @param array $types       optional, default value: array()
     */
    private function bindValuesToStatement(
        \PDOStatement $statement,
        array $vars = array(),
        array $types = array()
    ) {
        foreach ($vars as $key => $value) {
            $type = array_key_exists($key, $types) ? $types[$key] : \PDO::PARAM_STR;
            $statement->bindValue(":$key", $value, $type);
        }
    }
}

