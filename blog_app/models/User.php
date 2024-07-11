<?php
require_once BASE_PATH . '/config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($username, $email, $password) {
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password // Assurez-vous que le mot de passe est déjà haché
        ]);
    }

    public function getByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $query = "UPDATE users SET ";
        $params = [];
        foreach ($data as $key => $value) {
            $query .= "$key = :$key, ";
            $params[$key] = $value;
        }
        $query = rtrim($query, ', ');
        $query .= " WHERE id = :id";
        $params['id'] = $id;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    public function isAdmin($id) {
        $query = "SELECT is_admin FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['is_admin'] == 1;
    }
}
