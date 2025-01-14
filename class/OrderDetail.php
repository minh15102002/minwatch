<?php

class OrderDetail {
    // tất cả đơn hàng của khách hàng đó
    public static function getOrderCustomer($pdo ,$customer_id){
        $sql = "SELECT * FROM `order` WHERE customer_id=:customer_id ORDER BY order_id DESC";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "OrderDetail");
            return $stmt->fetchAll();
        }
    }

    // lấy 1 đơn hàng của khách hàng đó
    public static function getOneOrder($pdo, $customer_id, $order_id) {
        $sql = "SELECT o.order_id, p.product_id, p.product_image, b.brand_id, b.brand_name,
        p.product_name, p.product_price, price, status, d.quantity FROM order_detail d, `order` o, product p, brand b WHERE d.order_id = o.order_id
        and p.product_id = d.product_id and b.brand_id = p.brand_id and customer_id=:customer_id and o.order_id=:order_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "OrderDetail");
            return $stmt->fetchAll();
        }
    }
    
    public static function saveOrderDetail($pdo, $order_id, $product_id, $quantity, $price) {
        $sql = "INSERT INTO order_detail(order_id, product_id, quantity, price)
        VALUES(:order_id, :product_id, :quantity, :price)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);
        $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
        $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "OrderDetail");
            return $stmt->fetch();
        }
    }

    public static function getInfoCartItem($pdo, $customer_id) {
        $sql = "SELECT * FROM cart WHERE customer_id=:customer_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "OrderDetail");
            return $stmt->fetchAll();
        }
    }

    public static function getOrderDetail($pdo ,$order_id){
        $sql = "SELECT o.order_id, p.product_id, p.product_name, quantity, price FROM `order` o, order_detail d, product p
        WHERE o.order_id=:order_id and o.order_id = d.order_id and p.product_id = d.product_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "OrderDetail");
            return $stmt->fetchAll();
        }
    }

    // admin
    public static function getOrder($pdo, $order_id) {
        $sql = "SELECT * FROM `order`WHERE order_id =:order_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "OrderDetail");
            return $stmt->fetch();
        }
    }

    public static function getInfoCustomer($pdo,$order_id) {
        $sql = "SELECT * FROM `order` LEFT JOIN user ON customer_id = id
        WHERE order_id=:order_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":order_id", $order_id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "OrderDetail");
            return $stmt->fetch();
        }
    }
}