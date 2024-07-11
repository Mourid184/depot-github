<?php
require_once '../config/database.php';

class Comment {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($postId, $userId, $content) {
        $query = "INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $content
        ]);
    }

    public function getByPostId($postId) {
        $query = "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = :post_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
