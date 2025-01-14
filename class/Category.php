<?php
class Category {
    public $id, $name_category;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM category";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category"); // Truy xuất và trả về dưới dạng một đối tượng của lớp Product
            return $stmt->fetchAll();
        }
    }
    
    public static function getOneCategoryByID($pdo, $id) {
        $sql = "SELECT * FROM category WHERE category_id=:id ";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetch();
        }
    }
    
    public static function addOneCategory($pdo, $name) {
        $sql = "INSERT INTO category(category_name) VALUES(:name)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":name", $name, PDO::PARAM_STR);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetch();
        }
    }

    public static function pageination($pdo, $limit, $offset) {
        $sql = "SELECT * FROM category ORDER BY category_id ASC LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);

        if($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetchAll();
        }
    }


    public static function countCategory($pdo) {
        $sql = "SELECT COUNT(*) FROM category";
        $stmt = $pdo->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchColumn();
        }
    }

    public static function editCategory($pdo, $id, $name) {
        $sql = "UPDATE category SET category_name=:name WHERE category_id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);

        if($stmt->execute()){
            header("location: listCategory.php");
        }

    }

    public static function deleteCategory($pdo, $id) {
        $sql = "DELETE FROM category WHERE category_id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if($stmt->execute()){
            header("location: listProduct.php");
        }

    }
}