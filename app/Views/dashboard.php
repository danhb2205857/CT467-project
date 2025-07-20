<?php ob_start(); ?>
<style>
    .card.stat-card {
        min-height: 100px;
    }

    .card.stat-card .card-body {
        padding: 8px;
    }
</style>
<div class="container-fluid">
    <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= !empty($status) && $status ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="row g-2">
        <div class="col-md-3">
            <div class="card stat-card shadow-sm text-center" style="background: #ede7f6; border: none;">
                <div class="card-body">
                    <div class="mb-2" style="font-size: 2.2rem; color: #7e57c2;"><i class="bi bi-people"></i></div>
                    <h6 class="card-title">Tổng Độc Giả</h6>
                    <h3 class="fw-bold"><?php echo $totalReaders; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm text-center" style="background: #ffe0b2; border: none;">
                <div class="card-body">
                    <div class="mb-2" style="font-size: 2.2rem; color: #ffb300;"><i class="bi bi-tags"></i></div>
                    <h6 class="card-title">Thể Loại</h6>
                    <h3 class="fw-bold"><?php echo $totalCategories; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm text-center" style="background: #b3e5fc; border: none;">
                <div class="card-body">
                    <div class="mb-2" style="font-size: 2.2rem; color: #0288d1;"><i class="bi bi-book"></i></div>
                    <h6 class="card-title">Tổng Sách</h6>
                    <h3 class="fw-bold"><?php echo $totalBooks; ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm text-center" style="background: #c8e6c9; border: none;">
                <div class="card-body">
                    <div class="mb-2" style="font-size: 2.2rem; color: #388e3c;"><i class="bi bi-journal-arrow-up"></i></div>
                    <h6 class="card-title">Sách Đang Mượn</h6>
                    <h3 class="fw-bold"><?php echo $totalBorrowedBooks; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Top 10 độc giả mượn nhiều sách nhất</div>
                <div class="card-body p-2">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Top</th>
                                <th>Tên độc giả</th>
                                <th>Số điện thoại</th>
                                <th class="text-end">Số sách đã mượn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top10Readers as $i => $reader): ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td><?= htmlspecialchars($reader['name']) ?></td>
                                    <td><?= htmlspecialchars($reader['phone']) ?></td>
                                    <td class="text-end"><?= (int)$reader['bookcount'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">Top 10 sách được mượn nhiều nhất</div>
                <div class="card-body">
                    <canvas id="topBooksChart" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('topBooksChart').getContext('2d');
        var bookLabels = <?php echo json_encode(array_column($top10Books, 'title')); ?>;
        var bookData = <?php echo json_encode(array_map('intval', array_column($top10Books, 'total_borrowed'))); ?>;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bookLabels,
                datasets: [{
                    label: 'Lượt mượn',
                    data: bookData,
                    backgroundColor: '#ffd54f',
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>