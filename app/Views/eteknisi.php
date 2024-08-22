<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teknisi</title>
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
    </style>
</head>

<body>
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h6 class="mb-4 text-center">Edit Teknisi</h6>
                    <form action="<?= base_url('home/aksieteknisi') ?>" method="post">
                        <!-- Nama -->
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" value="<?= $user->nama_teknisi ?>">
                        </div>
                        <!-- Nomor Telepon -->
                        <div class="form-group">
                            <label for="nomorTelepon">Nomor Telepon</label>
                            <input type="text" class="form-control" name="notelp" value="<?= $user->no_telp ?>">
                        </div>
                        <!-- Alamat -->
                        <div class="form-group">
                            <label for="alamat">Email</label>
                            <input type="text" class="form-control" name="email" value="<?= $user->email ?>">
                        </div>
                        <!-- Merek Genset -->
                        <div class="form-group">
                            <label for="merekGenset">Status</label>
                            <select class="form-control custom-dropdown" name="status">
                                <option value="Aktif" <?= $user->status == 'Aktif' ? 'Tidak Aktif' : '' ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= $user->status == 'Aktif' ? 'Tidak Aktif' : '' ?>>Tidak
                                    Aktif</option>
                            </select>
                        </div>



                        <!-- Submit Button -->
                        <input type="hidden" name="id" value="<?= $user->id_teknisi ?>">
                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>