<?php
session_start();

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/controllers/PostController.php';
require_once BASE_PATH . '/controllers/UserController.php';

$action = $_GET['action'] ?? 'index';

$postController = new PostController();
$userController = new UserController();

switch ($action) {
    case 'index':
        $postController->index();
        break;
    case 'show':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $postController->show($id);
        } else {
            echo "ID de l'article manquant";
        }
        break;
    case 'create':
        $postController->create();
        break;
    case 'addComment':
        $postId = $_GET['id'] ?? null;
        if ($postId) {
            $postController->addComment($postId);
        } else {
            echo "ID de l'article manquant";
        }
        break;
    case 'toggleLike':
        $postId = $_GET['id'] ?? null;
        if ($postId) {
            $postController->toggleLike($postId);
        } else {
            echo "ID de l'article manquant";
        }
        break;
    case 'login':
        $userController->login();
        break;
    case 'register':
        $userController->register();
        break;
    case 'logout':
        $userController->logout();
        break;
    case 'delete':
        $postId = $_GET['id'] ?? null;
        if ($postId) {
            $postController->deletePost($postId);
        } else {
            echo "ID de l'article manquant";
        }
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page non trouvée";
        break;
}
