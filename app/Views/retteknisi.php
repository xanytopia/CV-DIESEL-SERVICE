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
            <h6 class="mb-0">Data Teknisi Terhapus</h6>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Teknisi</th>
                    <th>No Telp</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($deletedTeknisi)) : ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data yang terhapus.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($deletedTeknisi as $teknisi) : ?>
                    <tr>
                        <td><?= htmlspecialchars($teknisi->nama_teknisi) ?></td>
                        <td><?= htmlspecialchars($teknisi->no_telp) ?></td>
                        <td><?= htmlspecialchars($teknisi->email) ?></td>
                        <td><?= htmlspecialchars($teknisi->status) ?></td>
                        <td>
                            <a href="<?= base_url('home/restore3/' . htmlspecialchars($teknisi->id_teknisi)) ?>" class="btn btn-sm btn-success">Restore</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
