<!-- Modal Add Borrow Slip -->
<div class="modal fade" id="addBorrowSlipModal" tabindex="-1" aria-labelledby="addBorrowSlipModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/borrow_slips/add">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBorrowSlipModalLabel">Th?m phi?u m??n</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="borrowSlipReader" class="form-label">??c gi?</label>
            <select class="form-control" id="borrowSlipReader" name="reader_id" required>
              <!-- Option ??c gi? -->
            </select>
          </div>
          <div class="mb-3">
            <label for="borrowDate" class="form-label">Ng?y m??n</label>
            <input type="date" class="form-control" id="borrowDate" name="borrow_date" required>
          </div>
          <div class="mb-3">
            <label for="dueDate" class="form-label">Ng?y tr? d? ki?n</label>
            <input type="date" class="form-control" id="dueDate" name="due_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">L?u</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Borrow Slip -->
<div class="modal fade" id="editBorrowSlipModal" tabindex="-1" aria-labelledby="editBorrowSlipModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/borrow_slips/edit">
      <input type="hidden" name="id" id="editBorrowSlipId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBorrowSlipModalLabel">S?a phi?u m??n</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editBorrowSlipReader" class="form-label">??c gi?</label>
            <select class="form-control" id="editBorrowSlipReader" name="reader_id" required>
              <!-- Option ??c gi? -->
            </select>
          </div>
          <div class="mb-3">
            <label for="editBorrowDate" class="form-label">Ng?y m??n</label>
            <input type="date" class="form-control" id="editBorrowDate" name="borrow_date" required>
          </div>
          <div class="mb-3">
            <label for="editDueDate" class="form-label">Ng?y tr? d? ki?n</label>
            <input type="date" class="form-control" id="editDueDate" name="due_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">C?p nh?t</button>
        </div>
      </div>
    </form>
  </div>
</div>