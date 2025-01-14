<?php
    class Brand{
        // public $id, $name, $description, $image;
    
        public static function getAll($pdo) {
            $sql = "SELECT * FROM brand";
            $stmt = $pdo->prepare($sql);
    
            if($stmt->execute()) {
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Brand"); // Truy xuất và trả về dưới dạng một đối tượng của lớp Product
                return $stmt->fetchAll();
            }
        }

        public static function getOneBrandByID($pdo, $id) {
            $sql = "SELECT * FROM brand WHERE brand_id=:id ";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Brand");
                return $stmt->fetch();
            }
        }
        
        public static function addOneBrand($pdo, $name, $desc, $img) {
            $sql = "INSERT INTO brand(brand_name, brand_desc, brand_image) VALUES(:name, :desc, :img)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
            $stmt->bindParam(":img", $img, PDO::PARAM_STR);

            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Brand");
                return $stmt->fetch();
            }
        }

        public static function pageination($pdo, $limit, $offset) {
            $sql = "SELECT * FROM brand ORDER BY brand_id ASC LIMIT :limit OFFSET :offset";

            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);

            if($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS, "Brand");
                return $stmt->fetchAll();
            }
        }


        public static function countBrand($pdo) {
            $sql = "SELECT COUNT(*) FROM brand";
            $stmt = $pdo->prepare($sql);

            if($stmt->execute()){
                return $stmt->fetchColumn();
            }
        }

        public static function editBrand($pdo, $id, $name, $desc, $img) {
            $sql = "UPDATE brand SET brand_name=:name, brand_desc=:desc, brand_image=:img WHERE brand_id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":desc", $desc, PDO::PARAM_STR);
            $stmt->bindParam(":img", $img, PDO::PARAM_STR);

            if($stmt->execute()){
                header("location: listBrand.php");
            }
        }

        public static function deleteBrand($pdo, $id) {
            $sql = "DELETE FROM brand WHERE brand_id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if($stmt->execute()){
                header("location: listBrandphp");
            }

        }


        // admin
        public static function getNameBrand($pdo, $brand_id) {
            $sql = "SELECT brand_name FROM brand where brand_id=:brand_id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":brand_id", $brand_id, PDO::PARAM_INT);
    
            if($stmt->execute()) {
                return $stmt->fetchColumn();
            }
        }
    }