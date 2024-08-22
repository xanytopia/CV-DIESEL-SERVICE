<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-belum-bayar {
            color: red;
        }

        .status-sudah-bayar {
            color: green;
        }
    </style>
</head>

<body>
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Transaksi Pesanan</h6>
                <a href="<?= base_url('home/restoret') ?>" class="btn btn-warning">Restore Data</a> <!-- Tombol untuk menuju halaman restore -->
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
                        <?php if (!empty($darren)): ?>
                            <?php foreach ($darren as $key): ?>
                                <tr>
                                    <td><?= htmlspecialchars($key['no_transaksi']) ?></td>
                                    <td><?= htmlspecialchars($key['tanggal']) ?></td>
                                    <td><?= htmlspecialchars($key['nama_pemilik']) ?></td>
                                    <td><?= htmlspecialchars($key['jenis_service']) ?></td>
                                    <td><?= htmlspecialchars($key['harga']) ?></td>
                                    <td class="<?= $key['status'] == 'Belum Bayar' ? 'status-belum-bayar' : 'status-sudah-bayar' ?>">
                                        <?= htmlspecialchars($key['status']) ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editTransaksiModal"
                                                data-id="<?= htmlspecialchars($key['id_transaksi']) ?>"
                                                data-no_transaksi="<?= htmlspecialchars($key['no_transaksi']) ?>"
                                                data-tanggal="<?= htmlspecialchars($key['tanggal']) ?>"
                                                data-nama_pemilik="<?= htmlspecialchars($key['nama_pemilik']) ?>"
                                                data-jenis_service="<?= htmlspecialchars($key['jenis_service']) ?>"
                                                data-harga="<?= htmlspecialchars($key['harga']) ?>"
                                                data-status="<?= htmlspecialchars($key['status']) ?>"
                                                data-bayaran="<?= htmlspecialchars($key['bayaran']) ?>"
                                                data-kembalian="<?= htmlspecialchars($key['kembalian']) ?>">Edit</button>

                                        <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('home/hapust/' . htmlspecialchars($key['id_transaksi'])) ?>')">Delete</button>

                                        <?php if ($key['harga'] > 0 && $key['status'] == 'Belum Bayar'): ?>
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#paymentModal"
                                                    data-id="<?= htmlspecialchars($key['id_transaksi']) ?>"
                                                    data-harga="<?= htmlspecialchars($key['harga']) ?>"
                                                    data-bayaran="<?= htmlspecialchars($key['bayaran']) ?>"
                                                    data-kembalian="<?= htmlspecialchars($key['kembalian']) ?>">Bayar</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">Tidak ada transaksi</td>
                            </tr>
                        <?php endif; ?>

                        <div class="mt-3">
            <h6>Total Harga: Rp <?= number_format($totalAmount, 0, ',', '.') ?></h6>
        </div>
                    </tbody>
                </table>
                
            </div>
            
        </div>
        <nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
    <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="<?= base_url('home/transaksi?page=' . ($currentPage - 1)) ?>" tabindex="-1">Previous</a>
    </li>
    <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
      <a class="page-link" href="<?= base_url('home/transaksi?page=' . ($currentPage + 1)) ?>">Next</a>
    </li>
  </ul>
