<?php
    class Cart {
        public $customer_id, $product_id, $quantity, $price;

        public static function getAll($pdo, $customer_id) {
            $sql = "SELECT p.product_id, p.product_name, p.product_image, b.brand_id, b.brand_name, p.product_price, c.price, c.quantity FROM cart c, product p, brand b WHERE customer_id =:customer_id
            and p.product_id = c.product_id and p.brand_id = b.brand_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_STR);
    
            if($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart"); // Truy xuất và trả về dưới dạng một đối tượng của lớp Product
                return $stmt->fetchAll();
            }
        }

        // public static function addItemToCart($pdo, $customer_id, $product_id, $quantity = 1, $price) {
        //     $new_price = $price * $quantity;

        //     $sql = "INSERT INTO cart(customer_id, product_id, quantity, price)
        //     VALUES(:customer_id, :product_id, :quantity, :new_price)";
        //     $stmt = $pdo->prepare($sql);
    
        //     $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_STR);
        //     $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
        //     $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
        //     $stmt->bindParam(":new_price", $new_price, PDO::PARAM_INT);
    
        //     if($stmt->execute()){
        //         $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
        //         return $stmt->fetch();
        //     }
        // }
    
        // thêm và update
        public static function updateCartItem($pdo, $customer_id, $product_id, $quantity=1, $unit_price){
            // $new_price = $unit_price * $quantity;

            // nếu insert kh thành công (đã tồn tại pk), thì nó chuyển sang lệnh update trên key đó
            $sql = "INSERT INTO cart (customer_id, product_id, quantity, price)
            VALUES (:customer_id, :product_id, :quantity, :unit_price)
            ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_STR);
            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
            // $stmt->bindParam(":new_price", $new_price, PDO::PARAM_INT);
            $stmt->bindParam(":unit_price", $unit_price, PDO::PARAM_INT);
    
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                header("Location: {$_SERVER['REQUEST_URI']}");
                return $stmt->fetch();
            }
        }

        public static function updateCartItemQuantityAndPrice($pdo, $customer_id, $product_id, $quantity=1, $unit_price){
            $sql = "UPDATE cart set quantity=:quantity, price = :unit_price
            WHERE customer_id=:customer_id and product_id=:product_id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_STR);
            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
            $stmt->bindParam(":unit_price", $unit_price, PDO::PARAM_INT);
    
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                header("Location: {$_SERVER['REQUEST_URI']}");
                return $stmt->fetch();
            }
        }

        public static function countCartItem($pdo, $customer_id){
            $sql = "SELECT COUNT(*) FROM cart WHERE customer_id=:customer_id";
            $stmt = $pdo->prepare($sql);
    
            $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_STR);
            if($stmt->execute()){
                return $stmt->fetchColumn();
            }
        }
    
        public static function deleteCartItem($pdo, $customer_id, $product_id) {
            $sql = "DELETE FROM cart WHERE customer_id=:customer_id and product_id=:product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);
    
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                header("Location: {$_SERVER['REQUEST_URI']}");
                return $stmt->fetch();
            }
        }

        public static function deleteCart($pdo, $customer_id) {
            $sql = "DELETE FROM cart WHERE customer_id=:customer_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":customer_id", $customer_id, PDO::PARAM_INT);
    
            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Cart");
                header("Location: {$_SERVER['REQUEST_URI']}");
                return $stmt->fetch();
            }
        }
    }