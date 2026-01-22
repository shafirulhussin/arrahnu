<?php
require __DIR__ . '/db.php';
$beratTotal = (float)$pdo->query("SELECT COALESCE(SUM(berat_emas),0) FROM transaksi_gadaian WHERE status='aktif'")->fetchColumn();
$pinjamanTotal = (float)$pdo->query("SELECT COALESCE(SUM(jumlah_pinjaman),0) FROM transaksi_gadaian")->fetchColumn();
$ujrahTotal = (float)$pdo->query("SELECT COALESCE(SUM((nilai_marhun/100)*kadar_ujrah),0) FROM transaksi_gadaian WHERE status='aktif' AND CURDATE() BETWEEN tarikh_mula AND tarikh_matang")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{--primary-blue:#0f172a;--accent-gold:#c5a059;--soft:#f8f9fa}
        body{background-color:var(--soft)}
        .navbar{background-color:var(--primary-blue);border-bottom:3px solid var(--accent-gold)}
        .navbar-brand{color:var(--accent-gold)!important;font-weight:bold}
        .card-metric{border:none;border-radius:14px;box-shadow:0 8px 24px rgba(0,0,0,.08);overflow:hidden;background:#fff}
        .card-metric .head{background:var(--primary-blue);color:#fff;padding:16px 20px;border-bottom:2px solid var(--accent-gold)}
        .card-metric .body{padding:22px}
        .metric-value{font-size:28px;font-weight:700;color:var(--primary-blue)}
        .metric-label{color:#4b5563;font-weight:600}
        .accent-bar{height:6px;background:linear-gradient(90deg,var(--accent-gold),#b38f4d);border-radius:6px}
        .icon-circle{width:40px;height:40px;border-radius:50%;background-color:rgba(197,160,89,.15);display:flex;align-items:center;justify-content:center;color:var(--accent-gold);margin-right:10px}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">AR-RAHNU SYSTEM</a>
        </div>
    </nav>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Dashboard Admin</h4>
            <div class="d-flex gap-2">
                <a href="index.php" class="btn btn-outline-secondary">Penaksiran</a>
                <a href="list.php" class="btn btn-outline-secondary">Senarai Aktif</a>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-metric">
                    <div class="head d-flex align-items-center">
                        <div class="icon-circle"><span class="bi bi-archive"></span></div>
                        <span class="metric-label">Jumlah Emas Disimpan</span>
                    </div>
                    <div class="body">
                        <div class="metric-value"><?= number_format($beratTotal, 2) ?> g</div>
                        <div class="mt-3 accent-bar"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-metric">
                    <div class="head d-flex align-items-center">
                        <div class="icon-circle"><span class="bi bi-cash-stack"></span></div>
                        <span class="metric-label">Jumlah Pembiayaan Dikeluarkan</span>
                    </div>
                    <div class="body">
                        <div class="metric-value">RM <?= number_format($pinjamanTotal, 2) ?></div>
                        <div class="mt-3 accent-bar"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-metric">
                    <div class="head d-flex align-items-center">
                        <div class="icon-circle"><span class="bi bi-graph-up"></span></div>
                        <span class="metric-label">Kutipan Ujrah Bulan Ini</span>
                    </div>
                    <div class="body">
                        <div class="metric-value">RM <?= number_format($ujrahTotal, 2) ?></div>
                        <div class="mt-3 accent-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

