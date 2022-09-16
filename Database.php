<?php

class Database
{

    /**
     * @var PDO
     */
    protected PDO $pdo;

    protected function connection()
    {
        $servername = "localhost";
        $database = "ledi";
        $username = "root";
        $password = "root";

        try {
            $this->pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $pe) {
            die("Could not connect to the database  $database :" . $pe->getMessage());
        }
    }

}