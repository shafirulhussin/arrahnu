<?php
require __DIR__ . '/db.php';
$stmt = $pdo->query("SELECT id, user_id, berat_emas, nilai_marhun, jumlah_pinjaman, kadar_ujrah, tarikh_mula, tarikh_matang, DATEDIFF(tarikh_matang, CURDATE()) AS baki_hari FROM transaksi_gadaian WHERE status='aktif' ORDER BY tarikh_mula DESC");
$rows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Gadaian Aktif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{--primary-blue:#0f172a;--accent-gold:#c5a059}
        .navbar{background-color:var(--primary-blue);border-bottom:3px solid var(--accent-gold)}
        .navbar-brand{color:var(--accent-gold)!important;font-weight:bold}
        .table thead th{background-color:var(--primary-blue);color:#fff;border-bottom:2px solid var(--accent-gold)}
        .badge-gold{background-color:var(--accent-gold);color:#0f172a}
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">AR-RAHNU SYSTEM</a>
        </div>
    </nav>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Senarai Gadaian Aktif</h4>
            <a href="index.php" class="btn btn-outline-secondary">Tambah Gadaian</a>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Berat (g)</th>
                                <th>Nilai Marhun (RM)</th>
                                <th>Jumlah Pinjaman (RM)</th>
                                <th>Upah Simpan Sebulan (RM)</th>
                                <th>Tarikh Mula</th>
                                <th>Tarikh Matang</th>
                                <th>Baki Hari</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rows)): ?>
                                <tr><td colspan="9" class="text-center">Tiada rekod aktif.</td></tr>
                            <?php else: ?>
                                <?php foreach ($rows as $r): ?>
                                    <?php $upah = ($r['nilai_marhun'] / 100) * $r['kadar_ujrah']; ?>
                                    <tr>
                                        <td><?= htmlspecialchars($r['id']) ?></td>
                                        <td><?= htmlspecialchars($r['user_id']) ?></td>
                                        <td><?= number_format($r['berat_emas'], 2) ?></td>
                                        <td><?= number_format($r['nilai_marhun'], 2) ?></td>
                                        <td><?= number_format($r['jumlah_pinjaman'], 2) ?></td>
                                        <td><?= number_format($upah, 2) ?></td>
                                        <td><?= htmlspecialchars($r['tarikh_mula']) ?></td>
                                        <td><?= htmlspecialchars($r['tarikh_matang']) ?></td>
                                        <td><span class="badge badge-gold"><?= (int)$r['baki_hari'] ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

