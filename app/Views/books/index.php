<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Sách</h2>
    <div>
        <button class="btn btn-yellow me-2" data-bs-toggle="modal" data-bs-target="#addBookModal">Thêm sách</button>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/books/export-excel" class="btn btn-success">Xuất Excel</a>
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
            <th>STT</th>
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
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($book['category_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($book['publish_year']) ?></td>
                <td><?= htmlspecialchars($book['publisher']) ?></td>
                <td><?= htmlspecialchars($book['quantity']) ?></td>
                <td><?= htmlspecialchars($book['available']) ?></td>
                <td>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editBookModal"
                        data-id="<?= $book['id'] ?>" data-title="<?= htmlspecialchars($book['title']) ?>"
                        data-author_id="<?= htmlspecialchars($book['author_id']) ?>" data-category_id="<?= htmlspecialchars($book['category_id']) ?>"
                        data-publish_year="<?= htmlspecialchars($book['publish_year']) ?>" data-publisher="<?= htmlspecialchars($book['publisher']) ?>"
                        data-quantity="<?= htmlspecialchars($book['quantity']) ?>">
                        Sửa
                    </button>
                    <a href="/books/delete/<?= $book['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include_once __DIR__ . '/../components/books_modal.php'; ?>
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
        var editModal = document.getElementById('editBookModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                editModal.querySelector('#editBookId').value = id;
                editModal.querySelector('#editBookTitle').value = button.getAttribute('data-title');
                editModal.querySelector('#editBookAuthor').value = button.getAttribute('data-author_id');
                editModal.querySelector('#editBookCategory').value = button.getAttribute('data-category_id');
                editModal.querySelector('#editPublishYear').value = button.getAttribute('data-publish_year');
                editModal.querySelector('#editPublisher').value = button.getAttribute('data-publisher');
                editModal.querySelector('#editQuantity').value = button.getAttribute('data-quantity');

                editModal.querySelector('#editBookForm').action = '/books/' + id;
            });
        }
    });
</script>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>