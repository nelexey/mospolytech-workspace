<?php
namespace src\models;

use src\core\DataMapper;

class Comment extends DataMapper
{
    protected $table = 'comments';
    
    public function getByArticle($articleId)
    {
        return $this->where(
            'article_id = ? AND parent_comment_id IS NULL', 
            [$articleId], 
            'created_at DESC'
        );
    }
    
    public function getReplies($commentId)
    {
        return $this->where(
            'parent_comment_id = ?', 
            [$commentId], 
            'created_at ASC'
        );
    }
    
    public function getByAuthor($authorId)
    {
        return $this->where(
            'author_id = ?', 
            [$authorId], 
            'created_at DESC'
        );
    }
    
    public function getWithReplies($articleId)
    {
        // Get root comments
        $rootComments = $this->getByArticle($articleId);
        
        // Add replies to each comment
        foreach ($rootComments as &$comment) {
            $comment['replies'] = $this->getAllReplies($comment['id']);
        }
        
        return $rootComments;
    }
    
    private function getAllReplies($commentId)
    {
        $replies = $this->getReplies($commentId);
        
        foreach ($replies as &$reply) {
            $reply['replies'] = $this->getAllReplies($reply['id']);
        }
        
        return $replies;
    }
    
    public function delete($id)
    {
        // First delete all replies
        $this->deleteRepliesRecursive($id);
        
        // Then delete the comment itself
        parent::delete($id);
    }
    
    private function deleteRepliesRecursive($commentId)
    {
        $replies = $this->getReplies($commentId);
        
        foreach ($replies as $reply) {
            // Recursively delete replies to replies
            $this->deleteRepliesRecursive($reply['id']);
            
            // Delete the reply
            parent::delete($reply['id']);
        }
    }
} 