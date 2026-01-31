<?php
session_start();

require 'vendor/autoload.php';
require 'app/helpers.php'; // Load helper functions

use App\Controllers\HomeController;
use App\Controllers\ProductController;

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;
    
    // Danh sách sản phẩm
    case 'product-list':
        $controller = new ProductController();
        $controller->index();
        break;
    
    // Chi tiết sản phẩm
    case 'product-detail':
        $controller = new ProductController();
        $controller->detail();
        break;
    
    // Thêm mới sản phẩm
    case 'product-add':
        $controller = new ProductController();
        $controller->create();
        break;
    
    case 'product-store':
        $controller = new ProductController();
        $controller->store();
        break;
    
    // Sửa sản phẩm
    case 'product-edit':
        $controller = new ProductController();
        $controller->edit();
        break;
    
    case 'product-update':
        $controller = new ProductController();
        $controller->update();
        break;
    
    // Xóa sản phẩm
    case 'product-delete':
        $controller = new ProductController();
        $controller->delete();
        break;
    
    default:
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>404 - Không tìm thấy trang</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body>
            <div class='container mt-5'>
                <div class='text-center'>
                    <h1 class='display-1'>404</h1>
                    <h2>Không tìm thấy trang</h2>
                    <p class='lead'>Trang bạn đang tìm kiếm không tồn tại.</p>
                    <a href='index.php?page=home' class='btn btn-primary'>Quay về trang chủ</a>
                </div>
            </div>
        </body>
        </html>";
        break;
}