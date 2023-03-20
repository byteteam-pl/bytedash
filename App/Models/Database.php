<?php

namespace Byte;

/**
 * Database Controller of connection
 */
class Database
{
    /**
     * Creating MySQLi Connection
     *
     * @param array $config
     * 
     * @return object
     * 
     */
    public static function CreateConnection($config)
    {
        return mysqli_connect($config['database']['ip'], $config['database']['user'], $config['database']['password'], $config['database']['name']);
    }
    /**
     * Executing MySQL query into database
     *
     * @param string $sql
     * @param array $config
     * 
     * @return object
     * 
     */
    public static function Query($sql, $config)
    {
        $conn = Database::CreateConnection($config);
        return $conn->query($sql);
    }
}
