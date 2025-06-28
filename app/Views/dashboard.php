<?php ob_start(); ?>
<div class="container-fluid">
    <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h2>
    <div class="alert alert-info mb-4" style="background: #e3f2fd; color: #1565c0;">
        <strong>Chào mừng Admin Panel</strong><br>
        Chào mừng bạn đến với trang quản trị. Bạn có thể quản lý toàn bộ website từ đây.
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center" style="background: #ede7f6; border: none;">
                <div class="card-body">
                    <div class="mb-2" style="font-size: 2.5rem; color: #7e57c2;"><i class="bi bi-people"></i></div>
                    <h5 class="card-title">Tổng Độc Giả</h5>
                    <h3 class="fw-bold"><?php echo $totalReaders; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center" style="background: #ffe0b2; border: none;">
                <div class="card-body">
                    <div class="mb-2" style="font-size: 2.5rem; color: #ffb300;"><i class="bi bi-tags"></i></div>
                    <h5 class="card-title">Thể Loại</h5>
                    <h3 class="fw-bold"><?php echo $totalCategories; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center" style="background: #b3e5fc; border: none;">
                <div class="card-body">
                    <div class="mb-2" style="font-size: 2.5rem; color: #0288d1;"><i class="bi bi-book"></i></div>
                    <h5 class="card-title">Tổng Sách</h5>
                    <h3 class="fw-bold"><?php echo $totalBooks; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center" style="background: #c8e6c9; border: none;">
                <div class="card-body">
                    <div class="mb-2" style="font-size: 2.5rem; color: #388e3c;"><i class="bi bi-journal-arrow-up"></i></div>
                    <h5 class="card-title">Sách Đang Mượn</h5>
                    <h3 class="fw-bold"><?php echo $totalBorrowedBooks; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
