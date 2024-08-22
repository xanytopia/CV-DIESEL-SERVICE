<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restore Data</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Restore Data Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Data Transaksi Terhapus</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">No. Transaksi</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis Service</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($deletedTransaksi)): ?>
                            <?php foreach ($deletedTransaksi as $transaksi): ?>
                                <tr>
                                    <td><?= htmlspecialchars($transaksi->no_transaksi) ?></td>
                                    <td><?= htmlspecialchars($transaksi->tanggal) ?></td>
                                    <td><?= htmlspecialchars($transaksi->nama_pemilik) ?></td>
                                    <td><?= htmlspecialchars($transaksi->jenis_service) ?></td>
                                    <td><?= htmlspecialchars($transaksi->harga) ?></td>
                                    <td><?= htmlspecialchars($transaksi->status) ?></td>
                                    <td>
                                    <a href="<?= base_url('home/restore/' . htmlspecialchars($transaksi->id_transaksi)) ?>" class="btn btn-sm btn-success">Restore</a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">Tidak ada data yang dihapus</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Restore Data End -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
