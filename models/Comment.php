<?php
require_once __DIR__ . "/../core/Database.php";

class Comment
{
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function forArticle($article_id)
    {
        $stmt = $this->db->prepare("SELECT c.*, u.username
                                    FROM comments c
                                    LEFT JOIN users u ON c.user_id=u.id
                                    WHERE c.article_id=?
                                    ORDER BY c.id DESC");
        $stmt->bind_param("i", $article_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function add($article_id, $user_id, $text)
    {
        $stmt = $this->db->prepare("INSERT INTO comments (article_id, user_id, comment_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $article_id, $user_id, $text);
        return $stmt->execute();
    }
}
