<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Phiếu trả</h2>
    <div>
        <a href="/returnslips/add" class="btn btn-yellow me-2">Thêm phiếu trả</a>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/returnslips/export-excel" class="btn btn-success">Xuất Excel</a>
    </div>
</div>
<?php if (!empty($message)): ?>
    <div class="alert alert-<?= !empty($status) && $status ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<table class="table table-bordered table-hover bg-white">
    <thead class="table-warning">
        <tr>
            <th>#</th>
            <th>Tên độc giả</th>
            <th>Tên sách</th>
            <th>Ngày trả</th>
            <th>Tiền phạt</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($returnslips)) foreach ($returnslips as $i => $slip): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($slip['reader_name']) ?></td>
            <td><?= htmlspecialchars($slip['book_title']) ?></td>
            <td><?= htmlspecialchars($slip['return_date']) ?></td>
            <td><?= htmlspecialchars($slip['fine']) ?></td>
            <td>
                <a href="/returnslips/edit/<?= $slip['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                <a href="/returnslips/delete/<?= $slip['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include __DIR__.'/layout.php'; 