<?php
require_once __DIR__ . "/controllers/UserController.php";
require_once __DIR__ . "/controllers/ArticleController.php";
require_once __DIR__ . "/controllers/CommentController.php";

$action = $_GET['action'] ?? 'articles.index';

// Start Session
session_start();

$public = ['login', 'doLogin', 'register', 'doRegister', 'articles.index', 'articles.show'];

if (empty($_SESSION['user_id']) && !in_array($action, $public)) {
    $action = 'login';
}

switch ($action) {

    // Users
    case 'login':
        (new UserController())->login();
        break;
    case 'doLogin':
        (new UserController())->doLogin();
        break;
    case 'register':
        (new UserController())->register();
        break;
    case 'doRegister':
        (new UserController())->doRegister();
        break;
    case 'logout':
        (new UserController())->logout();
        break;

        
    // Articles
    case 'articles.index':
        (new ArticleController())->index();
        break;
    case 'articles.create':
        (new ArticleController())->create();
        break;
    case 'articles.store':
        (new ArticleController())->store();
        break;
    case 'articles.edit':
        (new ArticleController())->edit();
        break;
    case 'articles.update':
        (new ArticleController())->update();
        break;
    case 'articles.delete':
        (new ArticleController())->delete();
        break;
    case 'articles.show':
        (new ArticleController())->show();
        break;

    // Comments
    case 'comments.store':
        (new CommentController())->store();
        break;
    case 'comments.ajaxStore':
        (new CommentController())->ajaxStore();
        break;


    // All Articles 
    case 'articles.all':
        (new ArticleController())->all();
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}
