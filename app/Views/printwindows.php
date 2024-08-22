<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        @media print {
            @page {
                size: landscape; /* Mengatur ukuran halaman menjadi landscape */
                margin: 20mm; /* Margin halaman */
            }
            body {
                position: relative;
            }
            img.background {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 200mm;
                height: 150mm;
                opacity: 0.1;
                z-index: -1; /* Menempatkan gambar di belakang teks */
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
                text-align: center;
            }
            td {
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- Gambar Latar Belakang -->
    <img src="<?= base_url('img/cv_diesel_tp.png') ?>" class="background" alt="Logo">

    <!-- Konten Tabel -->
    <h3><?= 'Tanggal Awal: ' . $tanggal_mulai . ' - Tanggal Akhir: ' . $tanggal_akhir ?></h3>
    <table>
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Nama Pemilik</th>
                <th>Jenis Service</th>
                <th>Harga</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (is_array($satu) || $satu instanceof Traversable): ?>
                <?php foreach ($satu as $key): ?>
                    <tr>
                        <td><?= htmlspecialchars($key->no_transaksi) ?></td>
                        <td><?= htmlspecialchars($key->nama_pemilik) ?></td>
                        <td><?= htmlspecialchars($key->jenis_service) ?></td>
                        <td><?= number_format($key->harga, 2, ',', '.') ?></td>
                        <td><?= number_format($key->bayaran, 2, ',', '.') ?></td>
                        <td><?= number_format($key->kembalian, 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($key->tanggal) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No data available for the given date range.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print(); // Otomatis memunculkan dialog cetak
        }
    </script>

</body>
</html>
