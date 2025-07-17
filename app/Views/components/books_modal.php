<!-- Modal Add Book -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/books">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBookModalLabel">Thêm sách</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="bookTitle" class="form-label">Tên sách</label>
            <input type="text" class="form-control" id="bookTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="bookAuthor" class="form-label">Tác giả</label>
            <select class="form-control" id="bookAuthor" name="author_id" required>
              <?php if (!empty($authors)) foreach ($authors as $author): ?>
                <option value="<?= $author['id'] ?>"><?= htmlspecialchars($author['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="bookCategory" class="form-label">Thể loại</label>
            <select class="form-control" id="bookCategory" name="category_id" required>
              <?php if (!empty($categories)) foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="publishYear" class="form-label">Năm xuất bản</label>
            <input type="number" class="form-control" id="publishYear" name="publish_year">
          </div>
          <div class="mb-3">
            <label for="publisher" class="form-label">Nhà xuất bản</label>
            <input type="text" class="form-control" id="publisher" name="publisher">
          </div>
          <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Book -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="editBookForm">
      <input type="hidden" name="id" id="editBookId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBookModalLabel">Chỉnh sửa sách</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editBookTitle" class="form-label">Tên sách</label>
            <input type="text" class="form-control" id="editBookTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="editBookAuthor" class="form-label">Tác giả</label>
            <select class="form-control" id="editBookAuthor" name="author_id" required>
              <?php if (!empty($authors)) foreach ($authors as $author): ?>
                <option value="<?= $author['id'] ?>"><?= htmlspecialchars($author['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="editBookCategory" class="form-label">Thể loại</label>
            <select class="form-control" id="editBookCategory" name="category_id" required>
              <?php if (!empty($categories)) foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="editPublishYear" class="form-label">Năm xuất bản</label>
            <input type="number" class="form-control" id="editPublishYear" name="publish_year">
          </div>
          <div class="mb-3">
            <label for="editPublisher" class="form-label">Nhà xuất bản</label>
            <input type="text" class="form-control" id="editPublisher" name="publisher">
          </div>
          <div class="mb-3">
            <label for="editQuantity" class="form-label">Số lượng</label>
            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
      </div>
    </form>
  </div>
</div>