<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Service Genset</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h6 {
            color: #007bff;
        }
        .form-container .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .form-container .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-container .btn-secondary {
            background-color: #6c757d;
            border: none;
            margin-top: 10px;
        }
        .form-container .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h6 class="mb-4 text-center">Form Pemesanan Service Genset</h6>
                    <form action="<?=base_url('home/aksi_pesan')?>" method="POST">
                        <!-- Nama -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap">
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="form-group">
                            <label for="nomorTelepon">Nomor Telepon</label>
                            <input type="tel" class="form-control" name="nomor" placeholder="Nomor Telepon">
                        </div>

                        <!-- Alamat -->
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat Lengkap"></textarea>
                        </div>

                        <!-- Merek Genset -->
                        <div class="form-group">
                            <label for="merekGenset">Merek Genset</label>
                            <input type="text" class="form-control" name="merek" placeholder="Merek Genset">
                        </div>

                        <!-- Jenis Mesin -->
                        <div class="form-group">
                            <label for="jenisGenset">Merek Mesin Genset</label>
                            <input type="text" class="form-control" name="mesin" placeholder="Merek Mesin Genset">
                        </div>

                        <!-- Kapasitas Genset -->
                        <div class="form-group">
                            <label for="kapasitasGenset">Kapasitas Genset (kVA)</label>
                            <input type="number" class="form-control" name="kapasitas" placeholder="Kapasitas Genset">
                        </div>

                        <!-- Deskripsi Masalah -->
                        <div class="form-group">
                            <label for="deskripsiMasalah">Deskripsi Masalah</label>
                            <textarea class="form-control" name="deskripsi" rows="3" placeholder="Deskripsi Masalah"></textarea>
                        </div>

                        <!-- Request Tanggal Service -->
                        <div class="form-group">
                            <label for="tanggalService">Request Tanggal Service (Optional)</label>
                            <input type="date" class="form-control" name="tanggal_service" placeholder="Pilih Tanggal Service">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-block">Pesan Sekarang</button>
                    </form>

                    <!-- Back to Dashboard Button -->
                    <a href="<?=base_url('home/dashboard')?>" class="btn btn-secondary btn-block">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
