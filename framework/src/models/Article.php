<?php
namespace src\models;

use src\core\DataMapper;

class Article extends DataMapper
{
    protected $table = 'articles';
    
    public function getByAuthor($authorId)
    {
        return $this->where('author_id = ?', [$authorId], 'created_at DESC');
    }
    
    public function getWithAuthor($id = null)
    {
        if ($id === null) {
            return $this->query(
                "SELECT a.*, u.name as author_name 
                FROM {$this->table} a 
                LEFT JOIN users u ON a.author_id = u.id 
                ORDER BY a.created_at DESC"
            )->fetchAll();
        }
        
        return $this->query(
            "SELECT a.*, u.name as author_name 
            FROM {$this->table} a 
            LEFT JOIN users u ON a.author_id = u.id 
            WHERE a.id = ?", 
            [$id]
        )->fetch();
    }
    
    public function recent($limit = 5)
    {
        return $this->where('1', [], 'created_at DESC LIMIT ' . $limit);
    }
} 