<!-- Modal Add Author -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/authors">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addAuthorModalLabel">Thêm tác giả</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="authorName" class="form-label">Tên tác giả</label>
            <input type="text" class="form-control" id="authorName" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Author -->
<div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
      <input type="hidden" name="id" id="editAuthorId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editAuthorModalLabel">Sửa tác giả</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editAuthorName" class="form-label">Tên tác giả</label>
            <input type="text" class="form-control" id="editAuthorName" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
      </div>
    </form>
  </div>
</div>