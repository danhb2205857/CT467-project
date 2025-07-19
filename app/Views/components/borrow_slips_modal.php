<!-- Modal Add Borrow Slip -->
<div class="modal fade" id="addBorrowSlipModal" tabindex="-1" aria-labelledby="addBorrowSlipModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/borrowslips">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBorrowSlipModalLabel">Tạo phiếu mới</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="borrowSlipPhone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="borrowSlipPhone" name="phone" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="borrowSlipReaderName" class="form-label">Tên độc giả</label>
            <input type="text" class="form-control" id="borrowSlipReaderName" name="reader_name" required>
          </div>
          <div class="mb-3">
            <label for="dueDate" class="form-label">Ngày trả dự kiến</label>
            <input type="date" class="form-control" id="dueDate" name="due_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Tạo</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  // Khi blur input số điện thoại, fetch tên độc giả nếu có
  document.addEventListener('DOMContentLoaded', function() {
    var phoneInput = document.getElementById('borrowSlipPhone');
    var nameInput = document.getElementById('borrowSlipReaderName');
    if (phoneInput && nameInput) {
      phoneInput.addEventListener('blur', function() {
        var phone = phoneInput.value.trim();
        if (phone.length > 0) {
          fetch('/readers/find-by-phone?phone=' + encodeURIComponent(phone))
            .then(res => res.json())
            .then(data => {
              if (data && data.name) {
                nameInput.value = data.name;
              } else {
                nameInput.placeholder = 'Độc giả mới';
              }
            })
            .catch(() => {
              nameInput.value = '';
            });
        } else {
          nameInput.value = '';
        }
      });
    }
  });
</script>

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