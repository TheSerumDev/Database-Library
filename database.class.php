<?php

namespace Library\Base;

use PDO;

class Database
{
    private $connection;

    function __construct($host, $port = 3306, $user = "root", $password = "", $database = "")
    {
        $options = array(
            PDO::ATTR_TIMEOUT => 10,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        $this->connection = new PDO("mysql:host=$host;port=$port;dbname=$database", $user, $password, $options);
        $this->tableMatrix();
    }

    private function tableMatrix()
    {
        $this->invokeCommand("CREATE TABLE IF NOT EXISTS test(firstName VARCHAR(256), lastName VARCHAR(256), email VARCHAR(256));");
    }

    public function writeNow($table, $columns = array(), $values = array())
    {
        $parameters = "";

        for ($i = 0; $i < count($values); $i++) {
            $parameters .= "?, ";
        }

        if ($this->endsWith($parameters, ", ")) {
            $parameters = substr_replace($parameters, "", -2);
        }

        $columnResult = "";

        foreach ($columns as $column) {
            $columnResult .= $column . ', ';
        }

        if ($this->endsWith($columnResult, ", ")) {
            $columnResult = substr_replace($columnResult, "", -2);
        }

        $this->connection->prepare("INSERT INTO $table($columnResult) VALUES($parameters);")->execute($values);
    }

    public function delete($table, $key, $value)
    {
        $statement = $this->connection->prepare("DELETE FROM $table WHERE $key=?");
        $statement->execute(array($value));
    }

    public function queryAll($table)
    {
        $statement = $this->connection->prepare("SELECT * FROM $table");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function query($table, $key, $value)
    {
        $statement = $this->connection->prepare("SELECT * FROM $table WHERE $key=?");
        $statement->execute(array($value));
        return $statement->fetch();
    }

    public function queryConditional($table, $key, $value, $key2, $value2)
    {
        $statement = $this->connection->prepare("SELECT * FROM $table WHERE $key=? AND $key2=?");
        $statement->execute(array($value, $value2));
        return $statement->fetchAll();
    }

    public function querySpecial($qry)
    {
        $statement = $this->connection->prepare($qry);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function queryLength($table)
    {
        $statement = $this->connection->prepare("SELECT COUNT(*) FROM $table");
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function queryLengthWhere($table, $key, $value)
    {
        $statement = $this->connection->prepare("SELECT COUNT(*) FROM $table WHERE $key=?");
        $statement->execute(array($value));
        return $statement->fetchColumn();
    }

    public function queryLike($table, $key, $pattern)
    {
        $statement = $this->connection->prepare("SELECT * FROM $table WHERE $key LIKE ?");
        $statement->execute(array($pattern));
        return $statement->fetchAll();
    }

    private function invokeCommand($command)
    {
        $this->connection->exec($command);
    }

    private function endsWith($string, $search)
    {
        return strrpos($string, $search) === strlen($string) - strlen($search);
    }
}
