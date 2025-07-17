<?php ob_start(); ?>
<h1>Danh sách Log Hoạt động Admin</h1>

<div class="d-flex mb-3">
    <button type="button" class="btn btn-sm btn-yellow me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
        <i class="bi bi-funnel"></i> Lọc
    </button>
    <button type="button" class="btn btn-sm btn-yellow me-2" data-bs-toggle="modal" data-bs-target="#statisticsModal" id="btnStatistics">
        <i class="bi bi-bar-chart"></i> Thống kê
    </button>
    <a href="/adminlogs/export" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-download"></i> Xuất CSV
    </a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-warning">
        <tr>
            <th>ID</th>
            <th>Admin ID</th>
            <th>Action Type</th>
            <th>Table</th>
            <th>Record ID</th>
            <th>IP</th>
            <th>User Agent</th>
            <th>Thời gian</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($logs as $log): ?>
        <tr>
            <td><?= $log['id'] ?></td>
            <td><?= $log['admin_id'] ?></td>
            <td><?= $log['action_type'] ?></td>
            <td><?= $log['table_name'] ?></td>
            <td><?= $log['record_id'] ?></td>
            <td><?= $log['ip_address'] ?></td>
            <td><?= htmlspecialchars($log['user_agent']) ?></td>
            <td><?= $log['created_at'] ?></td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-primary view-log-btn" 
                        data-log-id="<?= $log['id'] ?>" data-bs-toggle="modal" data-bs-target="#detailModal">
                    Xem
                </button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Modal Lọc -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Lọc Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm" method="get" action="/adminlogs/filter" class="row g-3">
                    <div class="col-md-6">
                        <label for="admin_id" class="form-label">Admin ID</label>
                        <input type="text" class="form-control" id="admin_id" name="admin_id" placeholder="Admin ID">
                    </div>
                    <div class="col-md-6">
                        <label for="action_type" class="form-label">Loại hành động</label>
                        <input type="text" class="form-control" id="action_type" name="action_type" placeholder="Loại hành động">
                    </div>
                    <div class="col-md-6">
                        <label for="date_from" class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" id="date_from" name="date_from">
                    </div>
                    <div class="col-md-6">
                        <label for="date_to" class="form-label">Đến ngày</label>
                        <input type="date" class="form-control" id="date_to" name="date_to">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-yellow" id="applyFilterBtn">Áp dụng</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chi tiết -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Chi tiết Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <div class="text-center">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thống kê -->
<div class="modal fade" id="statisticsModal" tabindex="-1" aria-labelledby="statisticsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statisticsModalLabel">Thống kê hoạt động Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="statisticsModalBody">
                <div class="text-center">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút lọc
    document.getElementById('applyFilterBtn').addEventListener('click', function() {
        document.getElementById('filterForm').submit();
    });
    
    // Xử lý nút xem chi tiết
    document.querySelectorAll('.view-log-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const logId = this.getAttribute('data-log-id');
            const detailModalBody = document.getElementById('detailModalBody');
            
            // Hiển thị spinner
            detailModalBody.innerHTML = '<div class="text-center"><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Đang tải...</span></div></div>';
            
            // Gọi AJAX để lấy chi tiết
            fetch('/adminlogs/show/' + logId + '?ajax=1')
                .then(response => response.text())
                .then(data => {
                    detailModalBody.innerHTML = data;
                })
                .catch(error => {
                    detailModalBody.innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra khi tải dữ liệu</div>';
                    console.error('Error:', error);
                });
        });
    });
    
    // Xử lý nút thống kê
    document.getElementById('btnStatistics').addEventListener('click', function() {
        const statisticsModalBody = document.getElementById('statisticsModalBody');
        
        // Hiển thị spinner
        statisticsModalBody.innerHTML = '<div class="text-center"><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Đang tải...</span></div></div>';
        
        // Gọi AJAX để lấy thống kê
        fetch('/adminlogs/statistics?ajax=1')
            .then(response => response.text())
            .then(data => {
                statisticsModalBody.innerHTML = data;
            })
            .catch(error => {
                statisticsModalBody.innerHTML = '<div class="alert alert-danger">Có lỗi xảy ra khi tải dữ liệu</div>';
                console.error('Error:', error);
            });
    });
});
</script>

<?php $content = ob_get_clean();
include __DIR__.'/../layout.php'; ?>