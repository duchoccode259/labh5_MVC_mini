<!DOCTYPE html>
<html lang="vi">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    .product-image {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 5px;
    }

    .product-name {
      font-weight: 500;
      color: #2c3e50;
    }

    .product-price {
      color: #e74c3c;
      font-weight: 600;
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php?page=home">
                <i class="bi bi-house"></i> Trang chủ
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="index.php?page=product-list">
                <i class="bi bi-box-seam"></i> Sản phẩm
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-4">
      <!-- Tiêu đề và nút thêm mới -->
      <div class="row mb-4">
        <div class="col-md-6">
          <h2>
            <i class="bi bi-box-seam"></i> Danh sách sản phẩm
          </h2>
          <?php if (!empty($message)): ?>
          <p class="text-muted"><?php echo htmlspecialchars($message); ?></p>
          <?php endif; ?>
        </div>
        <div class="col-md-6 text-end">
          <a href="index.php?page=product-add" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
          </a>
        </div>
      </div>

      <!-- Thông báo -->
      <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> <?php echo $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> <?php echo $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <!-- Form tìm kiếm -->
      <div class="card mb-4">
        <div class="card-body">
          <form method="GET" action="index.php" class="row g-3">
            <input type="hidden" name="page" value="product-list">
            <div class="col-md-10">
              <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm theo tên..."
                value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Tìm kiếm
              </button>
            </div>
          </form>
          <?php if (!empty($_GET['search'])): ?>
          <div class="mt-2">
            <a href="index.php?page=product-list" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-x-circle"></i> Xóa bộ lọc
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Bảng sản phẩm -->
      <div class="card">
        <div class="card-body">
          <?php if (!empty($products)): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-primary">
                <tr>
                  <th width="5%">ID</th>
                  <th width="10%">Hình ảnh</th>
                  <th width="25%">Tên sản phẩm</th>
                  <th width="15%">Giá</th>
                  <th width="30%">Mô tả</th>
                  <th width="15%" class="text-center">Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                  <td><?php echo htmlspecialchars($product['id']); ?></td>
                  <td>
                    <?php 
                                        $imageSrc = getImageUrl($product['image']);
                                        ?>
                    <img src="<?php echo htmlspecialchars($imageSrc); ?>"
                      alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image" </td>
                  <td class="product-name">
                    <?php echo htmlspecialchars($product['name']); ?>
                  </td>
                  <td class="product-price">
                    <?php echo number_format($product['price'], 0, ',', '.'); ?> ₫
                  </td>
                  <td>
                    <small class="text-muted">
                      <?php 
                                            $desc = $product['description'] ?? '';
                                            echo htmlspecialchars(mb_substr($desc, 0, 80)) . (mb_strlen($desc) > 80 ? '...' : ''); 
                                            ?>
                    </small>
                  </td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <a href="index.php?page=product-detail&id=<?php echo $product['id']; ?>" class="btn btn-info"
                        title="Xem chi tiết">
                        <i class="bi bi-eye"></i>
                      </a>
                      <a href="index.php?page=product-edit&id=<?php echo $product['id']; ?>" class="btn btn-warning"
                        title="Sửa">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <a href="index.php?page=product-delete&id=<?php echo $product['id']; ?>" class="btn btn-danger"
                        title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                        <i class="bi bi-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <div class="mt-3 text-muted">
            <small>Tổng số: <strong><?php echo count($products); ?></strong> sản phẩm</small>
          </div>
          <?php else: ?>
          <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <p class="text-muted mt-3">Không có sản phẩm nào</p>
            <a href="index.php?page=product-add" class="btn btn-primary">
              <i class="bi bi-plus-circle"></i> Thêm sản phẩm đầu tiên
            </a>
          </div>
          <?php endif; ?>
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