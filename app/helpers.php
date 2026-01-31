<?php
// Helper functions đơn giản

function uploadImage($file, $targetDir = 'public/uploads/products/') {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'filename' => '', 'error' => ''];
    }
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'filename' => '', 'error' => 'Lỗi upload'];
    }
    
    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        return ['success' => false, 'filename' => '', 'error' => 'File quá lớn'];
    }
    
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        return ['success' => false, 'filename' => '', 'error' => 'Chỉ chấp nhận ảnh'];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $targetPath = $targetDir . $filename;
    
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => true, 'filename' => $filename, 'error' => ''];
    }
    
    return ['success' => false, 'filename' => '', 'error' => 'Không thể lưu'];
}

function deleteImage($filename, $targetDir = 'public/uploads/products/') {
    if (empty($filename)) return false;
    $filepath = $targetDir . $filename;
    if (file_exists($filepath)) return unlink($filepath);
    return false;
}

function getImageUrl($filename) {
    // Nếu rỗng - trả về ảnh base64 SVG
    if (empty($filename)) {
        return 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="400" height="400"%3E%3Crect width="400" height="400" fill="%23ddd"/%3E%3Ctext x="50%25" y="50%25" text-anchor="middle" dy=".3em" fill="%23999" font-size="18"%3ENo Image%3C/text%3E%3C/svg%3E';
    }
    
    // Nếu là URL
    if (filter_var($filename, FILTER_VALIDATE_URL)) {
        return $filename;
    }
    
    // Nếu là file local
    return 'public/uploads/products/' . $filename;
}