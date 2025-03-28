<?php
namespace src\controllers;

use src\core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home/index', [
            'title' => 'Блог',
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
} 