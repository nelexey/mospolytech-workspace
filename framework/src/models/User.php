<?php
namespace src\models;

class User
{
    // Имитация получения данных из базы данных
    public function getAllUsers()
    {
        return [
            ['id' => 1, 'name' => 'Иван', 'email' => 'ivan@example.com'],
            ['id' => 2, 'name' => 'Мария', 'email' => 'maria@example.com'],
            ['id' => 3, 'name' => 'Алексей', 'email' => 'alex@example.com']
        ];
    }
    
    public function getUserById($id)
    {
        $users = $this->getAllUsers();
        
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        
        return null;
    }
} 