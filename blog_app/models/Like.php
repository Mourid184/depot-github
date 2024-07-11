<?php
require_once '../config/database.php';

class Like {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function toggle($postId, $userId) {
        // Vérifier si le like existe déjà
        $query = "SELECT id FROM likes WHERE post_id = :post_id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'post_id' => $postId,
            'user_id' => $userId
        ]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Si le like existe, on le supprime
            $query = "DELETE FROM likes WHERE id = :id";
            $stmt = $this->db->prepare($query);
            return $stmt->execute(['id' => $existing['id']]);
        } else {
            // Si le like n'existe pas, on l'ajoute
            $query = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([
                'post_id' => $postId,
                'user_id' => $userId
            ]);
        }
    }


    public function countByPostId($postId) {
        $query = "SELECT COUNT(*) FROM likes WHERE post_id = :post_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchColumn();
    }

    public function hasUserLiked($postId, $userId) {
        $query = "SELECT COUNT(*) FROM likes WHERE post_id = :post_id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'post_id' => $postId,
            'user_id' => $userId
        ]);
        return $stmt->fetchColumn() > 0;
    }
}
