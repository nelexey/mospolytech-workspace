CREATE DATABASE IF NOT EXISTS framework_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE framework_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (name, email, password) VALUES
('Вася', 'vasya@example.com', '$2y$10$some_hash_here'),
('Петя', 'petia@example.com', '$2y$10$some_hash_here'),
('Коля', 'kolya@example.com', '$2y$10$some_hash_here');

