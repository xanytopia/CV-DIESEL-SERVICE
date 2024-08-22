<?php

require_once ROOTPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Ensure the data variables are set
$tanggalmulai = $tanggal_mulai ?? date('Y-m-d');
$tanggalakhir = $tanggal_akhir ?? date('Y-m-d');

// Prepare the filename
$filename = 'data_' . $tanggalmulai . '_to_' . $tanggalakhir . '.xlsx';

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data');

// Add title with CV name and date range
$sheet->mergeCells('A1:G1'); // Merge cells for the title
$sheet->setCellValue('A1', 'CV. Diesel Service'); // Set the CV name as title
$sheet->getStyle('A1')->getFont()->setSize(16); // Increase font size for the title
$sheet->getStyle('A1')->getFont()->setBold(true); // Bold font for the title
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Center align title

$sheet->mergeCells('A2:G2'); // Merge cells for the date range
$sheet->setCellValue('A2', 'Tanggal: ' . $tanggalmulai . ' to ' . $tanggalakhir); // Set the date range
$sheet->getStyle('A2')->getFont()->setSize(12); // Set font size for the date range
$sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Center align date range

// Set column headings and styles
$headings = ['No. Transaksi', 'Nama Pemilik', 'Jenis Service', 'Harga', 'Bayar', 'Kembalian', 'Tanggal'];
$columnLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
$sheet->fromArray($headings, NULL, 'A4'); // Add headings
$sheet->getStyle('A4:G4')->getFont()->setBold(true); // Bold column headings
$sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Center align column headings
$sheet->getStyle('A4:G4')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN); // Add border to column headings

// Populate data
$row = 5; // Start from row 5 for data
if (empty($satu)) {
    $sheet->setCellValue('A' . $row, 'No data available for the given date range.');
    $sheet->mergeCells('A' . $row . ':G' . $row);
} else {
    foreach ($satu as $key) {
        // Add single quote to force Excel to treat as text
        $sheet->setCellValue('A' . $row, "'" . $key->no_transaksi);
        $sheet->setCellValue('B' . $row, $key->nama_pemilik);
        $sheet->setCellValue('C' . $row, $key->jenis_service);
        $sheet->setCellValue('D' . $row, $key->harga);
        $sheet->setCellValue('E' . $row, $key->bayaran);
        $sheet->setCellValue('F' . $row, $key->kembalian);
        $sheet->setCellValue('G' . $row, $key->tanggal);

        $row++;
    }
}

// Auto-size columns based on their content
foreach ($columnLetters as $letter) {
    $sheet->getColumnDimension($letter)->setAutoSize(true);
}

// Set headers to force download the file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Create a writer and save the file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit;
