<!-- Modal Add Book -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/books/add">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBookModalLabel">Th?m s?ch</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="bookTitle" class="form-label">T?n s?ch</label>
            <input type="text" class="form-control" id="bookTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="bookAuthor" class="form-label">T?c gi?</label>
            <select class="form-control" id="bookAuthor" name="author_id" required>
              <!-- Option t?c gi? -->
            </select>
          </div>
          <div class="mb-3">
            <label for="bookCategory" class="form-label">Th? lo?i</label>
            <select class="form-control" id="bookCategory" name="category_id" required>
              <!-- Option th? lo?i -->
            </select>
          </div>
          <div class="mb-3">
            <label for="publishYear" class="form-label">N?m xu?t b?n</label>
            <input type="number" class="form-control" id="publishYear" name="publish_year">
          </div>
          <div class="mb-3">
            <label for="publisher" class="form-label">Nh? xu?t b?n</label>
            <input type="text" class="form-control" id="publisher" name="publisher">
          </div>
          <div class="mb-3">
            <label for="quantity" class="form-label">S? l??ng</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">L?u</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Book -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/books/edit">
      <input type="hidden" name="id" id="editBookId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBookModalLabel">S?a s?ch</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editBookTitle" class="form-label">T?n s?ch</label>
            <input type="text" class="form-control" id="editBookTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="editBookAuthor" class="form-label">T?c gi?</label>
            <select class="form-control" id="editBookAuthor" name="author_id" required>
              <!-- Option t?c gi? -->
            </select>
          </div>
          <div class="mb-3">
            <label for="editBookCategory" class="form-label">Th? lo?i</label>
            <select class="form-control" id="editBookCategory" name="category_id" required>
              <!-- Option th? lo?i -->
            </select>
          </div>
          <div class="mb-3">
            <label for="editPublishYear" class="form-label">N?m xu?t b?n</label>
            <input type="number" class="form-control" id="editPublishYear" name="publish_year">
          </div>
          <div class="mb-3">
            <label for="editPublisher" class="form-label">Nh? xu?t b?n</label>
            <input type="text" class="form-control" id="editPublisher" name="publisher">
          </div>
          <div class="mb-3">
            <label for="editQuantity" class="form-label">S? l??ng</label>
            <input type="number" class="form-control" id="editQuantity" name="quantity" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">C?p nh?t</button>
        </div>
      </div>
    </form>
  </div>
</div>