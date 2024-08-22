<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restore Edit Teknisi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Data Teknisi yang Telah Diedit</h6>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Nama Teknisi</th>
                            <th scope="col">No. Telp</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($backupData)): ?>
                            <?php foreach ($backupData as $teknisi): ?>
                                <tr>
                                    <td><?= htmlspecialchars($teknisi['nama_teknisi']) ?></td>
                                    <td><?= htmlspecialchars($teknisi['no_telp']) ?></td>
                                    <td><?= htmlspecialchars($teknisi['email']) ?></td>
                                    <td><?= htmlspecialchars($teknisi['status']) ?></td>
                                    <td>
                                        <a href="<?= base_url('home/restoreteknisi/' . htmlspecialchars($teknisi['id_teknisi'])) ?>" class="btn btn-sm btn-success">Restore</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Tidak ada data yang tersedia untuk di-restore</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
