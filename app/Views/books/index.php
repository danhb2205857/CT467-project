<?php ob_start(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Sách</h2>
    <div>
        <button class="btn btn-yellow me-2" data-bs-toggle="modal" data-bs-target="#addBookModal">Thêm sách</button>
        <button onclick="window.print()" class="btn btn-outline-secondary me-2">In bảng</button>
        <a href="/books/export-excel" class="btn btn-success">Xuất Excel</a>
    </div>
</div>
<?php
$filters = [
    'title' => $_GET['title'] ?? '',
    'author' => $_GET['author'] ?? '',
    'category' => $_GET['category'] ?? '',
    'publisher' => $_GET['publisher'] ?? '',
    'publish_year' => $_GET['publish_year'] ?? '',
];
$hasFilter = false;
foreach ($filters as $v) {
    if ($v !== '' && $v !== null) {
        $hasFilter = true;
        break;
    }
}
?>
<div class="mb-2 d-flex align-items-center flex-wrap">
    <button class="btn btn-outline-primary me-2 mb-1" data-bs-toggle="modal" data-bs-target="#filterModal">
        <i class="bi bi-funnel"></i> LỌC
    </button>
    <?php if (!empty($special_filters)): ?>
        <?php foreach ($special_filters as $type => $filter): ?>
            <span class="badge bg-warning text-dark border me-2 mb-1">
                <?= ucfirst($type) ?>: <?= htmlspecialchars($filter['name']) ?>
                <a href="<?= htmlspecialchars('/books?' . http_build_query(array_merge($filters, [$filter['param'] => '']))) ?>" class="text-decoration-none ms-1" style="color: #888;">&times;</a>
            </span>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if ($hasFilter): ?>
        <?php foreach ($filters as $key => $value): ?>
            <?php if ($value !== '' && $value !== null && $key !== 'author_id' && $key !== 'category_id'): ?>
                <span class="badge bg-light text-dark border me-2 mb-1">
                    <?= htmlspecialchars($value) ?>
                    <a href="<?= htmlspecialchars('/books?' . http_build_query(array_merge($filters, [$key => '']))) ?>" class="text-decoration-none ms-1" style="color: #888;">&times;</a>
                </span>
            <?php endif; ?>
        <?php endforeach; ?>
        <a href="/books" class="ms-2 text-primary text-decoration-none">Xóa tất cả</a>
    <?php else: ?>
        <span class="badge bg-light text-dark border me-2 mb-1">Tất cả</span>
    <?php endif; ?>
</div>
<!-- Modal Lọc -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Lọc sách</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="get" action="/books">
        <div class="modal-body">
          <div class="mb-3">
            <label for="filterTitle" class="form-label">Tên sách</label>
            <input type="text" class="form-control" id="filterTitle" name="title" value="<?= htmlspecialchars($_GET['title'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="filterAuthor" class="form-label">Tác giả</label>
            <input type="text" class="form-control" id="filterAuthor" name="author" value="<?= htmlspecialchars($_GET['author'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="filterCategory" class="form-label">Thể loại</label>
            <input type="text" class="form-control" id="filterCategory" name="category" value="<?= htmlspecialchars($_GET['category'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="filterPublisher" class="form-label">Nhà XB</label>
            <input type="text" class="form-control" id="filterPublisher" name="publisher" value="<?= htmlspecialchars($_GET['publisher'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label for="filterPublishYear" class="form-label">Năm XB</label>
            <input type="number" class="form-control" id="filterPublishYear" name="publish_year" value="<?= htmlspecialchars($_GET['publish_year'] ?? '') ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-yellow">Lọc</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php if (!empty($message)): ?>
    <div id="alert-message" class="alert alert-<?= !empty($status) && $status ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<table class="table table-bordered table-hover bg-white books-table">
    <thead class="table-warning">
        <tr>
            <th class="text-center" style="width:4%">STT</th>
            <th class="text-center">Tên sách</th>
            <th class="text-center">Tác giả</th>
            <th class="text-center">Thể loại</th>
            <th class="text-center">Năm XB</th>
            <th class="text-center">Nhà XB</th>
            <th class="text-center" style="width:6%">Số lượng</th>
            <th class="text-center" style="width:6%">Hiện có</th>
            <th class="text-center" style="width:10%">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($books)) foreach ($books as $i => $book): ?>
            <tr>
                <td class="text-center"><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($book['category_name'] ?? '') ?></td>
                <td class="text-center"><?= htmlspecialchars($book['publish_year']) ?></td>
                <td><?= htmlspecialchars($book['publisher']) ?></td>
                <td class="text-center"><?= htmlspecialchars($book['quantity']) ?></td>
                <td class="text-center"><?= htmlspecialchars($book['available']) ?></td>
                <td class="text-center">
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