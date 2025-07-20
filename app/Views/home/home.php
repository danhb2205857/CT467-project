<?php ob_start(); ?>
<?php if (!empty($message)): ?>
    <div id="alert-message" class="alert alert-<?= !empty($status) && $status ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<div class="container py-5 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="max-width: 900px; width: 100%; border-radius: 18px;">
        <h3 class="text-center mb-4" style="font-size: 2.2rem; font-weight: 600;">Tạo phiếu mượn</h3>
        <form id="borrowForm" method="POST" action="/borrowslips">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="borrowSlipPhone" class="form-label" style="font-size: 1.2rem;">Số điện thoại:</label>
                        <input type="text" class="form-control form-control-lg" id="borrowSlipPhone" name="phone" placeholder="Số điện thoại..." required autocomplete="off" style="font-size: 1.15rem; padding: 14px;">
                    </div>
                    <div class="mb-3">
                        <label for="borrowSlipReaderName" class="form-label" style="font-size: 1.2rem;">Tên độc giả:</label>
                        <input type="text" class="form-control form-control-lg" id="borrowSlipReaderName" name="reader_name" placeholder="" required style="font-size: 1.15rem; padding: 14px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="bookCodeInput" class="form-label" style="font-size: 1.2rem;">Truyện:</label>
                        <input type="text" class="form-control form-control-lg" id="bookCodeInput" placeholder="Nhập mã truyện..." style="font-size: 1.15rem; padding: 14px;">
                        <div id="bookTitleResult" class="mt-2"></div>
                        <div id="selectedBooks" class="mt-2"></div>
                    </div>
                    <div class="mb-3">
                        <label for="dueDate" class="form-label" style="font-size: 1.2rem;">Ngày dự kiến trả</label>
                        <input type="date" class="form-control form-control-lg" id="dueDate" name="due_date" required style="font-size: 1.15rem; padding: 14px;">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary w-50 py-3" style="font-size: 1.3rem; font-weight: 600; border-radius: 10px;">Thêm</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var alertBox = document.getElementById('alert-message');
        if (alertBox) {
            setTimeout(function() {
                alertBox.remove();
            }, 5000);
        }
    });

    // Tự động focus sang trường tiếp theo
    document.addEventListener('DOMContentLoaded', function() {
        var phoneInput = document.getElementById('borrowSlipPhone');
        var nameInput = document.getElementById('borrowSlipReaderName');
        var bookCodeInput = document.getElementById('bookCodeInput');
        var dueDateInput = document.getElementById('dueDate');
        if (phoneInput && nameInput && bookCodeInput && dueDateInput) {
            phoneInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    nameInput.focus();
                }
            });
            nameInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    bookCodeInput.focus();
                }
            });
            bookCodeInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    // Nếu có kết quả truyện, chọn luôn truyện đầu tiên
                    var addBtn = document.getElementById('addBookBtn');
                    if (addBtn) addBtn.click();
                }
            });
        }

        // Fetch tên độc giả khi blur số điện thoại
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
                                nameInput.value = '';
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

        // Logic chọn truyện
        var bookTitleResult = document.getElementById('bookTitleResult');
        var selectedBooks = document.getElementById('selectedBooks');
        var selectedBookIds = [];
        var selectedBookTitles = [];

        bookCodeInput.addEventListener('input', function() {
            var code = bookCodeInput.value.trim();
            if (code.length > 0 && !isNaN(code)) {
                fetch('/books/find-by-id?id=' + encodeURIComponent(code))
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.title) {
                            bookTitleResult.innerHTML =
                                `<div class='d-flex align-items-center gap-2'><span class='badge bg-secondary' style='font-size:1.1rem;'>${data.title}</span>` +
                                (selectedBookIds.includes(data.id.toString()) ?
                                    `<span class='text-success ms-2'>Đã chọn</span>` :
                                    `<button type='button' class='btn btn-sm btn-outline-primary ms-2' id='addBookBtn' style='font-size:1rem;'>Chọn</button>`) +
                                `</div>`;
                            if (!selectedBookIds.includes(data.id.toString())) {
                                document.getElementById('addBookBtn').onclick = function() {
                                    selectedBookIds.push(data.id.toString());
                                    selectedBookTitles.push(data.title);
                                    renderSelectedBooks();
                                    bookCodeInput.value = '';
                                    bookTitleResult.innerHTML = '';
                                    bookCodeInput.focus();
                                }
                            }
                        } else {
                            bookTitleResult.innerHTML = `<span class='text-danger'>Không tìm thấy truyện</span>`;
                        }
                    })
                    .catch(() => {
                        bookTitleResult.innerHTML = `<span class='text-danger'>Không tìm thấy truyện</span>`;
                    });
            } else {
                bookTitleResult.innerHTML = '';
            }
        });

        function renderSelectedBooks() {
            selectedBooks.innerHTML = '';
            selectedBookIds.forEach(function(id, idx) {
                var badge = document.createElement('span');
                badge.className = 'badge bg-light text-dark border me-2 mb-1';
                badge.style.fontSize = '1.1rem';
                badge.innerHTML = `${selectedBookTitles[idx]} <a href="#" class="text-decoration-none ms-1" style="color: #888; font-size:1.2em;" data-id="${id}">&times;</a>`;
                badge.querySelector('a').onclick = function(e) {
                    e.preventDefault();
                    var removeIdx = selectedBookIds.indexOf(id);
                    if (removeIdx > -1) {
                        selectedBookIds.splice(removeIdx, 1);
                        selectedBookTitles.splice(removeIdx, 1);
                        renderSelectedBooks();
                    }
                };
                selectedBooks.appendChild(badge);
            });
            // Cập nhật hidden input cho form submit
            var oldInput = document.getElementById('selectedBookIdsInput');
            if (oldInput) oldInput.remove();
            if (selectedBookIds.length > 0) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'book_ids';
                input.id = 'selectedBookIdsInput';
                input.value = selectedBookIds.join(',');
                document.getElementById('borrowForm').appendChild(input);
            }
        }
    });
</script>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>