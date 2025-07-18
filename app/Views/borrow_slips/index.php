<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Phiếu mượn</h2>
    <div>
        <button class="btn btn-yellow me-2" data-bs-toggle="modal" data-bs-target="#addBorrowSlipModal">Thêm phiếu mượn</button>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/borrow_slips/export-excel" class="btn btn-success">Xuất Excel</a>
    </div>
</div>
<!-- Bộ lọc -->
<form class="row g-3 mb-3" method="get" action="">
    <div class="col-md-4">
        <input type="text" class="form-control" name="reader_name" placeholder="Tên độc giả" value="<?= htmlspecialchars($filters['reader_name'] ?? '') ?>">
    </div>
    <div class="col-md-3">
        <select class="form-select" name="status">
            <option value="">-- Trạng thái --</option>
            <option value="Đang mượn" <?= (isset($filters['status']) && $filters['status'] === 'Đang mượn') ? 'selected' : '' ?>>Đang mượn</option>
            <option value="Đã trả" <?= (isset($filters['status']) && $filters['status'] === 'Đã trả') ? 'selected' : '' ?>>Đã trả</option>
            <option value="Quá hạn" <?= (isset($filters['status']) && $filters['status'] === 'Quá hạn') ? 'selected' : '' ?>>Quá hạn</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Lọc</button>
    </div>
    <div class="col-md-2">
        <a href="/borrowslips" class="btn btn-secondary w-100">Bỏ lọc</a>
    </div>
</form>
<?php if (!empty($message)): ?>
    <div id="alert-message" class="alert alert-<?= !empty($status) && $status ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<table class="table table-bordered table-hover bg-white">
    <thead class="table-warning">
        <tr>
            <th class="text-center" width="5%">STT</th>
            <th>Tên độc giả</th>
            <th>Ngày mượn</th>
            <th>Ngày trả</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center" width="10%">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($borrowslips)) foreach ($borrowslips as $i => $slip): ?>
            <tr>
                <td class=" text-center"><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($slip['reader_name']) ?></td>
            <td><?= htmlspecialchars($slip['borrow_date']) ?></td>
            <td><?= htmlspecialchars($slip['due_date']) ?></td>
            <td class="text-center"><?= htmlspecialchars($slip['status']) ?></td>
            <td class="text-center">
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
    document.addEventListener('DOMContentLoaded', function() {
        var editModal = document.getElementById('editBorrowSlipModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                editModal.querySelector('#editBorrowSlipId').value = button.getAttribute('data-id');
                editModal.querySelector('#editBorrowSlipReader').value = button.getAttribute('data-reader_id');
                editModal.querySelector('#editBorrowDate').value = button.getAttribute('data-borrow_date');
                editModal.querySelector('#editDueDate').value = button.getAttribute('data-due_date');
            });
        }
    });
</script>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>