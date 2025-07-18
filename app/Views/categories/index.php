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
    <div id="alert-message" class="alert alert-<?= !empty($status) && $status ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<table class="table table-bordered table-hover bg-white">
    <thead class="table-warning">
        <tr>
            <th class="text-center" style="width: 5%;">STT</th>
            <th style="width: 80%;">Tên thể loại</th>
            <th class="text-center" style="width: 15%;">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($categories)) foreach ($categories as $i => $category): ?>
            <tr class="category-row" style="cursor:pointer" onclick="window.location.href='/books?category_id=<?= $category['id'] ?>'">
                <td class="text-center"><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($category['name']) ?></td>
                <td class="text-center" onclick="event.stopPropagation();">
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
    document.addEventListener('DOMContentLoaded', function() {
        var alertBox = document.getElementById('alert-message');
        if (alertBox) {
            setTimeout(function() {
                alertBox.style.display = 'none';
            }, 5000);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var editModal = document.getElementById('editCategoryModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                editModal.querySelector('#editCategoryId').value = id;
                editModal.querySelector('#editCategoryName').value = name;
                editModal.querySelector('form').action = '/categories/' + id;
            });
        }
    });
</script>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>