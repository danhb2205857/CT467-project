<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Tác giả</h2>
    <div>
        <a href="/authors/add" class="btn btn-yellow me-2">Thêm tác giả</a>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/authors/export-excel" class="btn btn-success">Xuất Excel</a>
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
            <th>Tên tác giả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($authors)) foreach ($authors as $i => $author): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($author['name']) ?></td>
            <td>
                <a href="/authors/edit/<?= $author['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                <a href="/authors/delete/<?= $author['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; 