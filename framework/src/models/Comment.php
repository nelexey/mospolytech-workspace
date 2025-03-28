<?php
namespace src\models;

use src\core\Database;

class Comment
{
    private $db;
    private $table = 'comments';
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    public function getCommentsByArticleId($articleId)
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE article_id = ? AND parent_comment_id IS NULL ORDER BY created_at DESC", 
            [$articleId]
        );
    }
    
    public function getCommentById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }
    
    public function getCommentReplies($commentId)
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE parent_comment_id = ? ORDER BY created_at ASC", 
            [$commentId]
        );
    }
    
    public function getCommentsByAuthor($authorId)
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE author_id = ? ORDER BY created_at DESC", 
            [$authorId]
        );
    }
    
    public function getCommentsWithReplies($articleId)
    {
        // Сначала получаем все комментарии первого уровня
        $rootComments = $this->getCommentsByArticleId($articleId);
        
        // Для каждого комментария добавляем его ответы
        foreach ($rootComments as &$comment) {
            $comment['replies'] = $this->getAllReplies($comment['id']);
        }
        
        return $rootComments;
    }
    
    // Рекурсивная функция для получения всех ответов (включая ответы на ответы)
    private function getAllReplies($commentId)
    {
        $replies = $this->getCommentReplies($commentId);
        
        foreach ($replies as &$reply) {
            $reply['replies'] = $this->getAllReplies($reply['id']);
        }
        
        return $replies;
    }
    
    public function createComment($data)
    {
        // Убедимся, что дата создания добавлена
        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->db->insert($this->table, $data);
    }
    
    public function updateComment($id, $data)
    {
        $this->db->update($this->table, $data, "id = ?", [$id]);
    }
    
    public function deleteComment($id)
    {
        // Сначала удаляем все ответы на комментарий
        $this->deleteRepliesRecursive($id);
        
        // Затем удаляем сам комментарий
        $this->db->delete($this->table, "id = ?", [$id]);
    }
    
    private function deleteRepliesRecursive($commentId)
    {
        // Получаем все ответы на комментарий
        $replies = $this->getCommentReplies($commentId);
        
        foreach ($replies as $reply) {
            // Рекурсивно удаляем ответы на ответы
            $this->deleteRepliesRecursive($reply['id']);
            
            // Удаляем текущий ответ
            $this->db->delete($this->table, "id = ?", [$reply['id']]);
        }
    }
} 