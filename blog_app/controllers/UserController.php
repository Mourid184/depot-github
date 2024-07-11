<?php
require_once BASE_PATH . '/models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->getByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: index.php');
                exit;
            } else {

                $error = "Email ou mot de passe incorrect";
            }
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                // ... le reste du code
            }            

        }
        require '../views/users/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if ($this->userModel->create($username, $email, $password)) {
                header('Location: index.php?action=login');
                exit;
            } else {
                $error = "Erreur lors de l'inscription";
            }
        }
        require  '../views/users/register.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
