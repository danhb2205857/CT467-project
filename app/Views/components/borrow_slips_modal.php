<!-- Modal Add Borrow Slip -->
<div class="modal fade" id="addBorrowSlipModal" tabindex="-1" aria-labelledby="addBorrowSlipModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/borrowslips">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBorrowSlipModalLabel">Thêm phiếu mượn</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="borrowSlipReader" class="form-label">Độc giả</label>
            <select class="form-control" id="borrowSlipReader" name="reader_id" required>
              <?php if (!empty($readers)) foreach ($readers as $reader): ?>
                <option value="<?= $reader['id'] ?>"><?= htmlspecialchars($reader['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="dueDate" class="form-label">Ngày trả dự kiến</label>
            <input type="date" class="form-control" id="dueDate" name="due_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Borrow Slip -->
<div class="modal fade" id="editBorrowSlipModal" tabindex="-1" aria-labelledby="editBorrowSlipModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST">
      <input type="hidden" name="id" id="editBorrowSlipId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBorrowSlipModalLabel">Sửa phiếu mượn</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editBorrowSlipReader" class="form-label">Độc giả</label>
            <select class="form-control" id="editBorrowSlipReader" name="reader_id" required>
              <?php if (!empty($readers)) foreach ($readers as $reader): ?>
                <option value="<?= $reader['id'] ?>"><?= htmlspecialchars($reader['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="editDueDate" class="form-label">Ngày trả dự kiến</label>
            <input type="date" class="form-control" id="editDueDate" name="due_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
      </div>
    </form>
  </div>
</div>