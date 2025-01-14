<?php
class Comment {
    public $comment_id, $product_id, $user_id, $rating, $comment_text, $created_at;

    // Lấy tất cả bình luận cho một sản phẩm
    public static function getAllComments($pdo, $product_id, $limit = 5, $order = 'DESC') {
        // Sắp xếp bình luận theo thời gian (mới nhất hoặc cũ nhất)
        $sql = "SELECT c.comment_id, c.product_id, c.user_id, c.rating, c.comment_text, c.created_at, u.name 
                FROM comment c
                JOIN user u ON c.user_id = u.id
                WHERE c.product_id = :product_id
                ORDER BY c.created_at $order
                LIMIT :limit";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    
        if($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return [];
    }
    

    // Thêm bình luận mới
    public static function addComment($pdo, $product_id, $user_id, $rating, $comment_text) {
        $sql = "INSERT INTO comment (product_id, user_id, rating, comment_text, created_at)
                VALUES (:product_id, :user_id, :rating, :comment_text, NOW())";
    
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':comment_text', $comment_text, PDO::PARAM_STR);
    
        if($stmt->execute()) {
            return true; // Bình luận đã được thêm thành công
        }
        return false; // Thêm bình luận thất bại
    }

    // Cập nhật bình luận
    public static function updateComment($pdo, $comment_id, $rating, $comment_text) {
        $sql = "UPDATE comment SET rating = :rating, comment_text = :comment_text WHERE comment_id = :comment_id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);
        $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);
        $stmt->bindParam(":comment_text", $comment_text, PDO::PARAM_STR);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Xóa bình luận
    public static function deleteComment($pdo, $comment_id) {
        $sql = "DELETE FROM comment WHERE comment_id = :comment_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":comment_id", $comment_id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Tính tổng số lượng bình luận cho sản phẩm
    public static function countComments($pdo, $product_id) {
        $sql = "SELECT COUNT(*) FROM comment WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return $stmt->fetchColumn();
        }
        return 0;
    }
}

?>