</nav>
    </div>
    <!-- Recent Sales End -->

    <!-- Modal for Edit Transaksi -->
    <div class="modal fade" id="editTransaksiModal" tabindex="-1" role="dialog" aria-labelledby="editTransaksiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTransaksiModalLabel">Edit Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editTransaksiForm" action="<?= base_url('home/editTransaksi') ?>" method="POST">
                        <input type="hidden" id="editTransaksiId" name="id_transaksi">
                        <div class="form-group">
                            <label for="editNoTransaksi">No. Transaksi</label>
                            <input type="text" class="form-control" id="editNoTransaksi" name="no_transaksi" disabled>
                        </div>
                        <div class="form-group">
                            <label for="editTanggal">Tanggal</label>
                            <input type="date" class="form-control" id="editTanggal" name="tanggal" disabled>
                        </div>
                        <div class="form-group">
                            <label for="editNamaPemilik">Nama</label>
                            <input type="text" class="form-control" id="editNamaPemilik" name="nama_pemilik" disabled>
                        </div>
                        <div class="form-group">
                            <label for="editJenisService">Jenis Service</label>
                            <input type="text" class="form-control" id="editJenisService" name="jenis_service" required>
                        </div>
                        <div class="form-group">
                            <label for="editHarga">Harga</label>
                            <input type="number" class="form-control" id="editHarga" name="harga" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <input type="text" class="form-control" id="editStatus" name="status" disabled>
                        </div>
                        <div class="form-group">
                            <label for="editBayaran">Bayaran</label>
                            <input type="number" class="form-control" id="editBayaran" name="bayaran" disabled>
                        </div>
                        <div class="form-group">
                            <label for="editKembalian">Kembalian</label>
                            <input type="number" class="form-control" id="editKembalian" name="kembalian" disabled>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                        <a id="printNotaLink" href="#" class="btn btn-primary">Print Nota</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Modal for Payment -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm" action="<?= base_url('home/processPayment') ?>" method="POST">
                        <input type="hidden" id="paymentTransaksiId" name="id_transaksi">
                        <div class="form-group">
                            <label for="paymentHarga">Harga</label>
                            <input type="number" class="form-control" id="paymentHarga" name="harga" readonly>
                        </div>
                        <div class="form-group">
                            <label for="paymentBayar">Bayar</label>
                            <input type="number" class="form-control" id="paymentBayar" name="bayar" required>
                        </div>
                        <div class="form-group">
                            <label for="paymentKembalian">Kembalian</label>
                            <input type="number" class="form-control" id="paymentKembalian" name="kembalian" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $('#editTransaksiModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);

            modal.find('#editTransaksiId').val(button.data('id'));
            modal.find('#editNoTransaksi').val(button.data('no_transaksi')).prop('disabled', true);
            modal.find('#editTanggal').val(button.data('tanggal')).prop('disabled', true);
            modal.find('#editNamaPemilik').val(button.data('nama_pemilik')).prop('disabled', true);
            modal.find('#editJenisService').val(button.data('jenis_service')).prop('disabled', false);
            modal.find('#editHarga').val(button.data('harga')).prop('disabled', false);
            modal.find('#editStatus').val(button.data('status')).prop('disabled', true);
            modal.find('#editBayaran').val(button.data('bayaran')).prop('disabled', true);
            modal.find('#editKembalian').val(button.data('kembalian')).prop('disabled', true);

            // Disable fields and submit button if payment has been made
            if (button.data('bayaran')) {
                modal.find('.modal-body input').prop('disabled', true);
                modal.find('#saveChangesBtn').prop('disabled', true);
            } else {
                modal.find('#saveChangesBtn').prop('disabled', false);
            }

            // Set print nota link
            $('#printNotaLink').attr('href', '<?= base_url('home/printnota') ?>/' + button.data('id'));
        });

        $('#paymentModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var harga = parseFloat(button.data('harga'));

            modal.find('#paymentTransaksiId').val(button.data('id'));
            modal.find('#paymentHarga').val(harga);
            modal.find('#paymentBayar').val(button.data('bayaran'));
            modal.find('#paymentKembalian').val(button.data('kembalian'));

            $('#paymentBayar').on('input', function () {
                var bayar = parseFloat($(this).val());
                var kembalian = bayar - harga;
                modal.find('#paymentKembalian').val(kembalian);
            });

            // Disable submit button if harga is not defined or zero
            if (!harga || harga <= 0) {
                modal.find('button[type="submit"]').prop('disabled', true);
            } else {
                modal.find('button[type="submit"]').prop('disabled', false);
            }
        });

        function confirmDelete(url) {
            if (confirm('Are you sure you want to delete this transaction?')) {
                window.location.href = url;
            }
        }
    </script>
</body>

</html>