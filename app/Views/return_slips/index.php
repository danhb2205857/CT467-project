<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Phiếu trả</h2>
    <div>
        <button class="btn btn-yellow me-2" data-bs-toggle="modal" data-bs-target="#addReturnSlipModal">Thêm phiếu trả</button>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/return_slips/export-excel" class="btn btn-success">Xuất Excel</a>
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
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editReturnSlipModal"
                    data-id="<?= $slip['id'] ?>" data-borrow_slip_id="<?= htmlspecialchars($slip['borrow_slip_id']) ?>"
                    data-return_date="<?= htmlspecialchars($slip['return_date']) ?>">
                    Sửa
                </button>
                <a href="/return_slips/delete/<?= $slip['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include_once __DIR__ . '/../components/return_slips_modal.php'; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editReturnSlipModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            editModal.querySelector('#editReturnSlipId').value = button.getAttribute('data-id');
            editModal.querySelector('#editReturnSlipBorrowSlip').value = button.getAttribute('data-borrow_slip_id');
            editModal.querySelector('#editReturnDate').value = button.getAttribute('data-return_date');
        });
    }
});
</script>
<?php $content = ob_get_clean(); include __DIR__.'/../layout.php'; ?> 