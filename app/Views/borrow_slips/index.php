<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Phiếu mượn</h2>
    <div>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/borrow_slips/export-excel" class="btn btn-success">Xuất Excel</a>
    </div>
</div>
<!-- Bộ lọc -->
<div class="d-flex align-items-center mb-3 gap-2">
    <form class="d-flex align-items-center gap-2 mb-0 ms-auto" method="get" action="" style="flex-wrap:nowrap;">
        <input type="text" class="form-control" name="phone" placeholder="Số điện thoại..." value="<?= htmlspecialchars($filters['phone'] ?? '') ?>" style="width:180px;">
        <select class="form-select" name="status" style="width:120px;">
            <option value="">Tất cả</option>
            <option value="0" <?= (isset($filters['status']) && $filters['status'] === '0') ? 'selected' : '' ?>>Đang mượn</option>
            <option value="1" <?= (isset($filters['status']) && $filters['status'] === '1') ? 'selected' : '' ?>>Đã trả</option>
            <option value="2" <?= (isset($filters['status']) && $filters['status'] === '2') ? 'selected' : '' ?>>Quá hạn</option>
        </select>
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
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
            <th>Số điện thoại</th>
            <th>Tên độc giả</th>
            <th>Ngày mượn</th>
            <th>Ngày trả dự kiến</th>
            <th>Ngày trả</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center" width="17%">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($borrowslips)) foreach ($borrowslips as $slip): ?>
            <tr data-slip-id="<?= $slip['id'] ?>">
                <td class="clickable-cell"><?= htmlspecialchars($slip['phone']) ?></td>
                <td class="clickable-cell"><?= htmlspecialchars($slip['name']) ?></td>
                <td class="clickable-cell"><?= htmlspecialchars($slip['borrow_date']) ?></td>
                <td class="clickable-cell"><?= htmlspecialchars($slip['due_date']) ?></td>
                <td class="clickable-cell">
                    <?php if (!empty($slip['return_date'])): ?>
                        <?= htmlspecialchars($slip['return_date']) ?>
                    <?php else: ?>
                        <span class="text-danger">Chưa trả</span>
                    <?php endif; ?>
                </td>

                <td class="clickable-cell text-center">
                    <?php if ($slip['status'] == 0): ?>
                        <span class="text-primary">Đang mượn</span>
                    <?php elseif ($slip['status'] == 1): ?>
                        <span class="text-success">Đã trả</span>
                    <?php else: ?>
                        <span class="text-danger">Quá hạn</span>
                    <?php endif; ?>


                </td>

                <td class="text-center">
                    <?php if ($slip['status'] == 0 || $slip['status'] == 2): ?>
                        <a href="/borrowslips/submit/<?= $slip['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Xác nhận đã hoàn tất phiếu mượn?')">Xác nhận</a>
                    <?php endif; ?>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editBorrowSlipModal"
                    data-id="<?= $slip['id'] ?>" data-reader_id="<?= htmlspecialchars($slip['reader_id']) ?>"
                    data-borrow_date="<?= htmlspecialchars($slip['borrow_date']) ?>" data-due_date="<?= htmlspecialchars($slip['due_date']) ?>">
                    Sửa
                </button>
                <a href="/borrowslips/delete/<?= $slip['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include_once __DIR__ . '/../components/borrow_slips_modal.php'; ?>
