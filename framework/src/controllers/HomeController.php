<?php
namespace src\controllers;

use src\core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $articleModel = $this->model('Article');
        $articles = $articleModel->getAllArticles();
        
        $this->view('home/index', [
            'title' => 'Блог',
            'articles' => $articles
        ]);
    }
    
    public function about()
    {
        $this->view('home/about', [
            'title' => 'О блоге'
        ]);
    }
    
    public function users()
    {
        $userModel = $this->model('User');
        $users = $userModel->getAllUsers();
        
        $this->view('home/users', [
            'title' => 'Список пользователей',
            'users' => $users,
            'total' => count($users)
        ]);
    }
    
    public function article($id = null)
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
        
        $this->view('home/article', [
            'title' => $article['title'],
            'article' => $article,
            'comments' => $comments
        ]);
    }
} 