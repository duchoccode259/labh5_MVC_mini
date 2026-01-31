<!DOCTYPE html>
<html lang="vi">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    .image-preview {
      max-width: 300px;
      max-height: 300px;
      margin-top: 10px;
      border: 2px dashed #ddd;
      padding: 10px;
      border-radius: 5px;
      display: none;
    }

    .image-preview img {
      width: 100%;
      height: auto;
      border-radius: 5px;
    }
    </style>
  </head>

  <body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a class="navbar-brand" href="index.php?page=home">
          <i class="bi bi-shop"></i> Quản lý sản phẩm
        </a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php?page=home"><i class="bi bi-house"></i> Trang
                chủ</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?page=product-list"><i class="bi bi-box-seam"></i>
                Sản phẩm</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php?page=home">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="index.php?page=product-list">Sản phẩm</a></li>
          <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
      </nav>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow">
            <div class="card-header bg-primary text-white">
              <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Thêm sản phẩm mới</h4>
            </div>
            <div class="card-body p-4">
              <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
              <div class="alert alert-danger alert-dismissible fade show">
                <h6 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Có lỗi:</h6>
                <ul class="mb-0">
                  <?php foreach ($_SESSION['errors'] as $error): ?>
                  <li><?php echo htmlspecialchars($error); ?></li>
                  <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              <?php unset($_SESSION['errors']); ?>
              <?php endif; ?>

              <form method="POST" action="index.php?page=product-store" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="name" name="name"
                    value="<?php echo htmlspecialchars($_SESSION['old']['name'] ?? ''); ?>" required>
                </div>

                <div class="mb-3">
                  <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="price" name="price"
                    value="<?php echo htmlspecialchars($_SESSION['old']['price'] ?? ''); ?>" min="0" step="1000"
                    required>
                </div>

                <div class="mb-3">
                  <label for="description" class="form-label">Mô tả</label>
                  <textarea class="form-control" id="description" name="description"
                    rows="5"><?php echo htmlspecialchars($_SESSION['old']['description'] ?? ''); ?></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label">Hình ảnh sản phẩm</label>
                  <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" data-bs-toggle="tab" href="#upload-tab">
                        <i class="bi bi-upload"></i> Upload ảnh
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-bs-toggle="tab" href="#url-tab">
                        <i class="bi bi-link"></i> Nhập URL
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="upload-tab">
                      <input type="file" class="form-control" name="image" accept="image/*"
                        onchange="previewImage(event)">
                      <small class="text-muted">JPG, PNG, GIF, WEBP - Tối đa 5MB</small>
                      <div id="imagePreview" class="image-preview">
                        <img id="previewImg" src="" alt="Preview">
                      </div>
                    </div>

                    <div class="tab-pane fade" id="url-tab">
                      <input type="url" class="form-control" name="image_url"
                        placeholder="https://example.com/image.jpg">
                      <small class="text-muted">Nhập URL đầy đủ của hình ảnh</small>
                    </div>
                  </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                  <a href="index.php?page=product-list" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                  </a>
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Thêm sản phẩm
                  </button>
                </div>
              </form>
              <?php unset($_SESSION['old']); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('previewImg').src = e.target.result;
          document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
      }
    }
    </script>
  </body>

</html>