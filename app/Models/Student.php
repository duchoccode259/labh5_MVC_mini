<?php
namespace App\Models;

class Student extends BaseModel {
    protected $table = 'students';

    public function getAllStudents() {
        try {
            $sql = "SELECT id, fullname, student_code, email FROM {$this->table}";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }
}