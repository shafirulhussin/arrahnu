<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penaksiran Ar-Rahnu</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0f172a; /* Dark Blue */
            --accent-gold: #c5a059;   /* Gold */
            --light-gold: #f3e5c2;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--primary-blue);
            border-bottom: 3px solid var(--accent-gold);
        }

        .navbar-brand {
            color: var(--accent-gold) !important;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header-custom {
            background-color: var(--primary-blue);
            color: #fff;
            padding: 20px;
            border-bottom: 2px solid var(--accent-gold);
        }

        .btn-custom {
            background-color: var(--accent-gold);
            color: var(--primary-blue);
            font-weight: bold;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #b38f4d;
            color: #fff;
        }

        .form-label {
            color: var(--primary-blue);
            font-weight: 600;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 0.25rem rgba(197, 160, 89, 0.25);
        }

        .gold-price-display {
            background-color: var(--light-gold);
            color: var(--primary-blue);
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 20px;
            border-left: 5px solid var(--accent-gold);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-5">
        <div class="container">
            <a class="navbar-brand" href="#">AR-RAHNU SYSTEM</a>
            <div class="ms-auto">
                <a href="logout.php" class="btn btn-outline-light">Log Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card card-custom">
                    <div class="card-header card-header-custom text-center">
                        <h4 class="mb-0">Penaksiran Gadaian Emas</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Paparan Harga Semasa (Simulation) -->
                        <div class="gold-price-display text-center">
                            Harga Pasaran Semasa (999): RM <span id="display-price">360.00</span>/g
                        </div>

                        <form action="calculation.php" method="POST">
                            <div class="mb-3">
                                <label for="jenis_emas" class="form-label">Jenis Emas</label>
                                <select class="form-select" id="jenis_emas" name="jenis_emas" required>
                                    <option value="" selected disabled>Pilih Jenis Emas...</option>
                                    <option value="999" data-price="360.00">999 (24K)</option>
                                    <option value="916" data-price="345.50">916 (22K)</option>
                                    <option value="835" data-price="300.00">835 (20K)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="berat_emas" class="form-label">Berat Emas (gram)</label>
                                <input type="number" step="0.01" min="0.1" class="form-control" id="berat_emas" name="berat_emas" placeholder="Contoh: 10.5" required>
                            </div>

                            <div class="mb-4">
                                <label for="harga_semasa" class="form-label">Harga Semasa (RM/g)</label>
                                <input type="number" step="0.01" class="form-control bg-light" id="harga_semasa" name="harga_semasa" value="360.00" readonly>
                                <div class="form-text">Harga dikemaskini automatik berdasarkan jenis emas.</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom btn-lg">
                                    Kira Pembiayaan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Simple Script to Update Price based on Selection -->
    <script>
        document.getElementById('jenis_emas').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var price = selectedOption.getAttribute('data-price');
            if (price) {
                document.getElementById('harga_semasa').value = price;
                document.getElementById('display-price').textContent = price;
            }
        });
    </script>
</body>
</html>
