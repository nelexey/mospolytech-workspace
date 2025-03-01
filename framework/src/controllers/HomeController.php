<?php
namespace src\controllers;

use src\core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $userModel = $this->model('User');
        $users = $userModel->getAllUsers();
        
        $this->view('home/index', [
            'title' => 'Главная страница',
            'users' => $users
        ]);
    }
    
    public function about()
    {
        $this->view('home/about', [
            'title' => 'О проекте',
            'description' => 'Это проект на PHP.',
            'features' => [
                "по паттерну MVC",
            ]
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