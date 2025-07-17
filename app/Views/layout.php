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
        * {
            box-sizing: border-box;
        }
        
        body { 
            background: #fffbe6; 
            margin: 0;
            overflow-x: hidden; /* Ngăn scroll ngang */
        }
        
        header.navbar {
            height: 56px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        
        .sidebar { 
            background: #fffde7; 
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            height: calc(100vh - 56px);
            border-right: 2px solid #ffe082; 
            padding-top: 1rem;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1020;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .sidebar.show {
            transform: translateX(0);
        }
        
        .btn-yellow { 
            background: #ffe082; 
            color: #333; 
        }
        .btn-yellow:hover { 
            background: #ffd54f; 
        }
        
        .sidebar .nav-link { 
            color: #333; 
            border-radius: 4px; 
            margin-bottom: 6px; 
            transition: background 0.2s, color 0.2s; 
            display: block;
            white-space: nowrap;
        }
        
        .sidebar .nav-link.active, 
        .sidebar .nav-link:hover { 
            background: #ffd54f; 
            color: #212529; 
            border-left: 4px solid #ffb300; 
        }
        
        .main-content { 
            min-height: calc(100vh - 56px - 100px);
            margin-left: 0;
            margin-top: 56px; 
            padding: 1rem;
            width: 100%;
            max-width: 100%;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }
        
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1010;
            display: none;
        }
        
        .sidebar-overlay.show {
            display: block;
        }
        
        .container-fluid {
            padding: 0;
            max-width: 100%;
        }
        
        .row {
            margin: 0;
            width: 100%;
        }
        
        footer {
            margin-top: auto;
            width: 100%;
            max-width: 100%;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }
        
        /* Desktop styles */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0); 
            }
            
            .main-content {
                margin-left: 250px;
                width: calc(100% - 250px);
                padding: 1rem 2rem;
            }
            
            footer {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
            
            .mobile-toggle {
                display: none !important;
            }
        }
        
        /* Mobile styles */
        @media (max-width: 767.98px) {
            .sidebar {
                width: 280px; 
            }
            
            .mobile-toggle {
                display: block;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .sidebar .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
            }
        }
        
        /* Tablet styles */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .sidebar {
                width: 220px; 
            }
            
            .main-content {
                margin-left: 220px;
                width: calc(100% - 220px);
            }
            
            footer {
                margin-left: 220px;
                width: calc(100% - 220px);
            }
        }
        
        /* Large desktop styles */
        @media (min-width: 1200px) {
            .main-content {
                padding: 1rem 3rem;
            }
        }
        
        /* Scrollbar styling for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: #fffde7;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #ffe082;
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #ffd54f;
        }
    </style>
</head>
<body>
    <!-- Overlay cho mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <header class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="mobile-toggle me-2" id="sidebarToggle">
                ☰
            </button>
            <a class="navbar-brand" href="/statistics">📚 Quản trị Thư viện</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Xin chào, <?php echo Session::get('adminName') ?></span>
                <a href="/logout" class="btn btn-outline-light btn-sm">Đăng xuất</a>
            </div>
        </div>
    </header>

    <nav class="sidebar" id="sidebar">
        <h4 class="text-center mb-4">Quản trị</h4>
        <ul class="nav flex-column px-3">
            <li class="nav-item"><a class="nav-link" href="/">Thống kê</a></li>
            <li class="nav-item"><a class="nav-link" href="/books">Sách</a></li>
            <li class="nav-item"><a class="nav-link" href="/authors">Tác giả</a></li>
            <li class="nav-item"><a class="nav-link" href="/categories">Thể loại</a></li>
            <li class="nav-item"><a class="nav-link" href="/readers">Độc giả</a></li>
            <li class="nav-item"><a class="nav-link" href="/borrowslips">Phiếu mượn</a></li>
            <li class="nav-item"><a class="nav-link" href="/returnslips">Phiếu trả</a></li>
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