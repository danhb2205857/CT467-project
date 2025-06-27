<?php
namespace App\Core;

use PDO;
use PDOException;
use App\Core\Format;
use App\Models\Image;
use App\Constants\Index;

abstract class Model
{
    protected $db;
    protected $fm;
    protected $image;
    protected $table;
    protected $index;
    protected $primaryKey = 'id';
    public $error;
    
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->fm = new Format();
        $this->image = new Image();
        $this->index = Index::UserRole;
    }
    
    public function select($query, $params = [], $single = false)
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $single ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error = "Lỗi khi chọn dữ liệu: " . $e->getMessage();
            return false;
        }
    }

    public function insert($query, $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->error = "Insert failed: " . $e->getMessage();
            return false;
        }
    }

    public function update($query, $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->error = "Update failed: " . $e->getMessage();
            return false;
        }
    }

    public function delete($query, $params = [])
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->error = "Delete failed: " . $e->getMessage();
            return false;
        }
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function getAll()
    {
        return $this->select("SELECT * FROM {$this->table}");
    }

    public function getById($id)
    {
        return $this->select("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id], true);
    }

    public function create($data)
    {
        $fields = array_keys($data);
        $placeholders = implode(',', array_fill(0, count($fields), '?'));
        $sql = "INSERT INTO {$this->table} (" . implode(',', $fields) . ") VALUES ($placeholders)";
        return $this->insert($sql, array_values($data));
    }

    public function updateById($id, $data)
    {
        $fields = array_keys($data);
        $set = implode(', ', array_map(fn($f) => "$f = ?", $fields));
        $sql = "UPDATE {$this->table} SET $set WHERE {$this->primaryKey} = ?";
        $params = array_values($data);
        $params[] = $id;
        return $this->update($sql, $params);
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->delete($sql, [$id]);
    }
}
