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
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    <!-- Overlay cho mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="mobile-toggle me-2" id="sidebarToggle">
                ☰
            </button>
            <a class="navbar-brand mx-3" href="/statistics">📚 Quản trị Thư viện</a>
            <div class="d-flex align-items-center mx-3">
                <span class="text-white me-3">Xin chào, <?php echo Session::get('adminName') ?></span>
                <a href="/logout" class="btn btn-outline-light btn-sm">Đăng xuất</a>
            </div>
        </div>
    </header>

    <nav class="sidebar" id="sidebar">
        <h4 class="text-center mb-4">Quản trị</h4>
        <ul class="nav flex-column px-3">
            <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
            
            <li class="nav-item"><a class="nav-link" href="/borrowslips">Danh sách phiếu mượn</a></li>
            <li class="nav-item"><a class="nav-link" href="/dashboard">Thống kê</a></li>
            <li class="nav-item"><a class="nav-link" href="/books">Sách</a></li>
            <li class="nav-item"><a class="nav-link" href="/authors">Tác giả</a></li>
            <li class="nav-item"><a class="nav-link" href="/categories">Thể loại</a></li>
            <li class="nav-item"><a class="nav-link" href="/readers">Độc giả</a></li>
            <li class="nav-item"><a class="nav-link" href="/adminlogs">Log hoạt động admin</a></li>
        </ul>
    </nav>

    <main class="main-content">
        <!-- Nội dung động sẽ được include ở đây -->
        <?php if (isset($content)) echo $content; ?>
    </main>

    <footer class="bg-light text-center py-3 mt-4 border-top">
        &copy; 2025 Nhóm CT467 - Library Management
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');


            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            });

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });

            document.addEventListener('click', function(event) {
                if (window.innerWidth < 768) {
                    if (!sidebar.contains(event.target) &&
                        !sidebarToggle.contains(event.target) &&
                        sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });

            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>