<!-- Modal Add Reader -->
<div class="modal fade" id="addReaderModal" tabindex="-1" aria-labelledby="addReaderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/readers">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addReaderModalLabel">Thêm độc giả</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="readerName" class="form-label">Tên độc giả</label>
            <input type="text" class="form-control" id="readerName" name="name" required>
          </div>
          <div class="mb-3">
            <label for="readerBirthDate" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="readerBirthDate" name="birth_date">
          </div>
          <div class="mb-3">
            <label for="readerPhone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="readerPhone" name="phone">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Reader -->
<div class="modal fade" id="editReaderModal" tabindex="-1" aria-labelledby="editReaderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
      <input type="hidden" name="id" id="editReaderId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editReaderModalLabel">Sửa thông tin độc giả</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editReaderName" class="form-label">Tên độc giả</label>
            <input type="text" class="form-control" id="editReaderName" name="name" required>
          </div>
          <div class="mb-3">
            <label for="editReaderBirthDate" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="editReaderBirthDate" name="birth_date">
          </div>
          <div class="mb-3">
            <label for="editReaderPhone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="editReaderPhone" name="phone">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
      </div>
    </form>
  </div>
</div>