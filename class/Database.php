<?php
class Database {
    public function getConnect() {
        $host = "sql205.infinityfree.com";
        $db = "if0_38102155_db_min_watch";
        $username = "if0_38102155";
        $password = "56viiIaFj9";

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
