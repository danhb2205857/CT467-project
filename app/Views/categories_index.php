<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Thể loại</h2>
    <div>
        <a href="/categories/add" class="btn btn-yellow me-2">Thêm thể loại</a>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/categories/export-excel" class="btn btn-success">Xuất Excel</a>
    </div>
</div>
<table class="table table-bordered table-hover bg-white">
    <thead class="table-warning">
        <tr>
            <th>#</th>
            <th>Tên thể loại</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($categories)) foreach ($categories as $i => $category): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($category['name']) ?></td>
            <td>
                <a href="/categories/edit/<?= $category['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                <a href="/categories/delete/<?= $category['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include __DIR__.'/layout.php'; 