<?php
namespace App\Controllers;

use App\Models\Product;

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    // Hiển thị danh sách sản phẩm
    public function index() {
        // Xử lý tìm kiếm
        $keyword = $_GET['search'] ?? '';
        
        if (!empty($keyword)) {
            $products = $this->productModel->search($keyword, 'name');
            $message = "Tìm thấy " . count($products) . " sản phẩm với từ khóa: '$keyword'";
        } else {
            $products = $this->productModel->all();
            $message = '';
        }

        include 'views/products/list.php';
    }

    // Hiển thị chi tiết sản phẩm
    public function detail() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header("Location: index.php?page=product-list");
            exit();
        }

        $product = $this->productModel->find($id);
        
        if (!$product) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
            header("Location: index.php?page=product-list");
            exit();
        }

        include 'views/products/detail.php';
    }

    // Hiển thị form thêm mới
    public function create() {
        include 'views/products/add.php';
    }

    // Xử lý thêm mới sản phẩm
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=product-list");
            exit();
        }

        // Validate dữ liệu
        $errors = [];
        
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $imageUrl = trim($_POST['image_url'] ?? ''); // URL từ internet

        if (empty($name)) {
            $errors[] = "Tên sản phẩm không được để trống!";
        }

        if (empty($price)) {
            $errors[] = "Giá không được để trống!";
        } elseif (!is_numeric($price) || $price <= 0) {
            $errors[] = "Giá phải là số dương!";
        }

        // Xử lý upload ảnh
        $imageName = '';
        
        // Ưu tiên upload file trước
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadImage($_FILES['image']);
            
            if ($uploadResult['success']) {
                $imageName = $uploadResult['filename'];
            } else {
                if (!empty($uploadResult['error'])) {
                    $errors[] = $uploadResult['error'];
                }
            }
        } 
        // Nếu không upload file, dùng URL
        elseif (!empty($imageUrl)) {
            // Validate URL
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $imageName = $imageUrl;
            } else {
                $errors[] = "URL hình ảnh không hợp lệ!";
            }
        }

        // Nếu có lỗi, quay lại form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header("Location: index.php?page=product-add");
            exit();
        }

        // Lưu vào database
        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'image' => $imageName
        ];

        $result = $this->productModel->insert($data);

        if ($result) {
            $_SESSION['success'] = "Thêm sản phẩm thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi thêm sản phẩm!";
        }

        header("Location: index.php?page=product-list");
        exit();
    }

    // Hiển thị form sửa
    public function edit() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header("Location: index.php?page=product-list");
            exit();
        }

        $product = $this->productModel->find($id);
        
        if (!$product) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
            header("Location: index.php?page=product-list");
            exit();
        }

        include 'views/products/edit.php';
    }

    // Xử lý cập nhật sản phẩm
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=product-list");
            exit();
        }

        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            header("Location: index.php?page=product-list");
            exit();
        }

        // Lấy thông tin sản phẩm cũ
        $oldProduct = $this->productModel->find($id);
        
        if (!$oldProduct) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
            header("Location: index.php?page=product-list");
            exit();
        }

        // Validate dữ liệu
        $errors = [];
        
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $imageUrl = trim($_POST['image_url'] ?? '');
        $keepOldImage = isset($_POST['keep_old_image']);

        if (empty($name)) {
            $errors[] = "Tên sản phẩm không được để trống!";
        }

        if (empty($price)) {
            $errors[] = "Giá không được để trống!";
        } elseif (!is_numeric($price) || $price <= 0) {
            $errors[] = "Giá phải là số dương!";
        }

        // Xử lý ảnh
        $imageName = $oldProduct['image']; // Mặc định giữ ảnh cũ
        
        // Nếu có upload ảnh mới
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadImage($_FILES['image']);
            
            if ($uploadResult['success']) {
                // Xóa ảnh cũ nếu có (chỉ xóa nếu là file local, không phải URL)
                if (!empty($oldProduct['image']) && !filter_var($oldProduct['image'], FILTER_VALIDATE_URL)) {
                    deleteImage($oldProduct['image']);
                }
                $imageName = $uploadResult['filename'];
            } else {
                if (!empty($uploadResult['error'])) {
                    $errors[] = $uploadResult['error'];
                }
            }
        }
        // Nếu có nhập URL mới
        elseif (!empty($imageUrl) && !$keepOldImage) {
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                // Xóa ảnh cũ nếu là file local
                if (!empty($oldProduct['image']) && !filter_var($oldProduct['image'], FILTER_VALIDATE_URL)) {
                    deleteImage($oldProduct['image']);
                }
                $imageName = $imageUrl;
            } else {
                $errors[] = "URL hình ảnh không hợp lệ!";
            }
        }

        // Nếu có lỗi, quay lại form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header("Location: index.php?page=product-edit&id=$id");
            exit();
        }

        // Cập nhật vào database
        $data = [
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'image' => $imageName
        ];

        $result = $this->productModel->update($id, $data);

        if ($result) {
            $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật sản phẩm!";
        }

        header("Location: index.php?page=product-list");
        exit();
    }

    // Xóa sản phẩm
    public function delete() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header("Location: index.php?page=product-list");
            exit();
        }

        // Lấy thông tin sản phẩm để xóa ảnh
        $product = $this->productModel->find($id);
        
        // Xóa ảnh nếu có (chỉ xóa file local, không xóa URL)
        if ($product && !empty($product['image']) && !filter_var($product['image'], FILTER_VALIDATE_URL)) {
            deleteImage($product['image']);
        }

        $result = $this->productModel->delete($id);

        if ($result) {
            $_SESSION['success'] = "Xóa sản phẩm thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa sản phẩm!";
        }

        header("Location: index.php?page=product-list");
        exit();
    }
}