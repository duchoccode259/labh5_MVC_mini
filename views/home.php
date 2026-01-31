<!DOCTYPE html>
<html lang="vi">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Quản lý sản phẩm MVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    .hero-section {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 80px 0;
    }

    .feature-card {
      transition: transform 0.3s;
      height: 100%;
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }

    .stat-card {
      border-left: 4px solid;
    }
    </style>
  </head>

  <body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a class="navbar-brand" href="index.php?page=home">
          <i class="bi bi-shop"></i> Quản lý sản phẩm MVC
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" href="index.php?page=home">
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

    <!-- Hero Section -->
    <div class="hero-section">
      <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">
          <i class="bi bi-rocket-takeoff"></i> <?php echo $message; ?>
        </h1>
        <p class="lead mb-4">Hệ thống quản lý sản phẩm chuyên nghiệp với mô hình MVC</p>
        <div class="d-flex gap-3 justify-content-center">
          <a href="index.php?page=product-list" class="btn btn-light btn-lg">
            <i class="bi bi-box-seam"></i> Xem danh sách sản phẩm
          </a>
          <a href="index.php?page=product-add" class="btn btn-outline-light btn-lg">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
          </a>
        </div>
      </div>
    </div>

    <div class="container mt-5">
      <!-- Thống kê -->
      <div class="row g-4 mb-5">
        <div class="col-md-4">
          <div class="card stat-card border-primary shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-2">Sinh viên trong hệ thống</h6>
                  <h2 class="mb-0 text-primary"><?php echo count($students); ?></h2>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded">
                  <i class="bi bi-people-fill text-primary fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card stat-card border-success shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-2">Dữ liệu Faker</h6>
                  <h2 class="mb-0 text-success">
                    <i class="bi bi-check-circle-fill"></i>
                  </h2>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded">
                  <i class="bi bi-dice-5-fill text-success fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card stat-card border-info shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="text-muted mb-2">Mô hình</h6>
                  <h2 class="mb-0 text-info">MVC</h2>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded">
                  <i class="bi bi-diagram-3-fill text-info fs-1"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Thông tin từ Model Student -->
      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="bi bi-database"></i> Thông tin từ Model Student</h5>
        </div>
        <div class="card-body">
          <p class="mb-0 fs-5"><?php echo $studentInfo; ?></p>
        </div>
      </div>

      <!-- Dữ liệu Faker -->
      <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-person-badge"></i> Dữ liệu ngẫu nhiên từ Faker</h5>
            <small>
              <i class="bi bi-arrow-repeat"></i> F5 để thay đổi
            </small>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="fw-bold text-muted d-block mb-2">
                  <i class="bi bi-person"></i> Họ tên:
                </label>
                <span class="fs-5"><?php echo htmlspecialchars($fakeUser['name']); ?></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="fw-bold text-muted d-block mb-2">
                  <i class="bi bi-geo-alt"></i> Địa chỉ:
                </label>
                <span class="fs-5"><?php echo htmlspecialchars($fakeUser['address']); ?></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="fw-bold text-muted d-block mb-2">
                  <i class="bi bi-envelope"></i> Email:
                </label>
                <span class="fs-5"><?php echo htmlspecialchars($fakeUser['email']); ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tính năng -->
      <h3 class="mb-4 text-center">
        <i class="bi bi-star-fill text-warning"></i> Tính năng của hệ thống
      </h3>
      <div class="row g-4 mb-5">
        <div class="col-md-3">
          <div class="card feature-card shadow-sm border-0">
            <div class="card-body text-center">
              <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                <i class="bi bi-plus-circle-fill text-primary fs-1"></i>
              </div>
              <h5>Thêm sản phẩm</h5>
              <p class="text-muted">Dễ dàng thêm sản phẩm mới vào hệ thống</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card feature-card shadow-sm border-0">
            <div class="card-body text-center">
              <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                <i class="bi bi-pencil-square text-warning fs-1"></i>
              </div>
              <h5>Chỉnh sửa</h5>
              <p class="text-muted">Cập nhật thông tin sản phẩm nhanh chóng</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card feature-card shadow-sm border-0">
            <div class="card-body text-center">
              <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                <i class="bi bi-trash-fill text-danger fs-1"></i>
              </div>
              <h5>Xóa sản phẩm</h5>
              <p class="text-muted">Xóa sản phẩm không cần thiết</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card feature-card shadow-sm border-0">
            <div class="card-body text-center">
              <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                <i class="bi bi-search text-info fs-1"></i>
              </div>
              <h5>Tìm kiếm</h5>
              <p class="text-muted">Tìm kiếm sản phẩm theo tên</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Call to action -->
      <div class="card bg-gradient text-white mb-5 shadow"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body text-center py-5">
          <h3 class="mb-3">Bắt đầu quản lý sản phẩm ngay!</h3>
          <p class="mb-4 lead">Khám phá các tính năng mạnh mẽ của hệ thống</p>
          <a href="index.php?page=product-list" class="btn btn-light btn-lg">
            <i class="bi bi-box-seam"></i> Xem danh sách sản phẩm
          </a>
        </div>
      </div>
    </div>

    <footer class="py-4 bg-white border-top">
      <div class="container text-center text-muted">
        <p class="mb-2">
          <i class="bi bi-code-slash"></i> Xây dựng với mô hình MVC
        </p>
        <small>&copy; 2025 Hệ thống quản lý sản phẩm. Tất cả quyền được bảo lưu.</small>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>

</html>