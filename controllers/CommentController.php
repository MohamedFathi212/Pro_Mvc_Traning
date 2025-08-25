<?php
require_once __DIR__ . "/../core/Controller.php";
require_once __DIR__ . "/../models/Comment.php";

class CommentController extends Controller {
    private $comment;
    public function __construct() {
        $this->comment = new Comment();
    }

    public function store() {
        if (empty($_SESSION['user_id'])) $this->redirect("index.php?action=login");
        $article_id = (int)($_POST['article_id'] ?? 0);
        $text = trim($_POST['comment_text'] ?? '');
        if ($article_id && $text) {
            $this->comment->add($article_id, (int)$_SESSION['user_id'], $text);
        }
        $this->redirect("index.php?action=articles.show&id=" . $article_id);
    }

    public function ajaxStore() {
        header('Content-Type: application/json');
        if (empty($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Login required']);
            return;
        }

        $article_id = (int)($_POST['article_id'] ?? 0);
        $text = trim($_POST['comment_text'] ?? '');

        if ($article_id && $text) {
            $this->comment->add($article_id, (int)$_SESSION['user_id'], $text);

            echo json_encode([
                'success' => true,
                'username' => $_SESSION['username'], 
                'comment_text' => htmlspecialchars($text)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
        }
    }
}
