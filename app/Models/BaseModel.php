<?php
namespace App\Models;

use PDO;
use PDOException;

class BaseModel {
    protected $pdo;
    protected $table;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'buoi2_php';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
    }

    // Lấy tất cả bản ghi
    public function all() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    // Tìm bản ghi theo ID
    public function find($id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    // Thêm mới bản ghi
    public function insert($data) {
        try {
            $fields = array_keys($data);
            $placeholders = array_map(function($field) {
                return ":$field";
            }, $fields);

            $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                    VALUES (" . implode(', ', $placeholders) . ")";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Cập nhật bản ghi
    public function update($id, $data) {
        try {
            $fields = [];
            foreach (array_keys($data) as $field) {
                $fields[] = "$field = :$field";
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id";
            
            $data['id'] = $id;
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Xóa bản ghi
    public function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Tìm kiếm
    public function search($keyword, $field = 'name') {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE $field LIKE :keyword ORDER BY id DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['keyword' => "%$keyword%"]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}