<?php
require_once '../models/Post.php';
require_once '../models/User.php';
require_once '../models/Like.php';
require_once '../models/Comment.php';



class PostController {
    private $postModel;
    private $commentModel;
    private $likeModel;
    private $userModel;

    public function __construct() {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->likeModel = new Like();
        $this->commentModel = new Comment();
    }

    public function index() {
        $posts = $this->postModel->getAllPosts();
        require '../views/posts/index.php';
    }

    public function show($id) {
        $post = $this->postModel->getById($id);
        if (!$post) {
            // Gérer l'erreur 404
            header("HTTP/1.0 404 Not Found");
            echo "Article non trouvé";
            return;
        }

        $author = $this->userModel->getById($post['user_id']);
        $comments = $this->commentModel->getByPostId($id);
        $likesCount = $this->likeModel->countByPostId($id);
        
        $canDelete = $this->canDeletePost($post['user_id']);
        $isLoggedIn = isset($_SESSION['user_id']);
        $hasLiked = $isLoggedIn ? $this->likeModel->hasUserLiked($id, $_SESSION['user_id']) : false;


        require  '../views/posts/show.php';
    }

    private function canDeletePost($authorId) {
        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            return false;
        }

        $currentUser = $this->userModel->getById($_SESSION['user_id']);

        // L'utilisateur peut supprimer s'il est l'auteur ou un admin
        return ($currentUser['id'] === $authorId || $currentUser['is_admin']);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $userId = $_SESSION['user_id']; // L'utilisateur doit être connecté

            $imagePath = $this->uploadImage();

            if ($this->postModel->create($userId, $title, $content, $imagePath)) {
                // Rediriger vers la liste des posts ou le post créé
                header('Location: index.php?action=index');
                exit;
            } else {
                // Gérer l'erreur
                echo "Erreur lors de la création du post";
            }
        }

        // Afficher le formulaire de création
        require  '../views/posts/create.php';
    }

    private function uploadImage() {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../public/uploads/';
            $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                return 'blog_app/public/uploads/' . $fileName; // Chemin relatif pour la base de données
            }
        }
        return null;
    }

    public function addComment($postId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST['content'];
            $userId = $_SESSION['user_id'];

            if ($this->commentModel->create($postId, $userId, $content)) {
                header("Location: index.php?action=show&id=$postId");
                exit;
            } else {
                echo "Erreur lors de l'ajout du commentaire";
            }
        }
    }

    public function deletePost($postId) {

        $this->postModel->deleteById($postId) ;
        header("Location: index.php?action=index");
        exit;
    }

    public function toggleLike($postId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    
        $userId = $_SESSION['user_id'];
        $this->likeModel->toggle($postId, $userId);
        
        // Récupérer le nouveau statut du like
        $hasLiked = $this->likeModel->hasUserLiked($postId, $userId);
        $likesCount = $this->likeModel->countByPostId($postId);
        
        // Retourner les nouvelles informations en JSON
        header('Content-Type: application/json');
        echo json_encode([
            'hasLiked' => $hasLiked,
            'likesCount' => $likesCount
        ]);
        exit;
    }
    


}
