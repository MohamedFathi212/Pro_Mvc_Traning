<?php
require_once __DIR__ . "/../core/Controller.php";
require_once __DIR__ . "/../models/Article.php";
require_once __DIR__ . "/../models/Comment.php";

class ArticleController extends Controller
{
    private $article;
    private $comment;

    public function __construct()
    {
        $this->article = new Article();
        $this->comment = new Comment();
    }

    private function mustLogin()
    {
        if (empty($_SESSION['user_id'])) $this->redirect("index.php?action=login");
    }

    public function index() {
        if (empty($_SESSION['user_id'])) {
            $articles = $this->article->getAll();  
        } else {
            $articles = $this->article->getAllArticles(); 

        }
        $this->view("articles/index", data: ['articles' => $articles]);
    }
    public function all() {
        $articles = $this->article->getAll();
        $this->view("articles/all", data: ['articles' => $articles]);
    }


    public function create()
    {
        $this->mustLogin();
        $categories = $this->article->getCategories();
        $this->view("articles/create", ['categories' => $categories]);
    }

    
    public function store()
    {
        $this->mustLogin();
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $category_id = (int)($_POST['category_id'] ?? 0);
        $user_id = (int)$_SESSION['user_id'];
        $is_active = (int)($_POST['is_active'] ?? 0);

        $imageName = "";
        if (!empty($_FILES['image']['name'])) {
            $imageName =  preg_replace("/[^A-Za-z0-9_.-]/", "_", $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../uploads/" . $imageName);
        }

        $this->article->createArticle($title, $content, $imageName, $category_id, $user_id, $is_active);
        $this->redirect("index.php?action=articles.index");
    }

    public function edit()
    {
        $this->mustLogin();
        $id = (int)($_GET['id'] ?? 0);
        $article = $this->article->find($id);
        if (!$article) $this->redirect("index.php?action=articles.index");
        $categories = $this->article->getCategories();
        $this->view("articles/edit", ['article' => $article, 'categories' => $categories]);
    }

    public function update()
    {
        $this->mustLogin();
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $category_id = (int)($_POST['category_id'] ?? 0);
        $is_active = (int)($_POST['is_active'] ?? 0);

        $imageName = "";
        if (!empty($_FILES['image']['name'])) {
            $imageName = preg_replace("/[^A-Za-z0-9_.-]/", "_", $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/../uploads/" . $imageName);
        }

        $this->article->updateArticle($id, $title, $content, $imageName, $category_id, $is_active);
        $this->redirect("index.php?action=articles.index");
    }

    public function delete()
    {
        $this->mustLogin();
        $id = (int)($_GET['id'] ?? 0);
        $article = $this->article->getById($id);
    if ($article) {
        if (!empty($article['image']) && file_exists("uploads/" . $article['image'])) {
            unlink("uploads/" . $article['image']); 
        }
        $this->article->deleteArticle($id);
    }
    $this->redirect("index.php?action=articles.index");
    }


    public function show()
    {
        $id = (int)($_GET['id'] ?? 0);
        $article = $this->article->find($id);
        if (!$article) $this->redirect("index.php?action=articles.index");
        $comments = $this->comment->forArticle($id);
        $this->view("articles/show", ['article' => $article, 'comments' => $comments]);
    }
}

