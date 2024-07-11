<?php
require_once '../config/database.php';

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllPosts() {
        $query = "SELECT * FROM posts ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Autres méthodes (getById, create, update, delete) à implémenter

    public function getById($id) {
        $query = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteById($id) {
        $query = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($userId, $title, $content, $imagePath) {
        $query = "INSERT INTO posts (user_id, title, content, image_path) VALUES (:user_id, :title, :content, :image_path)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'content' => $content,
            'image_path' => $imagePath
        ]);
    }


}
