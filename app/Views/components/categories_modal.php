<!-- Modal Add Category -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/categories">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryModalLabel">Thêm thể loại</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="categoryName" class="form-label">Tên thể loại</label>
            <input type="text" class="form-control" id="categoryName" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Category -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
      <input type="hidden" name="id" id="editCategoryId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCategoryModalLabel">Sửa tên thể loại</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editCategoryName" class="form-label">Tên thể loại</label>
            <input type="text" class="form-control" id="editCategoryName" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
      </div>
    </form>
  </div>
</div>