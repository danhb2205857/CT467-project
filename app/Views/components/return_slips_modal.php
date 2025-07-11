<!-- Modal Add Return Slip -->
<div class="modal fade" id="addReturnSlipModal" tabindex="-1" aria-labelledby="addReturnSlipModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/return_slips/add">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addReturnSlipModalLabel">Th?m phi?u tr?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="returnSlipBorrowSlip" class="form-label">Phi?u m??n</label>
            <select class="form-control" id="returnSlipBorrowSlip" name="borrow_slip_id" required>
              <!-- Option phi?u m??n -->
            </select>
          </div>
          <div class="mb-3">
            <label for="returnDate" class="form-label">Ng?y tr?</label>
            <input type="date" class="form-control" id="returnDate" name="return_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">L?u</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit Return Slip -->
<div class="modal fade" id="editReturnSlipModal" tabindex="-1" aria-labelledby="editReturnSlipModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/return_slips/edit">
      <input type="hidden" name="id" id="editReturnSlipId">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editReturnSlipModalLabel">S?a phi?u tr?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editReturnSlipBorrowSlip" class="form-label">Phi?u m??n</label>
            <select class="form-control" id="editReturnSlipBorrowSlip" name="borrow_slip_id" required>
              <!-- Option phi?u m??n -->
            </select>
          </div>
          <div class="mb-3">
            <label for="editReturnDate" class="form-label">Ng?y tr?</label>
            <input type="date" class="form-control" id="editReturnDate" name="return_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">C?p nh?t</button>
        </div>
      </div>
    </form>
  </div>
</div>