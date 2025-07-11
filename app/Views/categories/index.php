<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Thể loại</h2>
    <div>
        <button class="btn btn-yellow me-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Thêm thể loại</button>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/categories/export-excel" class="btn btn-success">Xuất Excel</a>
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
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                    data-id="<?= $category['id'] ?>" data-name="<?= htmlspecialchars($category['name']) ?>">
                    Sửa
                </button>
                <a href="/categories/delete/<?= $category['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include_once __DIR__ . '/../components/categories_modal.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editCategoryModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            editModal.querySelector('#editCategoryId').value = button.getAttribute('data-id');
            editModal.querySelector('#editCategoryName').value = button.getAttribute('data-name');
        });
    }
});
</script>
<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; ?> 