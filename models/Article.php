<?php

require_once __DIR__ . "/../core/Database.php";

class Article
{
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    //عرض المقالات النشطة فقط
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

    // عرض كل المقالات (Active + Inactive)
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

    public function create($title, $content, $image, $category_id, $user_id, $is_active)
    {
        $stmt = $this->db->prepare("INSERT INTO articles (title, content, image, is_active, category_id, user_id)
                                    VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiii", $title, $content, $image, $is_active, $category_id, $user_id);
        return $stmt->execute();
    }

    public function update($id, $title, $content, $image, $category_id, $is_active)
    {
        if ($image) {
            $stmt = $this->db->prepare("UPDATE articles SET title=?, content=?, image=?, category_id=?, is_active=? WHERE id=?");
            $stmt->bind_param("sssiii", $title, $content, $image, $category_id, $is_active, $id);
        } else {
            $stmt = $this->db->prepare("UPDATE articles SET title=?, content=?, category_id=?, is_active=? WHERE id=?");
            $stmt->bind_param("siiii", $title, $content, $category_id, $is_active, $id);
        }
        return $stmt->execute();
    }

public function delete($id)
{
    $id = intval($id); 
    $art = $this->find($id);

    $sql = "DELETE FROM articles WHERE id=$id";
    $ok = $this->db->query($sql);

    if ($ok && $art && !empty($art['image'])) {
        $path = __DIR__ . "/../uploads/" . $art['image'];
        if (file_exists($path)) {
            if (!unlink($path)) {
                error_log("Failed to delete image: $path");
            }
        }
    }
    return $ok;
}

    public function getCategories()
    {
        return $this->db->query("SELECT id, name FROM categories ORDER BY name ASC");
    }
}






































// require_once __DIR__ . "/../core/Database.php";

// class Article {
//     private $db;

//     public function __construct() {
//         $this->db = (new Database())->conn;
//     }

//     // عرض المقالات النشطة فقط
//     public function getAll() {
//         $sql = "SELECT a.*, u.username
//                 FROM articles a
//                 LEFT JOIN users u ON a.user_id = u.id
//                 WHERE a.is_active = 1
//                 ORDER BY a.id DESC";
//         return $this->db->query($sql);
//     }

//     // عرض كل المقالات (Active + Inactive)
//     public function getAllArticles() {
//         $sql = "SELECT a.*, u.username
//                 FROM articles a
//                 LEFT JOIN users u ON a.user_id = u.id
//                 ORDER BY a.id DESC";
//         return $this->db->query($sql);
//     }

//     // جلب مقالة واحدة
//     public function find($id) {
//         $id = intval($id); // تصفية رقمية
//         $sql = "SELECT a.*, u.username
//                 FROM articles a
//                 LEFT JOIN users u ON a.user_id = u.id
//                 WHERE a.id = $id
//                 LIMIT 1";
//         $result = $this->db->query($sql);
//         return $result->fetch_assoc();
//     }

//     // إنشاء مقالة جديدة
//     public function create($title, $content, $image, $user_id, $is_active) {
//         $title = $this->db->real_escape_string($title);
//         $content = $this->db->real_escape_string($content);
//         $image = $this->db->real_escape_string($image);
//         $user_id = intval($user_id);
//         $is_active = intval($is_active);

//         $sql = "INSERT INTO articles (title, content, image, is_active, user_id)
//                 VALUES ('$title', '$content', '$image', $is_active, $user_id)";
//         return $this->db->query($sql);
//     }

//     // تعديل مقالة
//     public function update($id, $title, $content, $image, $is_active) {
//         $id = intval($id);
//         $title = $this->db->real_escape_string($title);
//         $content = $this->db->real_escape_string($content);
//         $is_active = intval($is_active);

//         if ($image) {
//             $image = $this->db->real_escape_string($image);
//             $sql = "UPDATE articles
//                     SET title='$title', content='$content', image='$image', is_active=$is_active
//                     WHERE id=$id";
//         } else {
//             $sql = "UPDATE articles
//                     SET title='$title', content='$content', is_active=$is_active
//                     WHERE id=$id";
//         }
//         return $this->db->query($sql);
//     }

//     // حذف مقالة مع الصورة
//     public function delete($id) {
//         $id = intval($id);
//         $art = $this->find($id);

//         $sql = "DELETE FROM articles WHERE id=$id";
//         $ok = $this->db->query($sql);

//         if ($ok && $art && !empty($art['image'])) {
//             $path = __DIR__ . "/../uploads/" . $art['image'];
//             if (file_exists($path)) @unlink($path);
//         }
//         return $ok;
//     }
// }
