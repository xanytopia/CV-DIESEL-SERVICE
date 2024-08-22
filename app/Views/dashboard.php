<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-pending {
            color: red;
        }

        .status-on-going {
            color: green;
        }

        .status-done {
            color: blue;
        }
    </style>
</head>

<body>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <h4>Selamat datang, <?= session()->get('username'); ?>!</h4>

            </div>
        </div>
        <!-- Sale & Revenue Start -->
        <?php if (session()->get('level') == 'Admin') { ?>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-shopping-cart fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Jumlah Pesanan</p>
                                <h6 class="mb-0"><?= $totalOrders ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-spinner fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Pesanan On-Going</p>
                                <h6 class="mb-0"><?= $totalOngoingOrders ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-clock fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Pesanan Pending</p>
                                <h6 class="mb-0"><?= $totalPendingOrders ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Sale & Revenue End -->

        <div class="container-fluid pt-4 px-4">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Recent Orders</h6>
                    <a href="<?= base_url('home/restorep') ?>" class="btn btn-warning">Restore Data</a>
                    <!-- Tombol untuk menuju halaman restore -->

                </div>

                <?php if (empty($darren)) { ?>
                    <p>No orders found. Please add some orders to see them here.</p>
                <?php } else { ?>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <thead>
                                    <tr class="text-dark">
                                        <th scope="col">Nama</th>
                                        <th scope="col" class="hidden-th">Telp</th>
                                        <th scope="col" class="hidden-th">Alamat</th>
                                        <th scope="col">Merek Genset</th>
                                        <th scope="col" class="hidden-th">Merek Mesin</th>
                                        <th scope="col" class="hidden-th">Kapasitas Genset</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Sistem Pesanan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Estimasi Waktu</th>
                                        <th scope="col">Request Tanggal</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            <tbody>
                                <?php

                                foreach ($darren as $key) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($key['nama_pemilik']) ?></td>
                                        <td class="hidden-td"><?= htmlspecialchars($key['no_telp']) ?></td>
                                        <td class="hidden-td"><?= htmlspecialchars($key['alamat']) ?></td>
                                        <td><?= htmlspecialchars($key['merk_genset']) ?></td>
                                        <td class="hidden-td"><?= htmlspecialchars($key['merk_mesin']) ?></td>
                                        <td class="hidden-td"><?= htmlspecialchars($key['kapasitas_genset']) ?></td>
                                        <td><?= htmlspecialchars($key['deskripsi_masalah']) ?></td>
                                        <td><?= htmlspecialchars($key['sistem_pesanan']) ?></td>
                                        <td
                                            class="<?= $key['status'] === 'Pending' ? 'status-pending' : ($key['status'] === 'On-Going' ? 'status-on-going' : 'status-done') ?>">
                                            <?= htmlspecialchars($key['status']) ?>
                                        </td>

                                        <td class="estimasi-waktu"
                                            data-end="<?= !empty($key['estimasi_waktu']) ? htmlspecialchars($key['estimasi_waktu']) : 'None' ?>">
                                            <?= !empty($key['estimasi_waktu']) ? htmlspecialchars($key['estimasi_waktu']) : 'None' ?>
                                        </td>

                                        <td><?= !empty($key['tanggal_permintaan']) ? htmlspecialchars($key['tanggal_permintaan']) : 'N/A' ?>
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#detailsModal" data-id="<?= $key['id_pesanan'] ?>"
                                                data-nama="<?= htmlspecialchars($key['nama_pemilik']) ?>"
                                                data-merk-genset="<?= htmlspecialchars($key['merk_genset']) ?>"
                                                data-merk-mesin="<?= htmlspecialchars($key['merk_mesin']) ?>"
                                                data-kapasitas="<?= htmlspecialchars($key['kapasitas_genset']) ?>"
                                                data-deskripsi="<?= htmlspecialchars($key['deskripsi_masalah']) ?>"
                                                data-sistem="<?= htmlspecialchars($key['sistem_pesanan']) ?>"
                                                data-status="<?= htmlspecialchars($key['status']) ?>"
                                                data-notelp="<?= htmlspecialchars($key['no_telp']) ?>"
                                                data-alamat="<?= htmlspecialchars($key['alamat']) ?>"
                                                data-id-teknisi="<?= htmlspecialchars($key['id_teknisi']) ?>">View
                                                Details</button>

                                            <button class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('<?= base_url('home/hapusp/' . $key['id_pesanan']) ?>')">Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Modal for Order Details -->
        <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="detailsForm"
                            action="<?= base_url('home/editdetail/' . (isset($key['id_pesanan']) ? $key['id_pesanan'] : '')) ?>"
                            method="POST">

                            method="POST">
                            <input type="hidden" id="orderId" name="orderId">
                            <div class="form-group">
                                <label for="namaPemilik">Nama Pemilik</label>
                                <input type="text" class="form-control" id="namaPemilik" name="nama" readonly>
                            </div>
                            <div class="form-group">
                                <label for="notelp">No. Telp</label>
                                <input type="text" class="form-control" id="notelp" name="notelp" readonly>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" readonly>
                            </div>
                            <div class="form-group">
                                <label for="merkGenset">Merek Genset</label>
                                <input type="text" class="form-control" id="merkGenset" name="merk_genset" readonly>
                            </div>
                            <div class="form-group">
                                <label for="merkMesin">Merek Mesin</label>
                                <input type="text" class="form-control" id="merkMesin" name="merk_mesin" readonly>
                            </div>
                            <div class="form-group">
                                <label for="kapasitas">Kapasitas Genset</label>
                                <input type="text" class="form-control" id="kapasitas" name="kapasitas" readonly>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                    readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label for="sistemPesanan">Sistem Pesanan</label>
                                <select class="form-control" id="sistemPesanan" name="sistem" required>
                                    <option value="Pick Up">Pick Up</option>
                                    <option value="Langsung">Langsung</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Pending">Pending</option>
                                    <option value="On-Going">On-Going</option>
                                    <option value="Done">Done</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="teknisi">Teknisi</label>
                                <select class="form-control" id="teknisi" name="teknisi">
                                    <?php foreach ($technicians as $technician): ?>
                                        <option value="<?= $technician->id_teknisi ?>">
                                            <?= htmlspecialchars($technician->nama_teknisi) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estimasiWaktu">Estimasi Waktu</label>
                                <input type="time" class="form-control" id="estimasiWaktu" name="estimasi_waktu"
                                    value="<?= !empty($key['estimasi_waktu']) ? htmlspecialchars($key['estimasi_waktu']) : '' ?>">
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="detailsForm">Save changes</button>
                    </div>
                </div>
            </div>
        </div>




        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            $('#detailsModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var nama = button.data('nama');
                var merkGenset = button.data('merk-genset');
                var merkMesin = button.data('merk-mesin');
                var kapasitas = button.data('kapasitas');
                var deskripsi = button.data('deskripsi');
                var sistem = button.data('sistem');
                var status = button.data('status');
                var notelp = button.data('notelp');
                var alamat = button.data('alamat');
                var teknisiId = button.data('id-teknisi');
                var estimasiWaktu = button.data('estimasi-waktu');

                var modal = $(this);
                modal.find('#orderId').val(id);
                modal.find('#namaPemilik').val(nama);
                modal.find('#merkGenset').val(merkGenset);
                modal.find('#merkMesin').val(merkMesin);
                modal.find('#kapasitas').val(kapasitas);
                modal.find('#deskripsi').val(deskripsi);
                modal.find('#sistemPesanan').val(sistem);
                modal.find('#status').val(status);
                modal.find('#notelp').val(notelp);
                modal.find('#alamat').val(alamat);
                modal.find('#teknisi').val(teknisiId);
                modal.find('#estimasiWaktu').val(estimasiWaktu);

                if (status === 'Pending') {
                    modal.find('#status option[value="Done"]').prop('disabled', true);
                } else {
                    modal.find('#status option[value="Done"]').prop('disabled', false);
                }

                // Update status dropdown when the status changes
                modal.find('#status').on('change', function () {
                    if ($(this).val() === 'Pending') {
                        modal.find('#status option[value="Done"]').prop('disabled', true);
                    } else {
                        modal.find('#status option[value="Done"]').prop('disabled', false);
                    }
                });
            });


            function confirmDelete(url) {
                if (confirm('Are you sure you want to delete this order?')) {
                    window.location.href = url;
                }
            }


            function updateCountdown() {
                const countdownElements = document.querySelectorAll('.estimasi-waktu');

                countdownElements.forEach(element => {
                    const endTimeStr = element.dataset.end;

                    // Check if the end time is available and valid
                    if (!endTimeStr || endTimeStr === 'None') {
                        element.innerHTML = 'Waiting';
                        const statusElement = element.parentElement.querySelector('.status');
                        if (statusElement) {
                            statusElement.innerHTML = 'Waiting';
                            statusElement.classList.remove('status-pending', 'status-on-going', 'status-done');
                            statusElement.classList.add('status-waiting');
                        }
                        return;
                    }

                    // Parse the end time as a local time on today's date
                    const [hours, minutes, seconds] = endTimeStr.split(':').map(Number);
                    const endTime = new Date();
                    endTime.setHours(hours, minutes, seconds || 0, 0); // Set the time components

                    const now = new Date();

                    const distance = endTime.getTime() - now.getTime();

                    if (distance < 0) {
                        element.innerHTML = 'Menunggu Konfirmasi';
                        const statusElement = element.parentElement.querySelector('.status');
                        if (statusElement) {
                            statusElement.innerHTML = 'Menunggu Konfirmasi';
                            statusElement.classList.remove('status-pending', 'status-on-going', 'status-done');
                            statusElement.classList.add('status-waiting');
                        }
                    } else {
                        const hours = Math.floor(distance / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        element.innerHTML = `${hours}h ${minutes}m ${seconds}s`;
                    }
                });
            }

            setInterval(updateCountdown, 1000);
        </script>

</body>

</html>