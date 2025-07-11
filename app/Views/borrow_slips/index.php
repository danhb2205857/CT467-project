<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Phiếu mượn</h2>
    <div>
        <button class="btn btn-yellow me-2" data-bs-toggle="modal" data-bs-target="#addBorrowSlipModal">Thêm phiếu mượn</button>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/borrow_slips/export-excel" class="btn btn-success">Xuất Excel</a>
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
            <th>Ngày mượn</th>
            <th>Ngày trả</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($borrowslips)) foreach ($borrowslips as $i => $slip): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= htmlspecialchars($slip['reader_name']) ?></td>
            <td><?= htmlspecialchars($slip['borrow_date']) ?></td>
            <td><?= htmlspecialchars($slip['due_date']) ?></td>
            <td><?= htmlspecialchars($slip['status']) ?></td>
            <td>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editBorrowSlipModal"
                    data-id="<?= $slip['id'] ?>" data-reader_id="<?= htmlspecialchars($slip['reader_id']) ?>"
                    data-borrow_date="<?= htmlspecialchars($slip['borrow_date']) ?>" data-due_date="<?= htmlspecialchars($slip['due_date']) ?>">
                    Sửa
                </button>
                <a href="/borrow_slips/delete/<?= $slip['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include_once __DIR__ . '/../components/borrow_slips_modal.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editBorrowSlipModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            editModal.querySelector('#editBorrowSlipId').value = button.getAttribute('data-id');
            editModal.querySelector('#editBorrowSlipReader').value = button.getAttribute('data-reader_id');
            editModal.querySelector('#editBorrowDate').value = button.getAttribute('data-borrow_date');
            editModal.querySelector('#editDueDate').value = button.getAttribute('data-due_date');
        });
    }
});
</script>
<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; ?> 