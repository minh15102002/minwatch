<?php

class Order {
    public $customer_id, $recipient_name, $recipient_address, $recipent_phone, $note, $total_price, $status;

    public static function saveOrder($pdo, $customer_id, $recipient_name, $recipient_address,
    $recipent_phone, $note, $total_price, $status, $payment_method) {
        $sql = "INSERT INTO `order`(customer_id, recipient_name,recipient_address, recipient_phone, note, total_price, status, payment_method)
        VALUES(:customer_id, :recipient_name, :recipient_address, :recipent_phone, :note,:total_price, :status, :payment_method);";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(":recipient_name", $recipient_name, PDO::PARAM_STR);
        $stmt->bindParam(":recipient_address", $recipient_address, PDO::PARAM_STR);
        $stmt->bindParam(":recipent_phone", $recipent_phone, PDO::PARAM_STR);
        $stmt->bindParam(":note", $note, PDO::PARAM_STR);
        $stmt->bindParam(":total_price", $total_price, PDO::PARAM_INT);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        $stmt->bindParam(":payment_method", $payment_method, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Order");
            // return $stmt->fetch();
            return $pdo->lastInsertId();
        }
    }

    public static function getAll($pdo, $limit, $offset) {
        $sql = "SELECT * FROM `order` LEFT JOIN user ON customer_id = id
        ORDER BY order_id DESC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);


        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Order");
            return $stmt->fetchAll();
        }
    }

    public static function getTotalOrder($pdo, $order_id) {
        $sql = "SELECT total_price FROM `order` WHERE order_id=:order_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Order");
            return $stmt->fetchColumn();
        }
    }

    public static function countAllOrder($pdo) {
        $sql = "SELECT COUNT(*) FROM `order`";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    // admin
    public static function updateStatus($pdo, $order_id, $status) {
        $sql = "UPDATE `order` SET status =:status WHERE order_id=:order_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);

        if($stmt->execute()){
            header("location:listOrder.php");
            return $stmt->fetch();
        }
    }

    public static function totalRevenue($pdo) {
        $sql = "SELECT SUM(total_price) FROM `order`";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    public static function totalOrder($pdo) {
        $sql = "SELECT COUNT(*) FROM `order`";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    public static function getDailyRevenue($pdo) {
        $sql = "SELECT DATE(order_date) as order_date, SUM(total_price) as daily_revenue
        FROM `order` GROUP BY  DATE(order_date) ORDER BY order_date";

        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}