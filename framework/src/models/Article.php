<?php
namespace src\models;

use src\core\Database;

class Article
{
    private $db;
    private $table = 'articles';
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    public function getAllArticles()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY created_at DESC");
    }
    
    public function getArticleById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }
    
    public function getArticlesByAuthor($authorId)
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE author_id = ? ORDER BY created_at DESC", 
            [$authorId]
        );
    }
    
    public function createArticle($data)
    {
        // Убедимся, что дата создания добавлена
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->db->insert($this->table, $data);
    }
    
    public function updateArticle($id, $data)
    {
        $this->db->update($this->table, $data, "id = ?", [$id]);
    }
    
    public function deleteArticle($id)
    {
        $this->db->delete($this->table, "id = ?", [$id]);
    }
} 