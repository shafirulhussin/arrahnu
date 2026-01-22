<?php
require __DIR__ . '/db.php';

function kira_arrahnu($berat_emas, $harga_semasa, $margin_pembiayaan = 80, $kadar_ujrah = 0.75) {
    $nilai_marhun = $berat_emas * $harga_semasa;
    $jumlah_pinjaman = $nilai_marhun * ($margin_pembiayaan / 100);
    $upah_simpan_sebulan = ($nilai_marhun / 100) * $kadar_ujrah;
    return [
        'nilai_marhun' => $nilai_marhun,
        'jumlah_pinjaman' => $jumlah_pinjaman,
        'upah_simpan_sebulan' => $upah_simpan_sebulan
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis_emas = isset($_POST['jenis_emas']) ? $_POST['jenis_emas'] : '';
    $berat_emas = isset($_POST['berat_emas']) ? (float)$_POST['berat_emas'] : 0;
    $harga_semasa = isset($_POST['harga_semasa']) ? (float)$_POST['harga_semasa'] : 0;
    $margin_pembiayaan = 80;
    $kadar_ujrah = 0.75;
    $calc = kira_arrahnu($berat_emas, $harga_semasa, $margin_pembiayaan, $kadar_ujrah);
    $user_id = 1;
    $tarikh_mula = new DateTime('now');
    $tarikh_matang = (clone $tarikh_mula)->modify('+6 months');
    $stmt = $pdo->prepare('INSERT INTO transaksi_gadaian (user_id, berat_emas, nilai_marhun, jumlah_pinjaman, kadar_ujrah, tarikh_mula, tarikh_matang, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $user_id,
        $berat_emas,
        $calc['nilai_marhun'],
        $calc['jumlah_pinjaman'],
        $kadar_ujrah,
        $tarikh_mula->format('Y-m-d'),
        $tarikh_matang->format('Y-m-d'),
        'aktif'
    ]);
    $lastId = $pdo->lastInsertId();
    echo '<!DOCTYPE html><html lang="ms"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Keputusan Pengiraan</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"><style>:root{--primary-blue:#0f172a;--accent-gold:#c5a059} .btn-custom{background-color:var(--accent-gold);color:var(--primary-blue);font-weight:bold;border:none} .card-header{background-color:var(--primary-blue);color:#fff;border-bottom:2px solid var(--accent-gold)}</style></head><body class="bg-light"><div class="container py-5"><div class="row justify-content-center"><div class="col-md-8"><div class="card shadow"><div class="card-header"><h5 class="mb-0">Keputusan Pengiraan & Simpanan</h5></div><div class="card-body">';
    echo '<p class="mb-2">ID Transaksi: ' . htmlspecialchars($lastId) . '</p>';
    echo '<p class="mb-2">Jenis Emas: ' . htmlspecialchars($jenis_emas) . '</p>';
    echo '<p class="mb-2">Berat: ' . number_format($berat_emas, 2) . ' g</p>';
    echo '<p class="mb-2">Harga Semasa: RM ' . number_format($harga_semasa, 2) . '/g</p>';
    echo '<hr>';
    echo '<p class="mb-2">Nilai Marhun: RM ' . number_format($calc['nilai_marhun'], 2) . '</p>';
    echo '<p class="mb-2">Jumlah Pinjaman: RM ' . number_format($calc['jumlah_pinjaman'], 2) . '</p>';
    echo '<p class="mb-2">Upah Simpan Sebulan: RM ' . number_format($calc['upah_simpan_sebulan'], 2) . '</p>';
    echo '<p class="mb-2">Tarikh Mula: ' . $tarikh_mula->format('Y-m-d') . '</p>';
    echo '<p class="mb-3">Tarikh Matang: ' . $tarikh_matang->format('Y-m-d') . '</p>';
    echo '<div class="d-flex gap-2"><a href="index.php" class="btn btn-secondary">Kembali</a><a href="list.php" class="btn btn-custom">Lihat Senarai Aktif</a></div>';
    echo '</div></div></div></div></div></body></html>';
    exit;
}
