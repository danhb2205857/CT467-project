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

<!-- Modal Chi tiết Phiếu mượn -->
<div class="modal fade" id="borrowSlipDetailModal" tabindex="-1" aria-labelledby="borrowSlipDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="borrowSlipDetailModalLabel">Chi tiết phiếu mượn</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="borrowSlipDetailInfo">
          <!-- Thông tin phiếu mượn sẽ được render bằng JS -->
        </div>
        <hr>
        <h6>Danh sách sách mượn</h6>
        <div class="table-responsive">
          <table class="table table-bordered align-middle" id="borrowSlipBooksTable">
            <thead class="table-light">
              <tr>
                <th>Tên sách</th>
                <th>Ngày trả dự kiến</th>
                <th>Trạng thái</th>
                <th>Phí phạt</th>
              </tr>
            </thead>
            <tbody>
              <!-- Sách sẽ được render bằng JS -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="submitAllBooksBtn">Trả tất cả sách chưa trả</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>