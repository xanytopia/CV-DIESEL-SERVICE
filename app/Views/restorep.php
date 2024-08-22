<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Data Pesanan Terhapus</h6>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Pemilik</th>
                    <th>No Telp</th>
                    <th>Alamat</th>
                    <th>Merek Genset</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($deletedPesanan)) : ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data yang terhapus.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($deletedPesanan as $order) : ?>
                    <tr>
                        <td><?= htmlspecialchars($order->nama_pemilik) ?></td>
                        <td><?= htmlspecialchars($order->no_telp) ?></td>
                        <td><?= htmlspecialchars($order->alamat) ?></td>
                        <td><?= htmlspecialchars($order->merk_genset) ?></td>
                        <td><?= htmlspecialchars($order->status) ?></td>
                        <td>
                            <a href="<?= base_url('home/restore2/' . htmlspecialchars($order->id_pesanan)) ?>" class="btn btn-sm btn-success">Restore</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
