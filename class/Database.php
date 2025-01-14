<?php
class Database {
    public function getConnect() {
        $host = "localhost";
        $db = "db_min_watch";
        $username = "root";
        $password = "";

        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try{
            $pdo = new PDO($dsn, $username, $password);
            if($pdo){
                return $pdo;
            }
        }catch(PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
