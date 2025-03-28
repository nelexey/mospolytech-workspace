<?php
namespace src\models;

use src\core\Database;

class User
{
    private $db;
    private $table = 'users';
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    public function getAllUsers()
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table}");
    }
    
    public function getUserById($id)
    {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }
    
    public function createUser($data)
    {
        return $this->db->insert($this->table, $data);
    }
    
    public function updateUser($id, $data)
    {
        $this->db->update($this->table, $data, "id = ?", [$id]);
    }
    
    public function deleteUser($id)
    {
        $this->db->delete($this->table, "id = ?", [$id]);
    }
}