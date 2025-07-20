<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Độc giả</h2>
    <div>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/readers/export-excel" class="btn btn-success">Xuất Excel</a>
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
            <th style="width: 15%;">Tên độc giả</th>
            <th style="width: 10%;">Số điện thoại</th>
            <th class="text-center" style="width: 10%;">Số lần đã mượn</th>
            <th class="text-center" style="width: 15%;">Số sách đã mượn</th>
            <th class="text-center" style="width: 15%;">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($readers)) foreach ($readers as $i => $reader): ?>
            <tr>
                <td class="text-center"><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($reader['name']) ?></td>
                <td><?= htmlspecialchars($reader['phone']) ?></td>
                <td class="text-center" ><?php if(!empty($reader['borrowcount'])): ?>
                    <?= htmlspecialchars($reader['borrowcount']) ?>
                    <?php else: ?>
                        0
                    <?php endif; ?></td>
                <td class="text-center"><?php if(!empty($reader['bookcount'])): ?>
                    <?= htmlspecialchars($reader['bookcount']) ?>
                    <?php else: ?>
                        0
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editReaderModal"
                        data-id="<?= $reader['id'] ?>" data-name="<?= htmlspecialchars($reader['name']) ?>"
                        data-phone="<?= htmlspecialchars($reader['phone']) ?>">
                        Sửa
                    </button>
                    <a href="/readers/delete/<?= $reader['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include_once __DIR__ . '/../components/readers_modal.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alertBox = document.getElementById('alert-message');
        if (alertBox) {
            setTimeout(function() {
                alertBox.remove();
            }, 5000);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var editModal = document.getElementById('editReaderModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                editModal.querySelector('#editReaderId').value = button.getAttribute('data-id');
                editModal.querySelector('#editReaderName').value = button.getAttribute('data-name');
                editModal.querySelector('#editReaderBirthDate').value = button.getAttribute('data-birth_date');
                editModal.querySelector('#editReaderPhone').value = button.getAttribute('data-phone');
                editModal.querySelector('#form').action = '/readers/' + button.getAttribute('data-id');
            });
        }
    });
</script>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>