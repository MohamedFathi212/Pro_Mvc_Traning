<?php
require_once __DIR__ . "/../core/Database.php";

class Article extends Controller
{
    private $db;
    private $comment;

    public function __construct()
    {
        $this->db = (new Database())->conn;
        $this->comment = new Comment();
    }

    private function mustLogin()
    {
        if (empty($_SESSION['user_id'])) $this->redirect("index.php?action=login");
    }

    public function getAllArticles()
    {
        $sql = "SELECT a.*, c.name AS category_name, u.username
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.user_id = u.id
                WHERE a.is_active = 1
                ORDER BY a.id DESC";
        return $this->db->query($sql);
    }

    public function getAll()
    {
        $sql = "SELECT a.*, c.name AS category_name, u.username 
                FROM articles a
                LEFT JOIN categories c ON a.category_id = c.id
                LEFT JOIN users u ON a.user_id = u.id
                ORDER BY a.id DESC";
        return $this->db->query($sql);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT a.*, c.name AS category_name, u.username
                                    FROM articles a
                                    LEFT JOIN categories c ON a.category_id = c.id
                                    LEFT JOIN users u ON a.user_id = u.id
                                    WHERE a.id=? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createArticle($title, $content, $image, $category_id, $user_id, $is_active)
    {
        $stmt = $this->db->prepare("INSERT INTO articles (title, content, image, is_active, category_id, user_id)
                                    VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiii", $title, $content, $image, $is_active, $category_id, $user_id);
        return $stmt->execute();
    }

    public function updateArticle($id, $title, $content, $image, $category_id, $is_active)
    {
        if (!empty($image)) {
            $stmt = $this->db->prepare("UPDATE articles 
                                        SET title=?, content=?, image=?, category_id=?, is_active=? 
                                        WHERE id=?");
            $stmt->bind_param("sssiii", $title, $content, $image, $category_id, $is_active, $id);
        } else {
            $stmt = $this->db->prepare("UPDATE articles 
                                        SET title=?, content=?, category_id=?, is_active=? 
                                        WHERE id=?");
            $stmt->bind_param("ssiii", $title, $content, $category_id, $is_active, $id);
        }
        return $stmt->execute();
    }


    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function deleteArticle($id)
    {
        $stmt = $this->db->prepare("DELETE FROM articles WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getCategories()
    {
        return $this->db->query("SELECT * FROM categories ORDER BY id DESC");
    }
}
