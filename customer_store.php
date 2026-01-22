<?php
session_start();
require __DIR__ . '/db.php';
function clean($v){ return htmlspecialchars(trim($v ?? ''), ENT_QUOTES, 'UTF-8'); }
$nama = clean($_POST['nama'] ?? '');
$ic = clean($_POST['ic'] ?? '');
$no_telefon = clean($_POST['no_telefon'] ?? '');
$emel = clean($_POST['emel'] ?? '');
$bank_nama = clean($_POST['bank_nama'] ?? '');
$bank_no_akaun = clean($_POST['bank_no_akaun'] ?? '');
if ($nama === '' || $ic === '' || $no_telefon === '') {
    http_response_code(400);
    echo 'Ruangan wajib tidak lengkap';
    exit;
}
if (!preg_match('/^\d{6}-\d{2}-\d{4}$/', $ic)) {
    http_response_code(400);
    echo 'Format MyKad tidak sah';
    exit;
}
if ($emel !== '' && !filter_var($emel, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo 'Format emel tidak sah';
    exit;
}
$stmt = $pdo->prepare('SELECT id FROM customers WHERE ic = ? LIMIT 1');
$stmt->execute([$ic]);
if ($stmt->fetchColumn()) {
    http_response_code(409);
    echo 'MyKad telah wujud';
    exit;
}
$ins = $pdo->prepare('INSERT INTO customers (nama, ic, no_telefon, emel, bank_nama, bank_no_akaun) VALUES (?, ?, ?, ?, ?, ?)');
$ins->execute([$nama, $ic, $no_telefon, $emel, $bank_nama, $bank_no_akaun]);
$id = $pdo->lastInsertId();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berjaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{--primary-blue:#0f172a;--accent-gold:#c5a059}
        .card-header{background-color:var(--primary-blue);color:#fff;border-bottom:2px solid var(--accent-gold)}
        .btn-custom{background-color:var(--accent-gold);color:var(--primary-blue);font-weight:600;border:none}
    </style>
    </head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header"><h5 class="mb-0">Pendaftaran Berjaya</h5></div>
                    <div class="card-body">
                        <p>ID Pelanggan: <?= htmlspecialchars($id) ?></p>
                        <p>Nama: <?= $nama ?></p>
                        <p>No. MyKad: <?= $ic ?></p>
                        <p>No. Telefon: <?= $no_telefon ?></p>
                        <?php if ($emel !== ''): ?><p>Emel: <?= $emel ?></p><?php endif; ?>
                        <?php if ($bank_nama !== ''): ?><p>Bank: <?= $bank_nama ?> (<?= $bank_no_akaun ?>)</p><?php endif; ?>
                        <div class="d-flex gap-2">
                            <a href="customer_register.php" class="btn btn-outline-secondary">Daftar Lagi</a>
                            <a href="dashboard.php" class="btn btn-custom">Ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

