<?php
    use App\Core\Session;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị Thư viện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fffbe6; }
        .sidebar { background: #fffde7; min-height: 100vh; border-right: 2px solid #ffe082; }
        .btn-yellow { background: #ffe082; color: #333; }
        .btn-yellow:hover { background: #ffd54f; }
        .sidebar .nav-link { color: #333; border-radius: 4px; margin-bottom: 6px; transition: background 0.2s, color 0.2s; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background: #ffd54f; color: #212529; border-left: 4px solid #ffb300; }
        .main-content { min-height: 80vh; }
    </style>
</head>
<body>
<header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/statistics">📚 Quản trị Thư viện</a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3">Xin chào, <?php echo Session::get('adminName') ?></span>
            <a href="/logout" class="btn btn-outline-light btn-sm">Đăng xuất</a>
        </div>
    </div>
</header>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar py-4">
            <h4 class="text-center mb-4">Quản trị</h4>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="/">Thống kê</a></li>
                <li class="nav-item"><a class="nav-link" href="/books">Sách</a></li>
                <li class="nav-item"><a class="nav-link" href="/authors">Tác giả</a></li>
                <li class="nav-item"><a class="nav-link" href="/categories">Thể loại</a></li>
                <li class="nav-item"><a class="nav-link" href="/readers">Độc giả</a></li>
                <li class="nav-item"><a class="nav-link" href="/borrowslips">Phiếu mượn</a></li>
                <li class="nav-item"><a class="nav-link" href="/returnslips">Phiếu trả</a></li>
            </ul>
        </nav>
        <main class="col-md-10 ms-sm-auto px-md-4 py-4 main-content">
            <!-- Nội dung động sẽ được include ở đây -->
            <?php if (isset($content)) echo $content; ?>
        </main>
    </div>
</div>
<footer class="bg-light text-center py-3 mt-4 border-top">
    &copy; 2025 Nhóm CT467 - Library Management
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