<script>document.addEventListener('DOMContentLoaded', function() {
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

    // class clickable-cell
    document.querySelectorAll('td.clickable-cell').forEach(function(cell) {
        cell.style.cursor = 'pointer';
        cell.addEventListener('click', function(e) {
            var row = cell.closest('tr[data-slip-id]');
            var slipId = row ? row.getAttribute('data-slip-id') : null;
            if (!slipId) return;
            fetch('/borrowslips/details/' + slipId)
                .then(res => res.json())
                .then(data => {
                    if (!data.status) return alert('Không lấy được chi tiết phiếu mượn!');
                    var slip = data.slip;
                    var infoHtml = `<div class='row mb-2'>
                        <div class='col-md-6'><b>Số điện thoại:</b> ${slip.phone || ''}</div>
                        <div class='col-md-6'><b>Tên độc giả:</b> ${slip.reader_name || slip.name || ''}</div>
                    </div>
                    <div class='row mb-2'>
                        <div class='col-md-6'><b>Ngày mượn:</b> ${slip.borrow_date || ''}</div>
                        <div class='col-md-6'><b>Ngày trả dự kiến:</b> ${slip.due_date || ''}</div>
                    </div>
                    <div class='row mb-2'>
                        <div class='col-md-6'><b>Ngày trả:</b> ${slip.return_date || '<span class="text-danger">Chưa trả</span>'}</div>
                        <div class='col-md-6'><b>Trạng thái:</b> ${slip.status == 0 ? '<span class="text-primary">Đang mượn</span>' : (slip.status == 1 ? '<span class="text-success">Đã trả</span>' : '<span class="text-danger">Quá hạn</span>')}</div>
                    </div>`;
                    document.getElementById('borrowSlipDetailInfo').innerHTML = infoHtml;
                    var booksHtml = '';
                    let hasUnreturned = false;
                    data.books.forEach(function(book) {
                        let returned = book.returned == 1;
                        if (!returned) hasUnreturned = true;
                        booksHtml += `<tr>
                            <td>${book.book_title || ''}</td>
                            <td>${book.due_date ? book.due_date : ''}</td>
                            <td>${book.return_date ? '<span class="text-success">Đã trả</span>' : '<span class="text-danger">Chưa trả</span>'}</td>
                            <td>${book.fine_amount}</td>
                        </tr>`;
                    });
                    document.querySelector('#borrowSlipBooksTable tbody').innerHTML = booksHtml;
                    document.getElementById('submitAllBooksBtn').style.display = hasUnreturned ? '' : 'none';
                    document.querySelectorAll('.submit-book-btn').forEach(function(btn) {
                        btn.onclick = function(ev) {
                            ev.stopPropagation();
                            var detailId = btn.getAttribute('data-detail-id');
                            if (!detailId) return;
                            btn.disabled = true;
                            fetch('/borrowslips/submit-book/' + detailId, { method: 'POST' })
                                .then(res => res.json())
                                .then(resp => {
                                    if (resp.status) {
                                        btn.closest('tr').querySelector('td:nth-child(2)').innerHTML = '<span class="text-success">Đã trả</span>';
                                        btn.closest('tr').querySelector('td:nth-child(3)').innerHTML = (new Date()).toISOString().slice(0, 19).replace('T', ' ');
                                        btn.remove();
                                        if (!document.querySelector('.submit-book-btn')) document.getElementById('submitAllBooksBtn').style.display = 'none';
                                    } else {
                                        alert('Trả sách thất bại!');
                                        btn.disabled = false;
                                    }
                                });
                        };
                    });
                    document.getElementById('submitAllBooksBtn').onclick = function() {
                        this.disabled = true;
                        fetch('/borrowslips/submit-all/' + slip.id, { method: 'POST' })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.status) {
                                    document.querySelectorAll('.submit-book-btn').forEach(function(btn) {
                                        btn.closest('tr').querySelector('td:nth-child(2)').innerHTML = '<span class="text-success">Đã trả</span>';
                                        btn.closest('tr').querySelector('td:nth-child(3)').innerHTML = (new Date()).toISOString().slice(0, 19).replace('T', ' ');
                                        btn.remove();
                                    });
                                    this.style.display = 'none';
                                } else {
                                    alert('Trả sách thất bại!');
                                    this.disabled = false;
                                }
                            },this);
                    };
                    var detailModal = new bootstrap.Modal(document.getElementById('borrowSlipDetailModal'));
                    detailModal.show();
                });
        });
    });
});
</script>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>