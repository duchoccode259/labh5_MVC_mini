<!DOCTYPE html>
<html lang="vi">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?php echo htmlspecialchars($product['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    .product-detail-image {
      width: 100%;
      max-width: 400px;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .price-tag {
      font-size: 2rem;
      color: #e74c3c;
      font-weight: bold;
    }

    .info-label {
      font-weight: 600;
      color: #7f8c8d;
      margin-bottom: 5px;
    }

    .info-value {
      font-size: 1.1rem;
      color: #2c3e50;
    }
    </style>
  </head>

  <body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a class="navbar-brand" href="index.php?page=home">
          <i class="bi bi-shop"></i> Quản lý sản phẩm
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=home">
                <i class="bi bi-house"></i> Trang chủ
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=product-list">
                <i class="bi bi-box-seam"></i> Sản phẩm
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-4">
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php?page=home">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="index.php?page=product-list">Sản phẩm</a></li>
          <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
        </ol>
      </nav>

      <!-- Chi tiết sản phẩm -->
      <div class="card">
        <div class="card-body p-4">
          <div class="row">
            <!-- Hình ảnh -->
            <div class="col-md-5 text-center mb-4 mb-md-0">
              <?php 
                        $imageSrc = getImageUrl($product['image']);
                        ?>
              <img src="<?php echo htmlspecialchars($imageSrc); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-detail-image"
            </div>

            <!-- Thông tin -->
            <div class="col-md-7">
              <h2 class="mb-3"><?php echo htmlspecialchars($product['name']); ?></h2>

              <div class="mb-4">
                <span class="price-tag"><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</span>
              </div>

              <div class="mb-4">
                <div class="info-label">Mô tả sản phẩm</div>
                <div class="info-value">
                  <?php 
                                $description = $product['description'] ?? 'Chưa có mô tả';
                                echo nl2br(htmlspecialchars($description)); 
                                ?>
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <div class="info-label">Mã sản phẩm</div>
                  <div class="info-value">#<?php echo str_pad($product['id'], 5, '0', STR_PAD_LEFT); ?></div>
                </div>
                <div class="col-md-6">
                  <div class="info-label">Ngày tạo</div>
                  <div class="info-value">
                    <?php 
                                    if (isset($product['created_at'])) {
                                        echo date('d/m/Y H:i', strtotime($product['created_at']));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                  </div>
                </div>
              </div>

              <!-- Các nút hành động -->
              <div class="d-flex gap-2 flex-wrap">
                <a href="index.php?page=product-edit&id=<?php echo $product['id']; ?>" class="btn btn-warning">
                  <i class="bi bi-pencil"></i> Chỉnh sửa
                </a>
                <a href="index.php?page=product-delete&id=<?php echo $product['id']; ?>" class="btn btn-danger"
                  onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                  <i class="bi bi-trash"></i> Xóa
                </a>
                <a href="index.php?page=product-list" class="btn btn-secondary">
                  <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Thông tin bổ sung -->
      <div class="card mt-4">
        <div class="card-header bg-white">
          <h5 class="mb-0"><i class="bi bi-info-circle"></i> Thông tin chi tiết</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th width="30%" class="bg-light">ID</th>
                  <td><?php echo htmlspecialchars($product['id']); ?></td>
                </tr>
                <tr>
                  <th class="bg-light">Tên sản phẩm</th>
                  <td><?php echo htmlspecialchars($product['name']); ?></td>
                </tr>
                <tr>
                  <th class="bg-light">Giá</th>
                  <td class="text-danger fw-bold"><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</td>
                </tr>
                <tr>
                  <th class="bg-light">Hình ảnh</th>
                  <td><?php echo htmlspecialchars($product['image'] ?: 'Không có'); ?></td>
                </tr>
                <tr>
                  <th class="bg-light">Ngày tạo</th>
                  <td>
                    <?php 
                                    if (isset($product['created_at'])) {
                                        echo date('d/m/Y H:i:s', strtotime($product['created_at']));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                  </td>
                </tr>
                <tr>
                  <th class="bg-light">Cập nhật lần cuối</th>
                  <td>
                    <?php 
                                    if (isset($product['updated_at'])) {
                                        echo date('d/m/Y H:i:s', strtotime($product['updated_at']));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <footer class="mt-5 py-4 bg-white border-top">
      <div class="container text-center text-muted">
        <small>&copy; 2025 Hệ thống quản lý sản phẩm MVC</small>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>

</html>