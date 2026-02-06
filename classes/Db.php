<?php
require_once("config.php");

class Db
{
    protected function connect()
    {
        try {
            $dsn = "mysql:host=" . DBSERVER . ";dbname=" . DBNAME;
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            $ayconn = new PDO($dsn, DBUSER, DBPASS, $options);
            return $ayconn;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
