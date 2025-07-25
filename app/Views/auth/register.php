<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>??ng k? - Qu?n tr? Th? vi?n</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background: #fffbe6; }
        .register-container { max-width: 420px; margin: 60px auto; background: #fffde7; border-radius: 12px; box-shadow: 0 2px 8px #ffe082; padding: 32px; }
        .btn-yellow { background: #ffe082; color: #333; }
        .btn-yellow:hover { background: #ffd54f; }
        .form-icon { font-size: 1.5rem; color: #ffb300; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="text-center mb-4">
            <i class="bi bi-person-plus form-icon"></i>
            <h3 class="mt-2">??ng k? t?i kho?n</h3>
        </div>
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= !empty($status) && $status ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="name" class="form-label">H? v? t?n</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Nh?p h? t?n">
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Nh?p email">
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">M?t kh?u</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Nh?p m?t kh?u">
                </div>
            </div>
            <div class="mb-3">
                <label for="password_confirm" class="form-label">Nh?p l?i m?t kh?u</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required placeholder="Nh?p l?i m?t kh?u">
                </div>
            </div>
            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-yellow"><i class="bi bi-person-plus me-1"></i> ??ng k?</button>
            </div>
            <div class="text-center">
                <a href="/login" class="text-decoration-none"><i class="bi bi-box-arrow-in-right"></i> ?? c? t?i kho?n? ??ng nh?p</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
