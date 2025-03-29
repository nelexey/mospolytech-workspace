<?php
namespace src\core;

abstract class DataMapper
{
    protected $db;
    protected $table;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
        
        if (!$this->table) {
            throw new \Exception("Table name must be set in child class");
        }
    }
    
    public function get($id = null)
    {
        if ($id === null) {
            return $this->all();
        }
        
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }
    
    public function all($orderBy = 'id ASC')
    {
        return $this->db->fetchAll("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
    }
    
    public function where($where, $params = [], $orderBy = 'id ASC')
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderBy}", 
            $params
        );
    }
    
    public function first($where, $params = [])
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE {$where} LIMIT 1", 
            $params
        );
    }
    
    public function save($data, $id = null)
    {
        if ($id) {
            $this->update($id, $data);
            return $id;
        } else {
            return $this->create($data);
        }
    }
    
    protected function create($data)
    {
        if (!isset($data['created_at']) && $this->hasTimestamps()) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }
        
        return $this->db->insert($this->table, $data);
    }
    
    protected function update($id, $data)
    {
        if (!isset($data['updated_at']) && $this->hasTimestamps()) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $this->db->update($this->table, $data, "id = ?", [$id]);
    }
    
    public function delete($id)
    {
        $this->db->delete($this->table, "id = ?", [$id]);
    }
    
    protected function hasTimestamps()
    {
        return true;
    }
    
    public function query($sql, $params = [])
    {
        return $this->db->query($sql, $params);
    }
} 