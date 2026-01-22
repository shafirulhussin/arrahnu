<?php
session_start();
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{--primary-blue:#0f172a;--accent-gold:#c5a059}
        body{background-color:#f8f9fa}
        .card-custom{border:none;border-radius:10px;box-shadow:0 4px 15px rgba(0,0,0,.1);overflow:hidden}
        .card-header-custom{background-color:var(--primary-blue);color:#fff;padding:20px;border-bottom:2px solid var(--accent-gold)}
        .btn-custom{background-color:var(--accent-gold);color:var(--primary-blue);font-weight:bold;border:none}
        .btn-custom:hover{background-color:#b38f4d;color:#fff}
        .form-control:focus{border-color:var(--accent-gold);box-shadow:0 0 0 .25rem rgba(197,160,89,.25)}
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-custom">
                    <div class="card-header card-header-custom text-center">
                        <h4 class="mb-0">Log Masuk Ar-Rahnu</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form method="post" action="do_login.php">
                            <div class="mb-3">
                                <label for="ic" class="form-label">IC</label>
                                <input type="text" id="ic" name="ic" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="kata_laluan" class="form-label">Kata Laluan</label>
                                <input type="password" id="kata_laluan" name="kata_laluan" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom btn-lg">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

