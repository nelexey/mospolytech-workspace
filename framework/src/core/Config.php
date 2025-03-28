<?php
namespace src\core;

class Config
{
    // Конфигурация базы данных
    public static $db = [
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',  // стандартный пустой пароль для XAMPP
        'database' => 'framework_db',
        'charset' => 'utf8mb4',
        'port' => 3306
    ];
} 