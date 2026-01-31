<?php
namespace App\Models;

class Product extends BaseModel {
    protected $table = 'products';

    // Kế thừa tất cả methods từ BaseModel
    // Có thể thêm các methods riêng cho Product nếu cần
    
    // Lấy sản phẩm với giá trong khoảng
    public function getByPriceRange($minPrice, $maxPrice) {
        try {
            $sql = "SELECT * FROM {$this->table} 
                    WHERE price BETWEEN :min AND :max 
                    ORDER BY price ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'min' => $minPrice,
                'max' => $maxPrice
            ]);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }
}