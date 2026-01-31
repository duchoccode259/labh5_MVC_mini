<!DOCTYPE html>
<html lang="vi">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    .current-image {
      max-width: 200px;
      border: 2px solid #ddd;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .image-preview {
      max-width: 200px;
      margin-top: 10px;
      border: 2px dashed #28a745;
      padding: 10px;
      border-radius: 5px;
      display: none;
    }

    .image-preview img {
      width: 100%;
      height: auto;
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
          <li class="breadcrumb-item active">Chỉnh sửa</li>
        </ol>
      </nav>

      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow">
            <div class="card-header bg-warning text-dark">
              <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Chỉnh sửa:
                <?php echo htmlspecialchars($product['name']); ?></h4>
            </div>
            <div class="card-body p-4">
              <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
              <div class="alert alert-danger alert-dismissible fade show">
                <h6><i class="bi bi-exclamation-triangle"></i> Có lỗi:</h6>
                <ul class="mb-0">
                  <?php foreach ($_SESSION['errors'] as $error): ?>
                  <li><?php echo htmlspecialchars($error); ?></li>
                  <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              <?php unset($_SESSION['errors']); ?>
              <?php endif; ?>

              <form method="POST" action="index.php?page=product-update" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">

                <div class="mb-3">
                  <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="name" name="name"
                    value="<?php echo htmlspecialchars($_SESSION['old']['name'] ?? $product['name']); ?>" required>
                </div>

                <div class="mb-3">
                  <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="price" name="price"
                    value="<?php echo htmlspecialchars($_SESSION['old']['price'] ?? $product['price']); ?>" min="0"
                    step="1000" required>
                </div>

                <div class="mb-3">
                  <label for="description" class="form-label">Mô tả</label>
                  <textarea class="form-control" id="description" name="description"
                    rows="5"><?php echo htmlspecialchars($_SESSION['old']['description'] ?? $product['description']); ?></textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label">Hình ảnh</label>

                  <?php if (!empty($product['image'])): ?>
                  <div class="mb-2">
                    <label class="form-label text-muted">Ảnh hiện tại:</label>
                    <div>
                      <img src="<?php echo htmlspecialchars(getImageUrl($product['image'])); ?>" alt="Current"
                        class="current-image" onerror="this.src='https://via.placeholder.com/200?text=Error'">
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="keep_old_image" id="keep_old_image" checked>
                      <label class="form-check-label" for="keep_old_image">
                        Giữ ảnh hiện tại
                      </label>
                    </div>
                  </div>
                  <?php endif; ?>

                  <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                      <a class="nav-link active" data-bs-toggle="tab" href="#upload-tab">
                        <i class="bi bi-upload"></i> Upload ảnh mới
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-bs-toggle="tab" href="#url-tab">
                        <i class="bi bi-link"></i> URL mới
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="upload-tab">
                      <input type="file" class="form-control" name="image" accept="image/*"
                        onchange="previewImage(event)">
                      <small class="text-muted">Upload ảnh mới sẽ thay thế ảnh cũ</small>
                      <div id="imagePreview" class="image-preview">
                        <p class="text-success mb-2"><i class="bi bi-check-circle"></i> Ảnh mới:</p>
                        <img id="previewImg" src="" alt="Preview">
                      </div>
                    </div>

                    <div class="tab-pane fade" id="url-tab">
                      <input type="url" class="form-control" name="image_url"
                        placeholder="https://example.com/image.jpg">
                      <small class="text-muted">Nhập URL mới sẽ thay thế ảnh cũ</small>
                    </div>
                  </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                  <a href="index.php?page=product-list" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                  </a>
                  <a href="index.php?page=product-detail&id=<?php echo $product['id']; ?>" class="btn btn-info">
                    <i class="bi bi-eye"></i> Xem chi tiết
                  </a>
                  <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check-circle"></i> Cập nhật
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
          document.getElementById('keep_old_image').checked = false;
        }
        reader.readAsDataURL(file);
      }
    }

    // Uncheck keep_old_image khi nhập URL
    document.querySelector('input[name="image_url"]').addEventListener('input', function() {
      if (this.value) {
        document.getElementById('keep_old_image').checked = false;
      }
    });
    </script>
  </body>

</html>