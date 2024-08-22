<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Laporan Pemesanan</h3>
            </div>
        </div>
    </div>

    <section id="print-options">
        <div class="row match-height">
            <!-- Print Options -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Print Options</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form action="<?= base_url('home/laporan') ?>" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="awal">Tanggal Awal</label>
                                            <input type="date" class="form-control" id="awal" name="tanggal1" value="<?= isset($tanggal1) ? htmlspecialchars($tanggal1) : '' ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="akhir">Tanggal Akhir</label>
                                            <input type="date" class="form-control" id="akhir" name="tanggal2" value="<?= isset($tanggal2) ? htmlspecialchars($tanggal2) : '' ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Filter</button>
                                        <button type="submit" formaction="<?= base_url('home/printpdf') ?>" class="btn btn-danger me-1 mb-1">Print PDF</button>
                                        <button type="submit" formaction="<?= base_url('home/printexcel') ?>" class="btn btn-success me-1 mb-1">Print Excel</button>
                                        <form action="" method="post">
    <button type="submit" formaction="<?= base_url('home/printwindows') ?>" formtarget="_blank" class="btn btn-warning me-1 mb-1 print-windows-btn">Print Windows</button>
</form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="filtered-transactions">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filtered Transactions</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
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
                                        </tr>
                                    </thead>
                                    <tbody>
    <?php if (!empty($filteredTransactions)): ?>
        <?php foreach ($filteredTransactions as $transaction): ?>
            <tr>
                <td><?= htmlspecialchars($transaction->no_transaksi) ?></td>
                <td><?= htmlspecialchars($transaction->tanggal) ?></td>
                <td><?= htmlspecialchars($transaction->nama_pemilik) ?></td>
                <td><?= htmlspecialchars($transaction->jenis_service) ?></td>
                <td><?= htmlspecialchars($transaction->harga) ?></td>
                <td class="<?= $transaction->status == 'Belum Bayar' ? 'status-belum-bayar' : 'status-sudah-bayar' ?>">
                    <?= htmlspecialchars($transaction->status) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No transactions found for the selected date range.</td>
        </tr>
    <?php endif; ?>
</tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>