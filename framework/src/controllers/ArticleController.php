<?php
namespace src\controllers;

use src\core\Controller;

class ArticleController extends Controller
{
    
    public function show($id = null)
    {
        if ($id === null) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
        
        $articleModel = $this->model('Article');
        $article = $articleModel->getArticleById($id);
        
        if (!$article) {
            header('Location: ' . BASE_URL . '/');
            exit;
        }
        
        $commentModel = $this->model('Comment');
        $comments = $commentModel->getCommentsWithReplies($id);
        
        $this->view('article/index', [
            'title' => $article['title'],
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function list()
    {
        $articleModel = $this->model('Article');
        $articles = $articleModel->getAllArticles();
        
        $this->view('article/list', [
            'title' => 'Блог',
            'articles' => $articles
        ]);
    }
} 