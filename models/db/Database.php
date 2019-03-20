<?php

namespace models\db;

use PDO;

class Database
{
    private $_connection;

    private static $_db;

    /**
     * Create connection to db, used PDO
     *
     * @param array $config
     */
    private function __construct($config)
    {
        $host = $config['host'] ?: '';
        $username = $config['username'] ?: '';
        $password = $config['password'] ?: '';
        $dbname = $config['dbname'] ?: '';
        $charset = $config['charset'] ?: '';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

        $this->_connection = new PDO($dsn, $username, $password);
    }

    /**
     * Return connection to database
     *
     * @return self
     */
    public static function getConnection()
    {
        if (!self::$_db) {
            self::$_db = new self(CONFIGS['db']);
        }

        return self::$_db;
    }

    /**
     * Prepare and execute query
     *
     * @param string $sql
     * @param array $condition
     * @return array
     */
    public function exec($sql, $condition)
    {
        $statement = $this->_connection->prepare($sql);
        $statement->execute($condition);

        return $statement->fetchAll();
    }
}