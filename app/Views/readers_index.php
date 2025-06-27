<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Độc giả</h2>
    <div>
        <a href="/readers/add" class="btn btn-yellow me-2">Thêm độc giả</a>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/readers/export-excel" class="btn btn-success">Xuất Excel</a>
    </div>
</div>
<table class="table table-bordered table-hover bg-white">
    <thead class="table-warning">
        <tr>
            <th>#</th>
            <th>Tên độc giả</th>
            <th>Ngày sinh</th>
            <th>Số điện thoại</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($readers)) foreach ($readers as $i => $reader): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($reader['name']) ?></td>
            <td><?= htmlspecialchars($reader['birth_date']) ?></td>
            <td><?= htmlspecialchars($reader['phone']) ?></td>
            <td>
                <a href="/readers/edit/<?= $reader['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                <a href="/readers/delete/<?= $reader['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include __DIR__.'/layout.php'; 