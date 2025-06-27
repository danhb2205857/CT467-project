<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Sách</h2>
    <div>
        <a href="/books/add" class="btn btn-yellow me-2">Thêm sách</a>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/books/export-excel" class="btn btn-success">Xuất Excel</a>
    </div>
</div>
<table class="table table-bordered table-hover bg-white">
    <thead class="table-warning">
        <tr>
            <th>#</th>
            <th>Tên sách</th>
            <th>Tác giả</th>
            <th>Thể loại</th>
            <th>Năm XB</th>
            <th>Nhà XB</th>
            <th>Số lượng</th>
            <th>Hiện có</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($books)) foreach ($books as $i => $book): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($book['title']) ?></td>
            <td><?= htmlspecialchars($book['author_name'] ?? '') ?></td>
            <td><?= htmlspecialchars($book['category_name'] ?? '') ?></td>
            <td><?= htmlspecialchars($book['publish_year']) ?></td>
            <td><?= htmlspecialchars($book['publisher']) ?></td>
            <td><?= htmlspecialchars($book['quantity']) ?></td>
            <td><?= htmlspecialchars($book['available']) ?></td>
            <td>
                <a href="/books/edit/<?= $book['id'] ?>" class="btn btn-sm btn-primary">Sửa</a>
                <a href="/books/delete/<?= $book['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php $content = ob_get_clean(); include __DIR__.'/layout.php';
