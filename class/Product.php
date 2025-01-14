<?php
class Product {
    public $id, $name, $description, $price, $image;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM product p, brand b, category c
        WHERE p.brand_id = b.brand_id and p.category_id = c.category_id";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product"); // Truy xuất và trả về dưới dạng một đối tượng của lớp Product
            return $stmt->fetchAll();
        }
    }

    public static function getOneProductByID($pdo, $id) {
        $sql = "SELECT * FROM product p, brand b, category c WHERE product_id=:id and p.brand_id = b.brand_id and p.category_id = c.category_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }

    public static function getNewProduct($pdo, $search_keyword, $limit) {
        $sql = "SELECT product_id, product_name, product_price, product_image, brand_name FROM product p
                LEFT JOIN brand b ON p.brand_id = b.brand_id
                LEFT JOIN category c ON p.category_id = c.category_id
                WHERE product_name LIKE :search_keyword
                ORDER BY product_id DESC LIMIT :limit";
        $stmt = $pdo->prepare($sql);
        
        $search_keyword = "%" . $search_keyword . "%";
        $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
    
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

    public static function getRelatedProduct($pdo, $id, $cat_id , $brand_id, $limit) {
        $sql = "SELECT * FROM product p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id
        WHERE (:cat_id IS NULL OR c.category_id = :cat_id)
        AND (:brand_id IS NULL OR b.brand_id = :brand_id) AND p.product_id != :id
        ORDER BY product_id ASC LIMIT :limit";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $stmt->bindParam(":brand_id", $brand_id, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }    

    public static function countProduct($pdo, $cat_id, $brand_id, $search_keyword) {
        $sql = "SELECT COUNT(*) FROM product p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id
        WHERE (:cat_id IS NULL OR c.category_id = :cat_id) AND (:brand_id IS NULL OR b.brand_id = :brand_id)
        AND (product_name LIKE :search_keyword OR brand_name LIKE :search_keyword OR category_name LIKE :search_keyword  OR :search_keyword IS NULL)";

        $stmt = $pdo->prepare($sql);
        $search_keyword = "%" . $search_keyword . "%";
        $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);
        $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $stmt->bindParam(":brand_id", $brand_id, PDO::PARAM_INT);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    public static function getLastId($pdo) {
        $sql = "SELECT product_id FROM product ORDER BY product_id DESC LIMIT 1";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    // chức năng sắp xếp
    public static function arrange($pdo, $cat_id , $brand_id, $search_keyword, $limit, $offset, $sortOrder) {
        $sql = "SELECT product_id, product_name, product_price, product_image, brand_name FROM product p
                LEFT JOIN brand b ON p.brand_id = b.brand_id
                LEFT JOIN category c ON p.category_id = c.category_id
                WHERE (:cat_id IS NULL OR c.category_id = :cat_id) AND (:brand_id IS NULL OR b.brand_id = :brand_id)
                AND (product_name LIKE :search_keyword OR brand_name LIKE :search_keyword OR category_name LIKE :search_keyword  OR :search_keyword IS NULL)
                ORDER BY product_price $sortOrder LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $stmt->bindParam(":brand_id", $brand_id, PDO::PARAM_INT);
        
        $search_keyword = "%" . $search_keyword . "%";
        $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

    public static function getRecentlyUpdated($pdo, $cat_id , $brand_id, $search_keyword, $limit, $offset) {
        $sql = "SELECT product_id, product_name, product_price, product_image, brand_name FROM product p
                LEFT JOIN brand b ON p.brand_id = b.brand_id
                LEFT JOIN category c ON p.category_id = c.category_id
                WHERE (:cat_id IS NULL OR c.category_id = :cat_id) AND (:brand_id IS NULL OR b.brand_id = :brand_id)
                AND (product_name LIKE :search_keyword OR brand_name LIKE :search_keyword OR category_name LIKE :search_keyword  OR :search_keyword IS NULL)
                ORDER BY product_id DESC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $stmt->bindParam(":brand_id", $brand_id, PDO::PARAM_INT);
        
        $search_keyword = "%" . $search_keyword . "%";
        $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

    // get sp theo chủ đề danh mục, thương hiệu cùng với chức năng tìm kiếm và phân trang
    public static function pagination($pdo, $cat_id , $brand_id, $search_keyword, $limit, $offset) {
        $sql = "SELECT product_id, product_name, product_price, product_image, brand_name FROM product p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id
        WHERE (:cat_id IS NULL OR c.category_id = :cat_id) AND (:brand_id IS NULL OR b.brand_id = :brand_id)
        AND (product_name LIKE :search_keyword OR brand_name LIKE :search_keyword
        OR category_name LIKE :search_keyword  OR :search_keyword IS NULL)
        ORDER BY product_id ASC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(":cat_id", $cat_id, PDO::PARAM_INT);
        $stmt->bindParam(":brand_id", $brand_id, PDO::PARAM_INT);
        
        $search_keyword = "%" . $search_keyword . "%";
        $stmt->bindParam(":search_keyword", $search_keyword, PDO::PARAM_STR);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    
        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

    // ---------------- admin ----------------
    
    public static function getAllProduct($pdo, $limit, $offset) {
        $sql = "SELECT * FROM product p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id
        ORDER BY product_id ASC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

    public static function countAllProduct($pdo) {
        $sql = "SELECT COUNT(*) FROM product p
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        LEFT JOIN category c ON p.category_id = c.category_id";

        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    public static function getDetailProductByID($pdo, $id) {
        $sql = "SELECT * FROM product p
        LEFT JOIN category c ON p.category_id = c.category_id
        LEFT JOIN brand b ON p.brand_id = b.brand_id
        WHERE p.product_id =:id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }

    public static function addOneProduct($pdo, $name, $price, $desc, $image, $brand, $cat) {
        $sql = "INSERT INTO product(product_name, product_price, product_description,
        product_image, brand_id, category_id) VALUES(:name, :price, :desc, :image, :brand, :cat)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);
        $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
        $stmt->bindParam(":image", $image, PDO::PARAM_STR);
        $stmt->bindParam(":brand", $brand, PDO::PARAM_STR);
        $stmt->bindParam(":cat", $cat, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }

    public static function editNoneImg($pdo, $id, $name, $price, $desc, $brand, $cat) {
        $sql = "UPDATE product SET product_name=:name, product_description=:description,
        product_price=:price, brand_id=:brand, category_id=:cat WHERE product_id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $desc, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);
        $stmt->bindParam(":brand", $brand, PDO::PARAM_INT);
        $stmt->bindParam(":cat", $cat, PDO::PARAM_INT);

        if($stmt->execute()){
            header("location: listProduct.php");
        }

    }


    public static function editProduct($pdo, $id, $name, $price, $desc, $img, $brand, $cat) {
        $sql = "UPDATE product SET product_name=:name, product_image=:img, product_description=:description,
        product_price=:price, brand_id=:brand, category_id=:cat WHERE product_id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $desc, PDO::PARAM_STR);
        $stmt->bindParam(":img", $img, PDO::PARAM_STR);
        $stmt->bindParam(":price", $price, PDO::PARAM_INT);
        $stmt->bindParam(":brand", $brand, PDO::PARAM_INT);
        $stmt->bindParam(":cat", $cat, PDO::PARAM_INT);

        if($stmt->execute()){
            header("location: listProduct.php");
        }

    }

    public static function deleteProduct($pdo, $id) {
        $sql = "DELETE FROM product WHERE product_id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            header("location: listProduct.php");
        }
    }
    
    public static function isExistProductOrder($pdo, $id) {
        $sql = "SELECT COUNT(*) FROM order_detail WHERE product_id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    // public static function totalProduct($pdo) {
    //     $sql = "SELECT COUNT(*) FROM product";
    //     $stmt = $pdo->prepare($sql);

    //     if($stmt->execute()){
    //         return $stmt->fetchColumn();
    //     }
    // }
    public static function totalProduct($pdo) {
        $sql = "SELECT MAX(product_id) FROM product"; // Get the maximum product_id
        $stmt = $pdo->prepare($sql);
    
        if($stmt->execute()){
            return $stmt->fetchColumn(); // Return the highest product_id
        }
    
        return null; // Return null if the execution fails
    }
}