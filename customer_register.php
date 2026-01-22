<?php
session_start();
require __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{--primary-blue:#0f172a;--accent-gold:#c5a059}
        body{background-color:#f8f9fa}
        .navbar{background-color:var(--primary-blue);border-bottom:3px solid var(--accent-gold)}
        .navbar-brand{color:var(--accent-gold)!important;font-weight:bold}
        .card-custom{border:none;border-radius:10px;box-shadow:0 4px 15px rgba(0,0,0,.1);overflow:hidden}
        .card-header-custom{background-color:var(--primary-blue);color:#fff;padding:20px;border-bottom:2px solid var(--accent-gold)}
        .btn-custom{background-color:var(--accent-gold);color:var(--primary-blue);font-weight:bold;border:none}
        .btn-custom:hover{background-color:#b38f4d;color:#fff}
        .form-control:focus{border-color:var(--accent-gold);box-shadow:0 0 0 .25rem rgba(197,160,89,.25)}
        .ic-status{min-height:24px}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">AR-RAHNU SYSTEM</a>
            <div class="ms-auto">
                <a href="logout.php" class="btn btn-outline-light">Log Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card card-custom">
                    <div class="card-header card-header-custom">
                        <h5 class="mb-0">Pendaftaran Pelanggan</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="customer_store.php" novalidate id="customerForm">
                            <div class="mb-3">
                                <label class="form-label">Nama Penuh</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">No. MyKad</label>
                                <input type="text" name="ic" id="ic" class="form-control" required pattern="^\d{6}-\d{2}-\d{4}$" placeholder="123456-12-1234">
                            </div>
                            <div class="ic-status mb-3" id="icStatus"></div>
                            <div class="mb-3">
                                <label class="form-label">No. Telefon</label>
                                <input type="tel" name="no_telefon" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Emel</label>
                                <input type="email" name="emel" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Bank</label>
                                <input type="text" name="bank_nama" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">No. Akaun Bank</label>
                                <input type="text" name="bank_no_akaun" class="form-control">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom btn-lg">Daftar Pelanggan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const icInput = document.getElementById('ic');
        const icStatus = document.getElementById('icStatus');
        let icTimer;
        icInput.addEventListener('input', function(){
            clearTimeout(icTimer);
            const val = icInput.value.trim();
            if (!val) { icStatus.innerHTML = ''; return; }
            icTimer = setTimeout(() => {
                fetch('customer_check_ic.php', {
                    method: 'POST',
                    headers: {'Content-Type':'application/x-www-form-urlencoded'},
                    body: 'ic=' + encodeURIComponent(val)
                }).then(r => r.json()).then(d => {
                    if (d.exists) {
                        icStatus.innerHTML = '<div class="alert alert-danger p-2 m-0">No. MyKad telah wujud</div>';
                    } else {
                        icStatus.innerHTML = '<div class="alert alert-success p-2 m-0">No. MyKad tersedia</div>';
                    }
                }).catch(() => {
                    icStatus.innerHTML = '<div class="alert alert-warning p-2 m-0">Ralat semakan</div>';
                });
            }, 400);
        });
        document.getElementById('customerForm').addEventListener('submit', function(e){
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('was-validated');
            }
        });
    </script>
</body>
</html>
