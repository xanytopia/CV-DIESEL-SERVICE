<?php

use setasign\Fpdi\Fpdi;
require_once ROOTPATH . 'vendor/autoload.php';

ob_start(); 

$tanggalmulai = $tanggal_mulai ?? date('Y-m-d');
$tanggalakhir = $tanggal_akhir ?? date('Y-m-d');

// No need to convert dates since they are already in 'Y-m-d' format
$startDate = $tanggalmulai;
$endDate = $tanggalakhir;

$filename = 'data_' . $startDate . '_to_' . $endDate . '.pdf';

// Create new PDF document with A4 size and landscape orientation
$pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);

$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Table to PDF');
$pdf->SetSubject('Table to PDF');

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Set font for heading
$pdf->SetFont('helvetica', 'B', 16);

// Add heading image (larger and positioned lower)
$headingPath = 'img/logo_cv.png'; // Adjust the path to your heading image
if (file_exists($headingPath)) {
    $headingWidth = 160; // Set the width of the heading image
    $headingX = ($pdf->getPageWidth() - $headingWidth) / 2; // Center the heading image
    $headingY = 20; // Set the Y position to move it down from the top
    $pdf->Image($headingPath, $headingX, $headingY, $headingWidth, '', 'PNG', '', 'T', true, 150, '', false, false, 0, false, false, false);
} else {
    echo "Heading image not found!";
}

// Add background image with adjusted size and opacity
$backgroundPath = 'img/cv_diesel_tp.png'; 
if (file_exists($backgroundPath)) {
    $pdf->SetAlpha(0.5);
    $imageWidth = 100; // in mm
    $imageHeight = 150; // in mm

    $pdf->Image(
        $backgroundPath,   // Path to the image
        100,                // X position
        50,                // Y position
        $imageWidth,       // Image width
        $imageHeight,      // Image height
        '',                // No specific image file type
        '',                // No specific URL
        '',                // No specific image alignment
        false,             // No interlaced option
        150,               // DPI
        '',                // No specific color profile
        false,             // No alpha channel
        false,             // No transparency
        0,                 // No rotation
        '',                // No specific image stretch
        false,             // No resizing option
        false,             // No image format
        false,             // No clip option
        false,             // No auto orientation
        false,             // No image alignment
        false              // No image transparency
    );
    $pdf->SetAlpha(1.0); // Reset opacity to default
} else {
    echo "Background image not found!";
}

// Add some space before the table
$pdf->Ln(60);

// Set font for table content
$pdf->SetFont('helvetica', '', 12);

// Generate HTML table content
$html = '<table border="1" align="center" width="100%" cellpadding="5"><thead><tr>';
$html .= '<th scope="col" width="20%">No. Transaksi</th>';
$html .= '<th scope="col" width="20%">Nama Pemilik</th>';
$html .= '<th scope="col" width="20%">Jenis Service</th>';
$html .= '<th scope="col" width="10%">Harga</th>';
$html .= '<th scope="col" width="10%">Bayar</th>';
$html .= '<th scope="col" width="10%">Kembalian</th>';
$html .= '<th scope="col" width="10%">Tanggal</th>';
$html .= '</tr></thead><tbody>';

if (empty($satu)) {
    $html .= '<tr><td colspan="7" align="center">No data available for the given date range.</td></tr>';
} else {
    foreach ($satu as $key) {
        $html .= '<tr>';
        $html .= '<td width="20%" align="center">' . $key->no_transaksi . '</td>';
        $html .= '<td width="20%" align="center">' . $key->nama_pemilik . '</td>';
        $html .= '<td width="20%" align="center">' . $key->jenis_service . '</td>';
        $html .= '<td width="10%" align="center">' . $key->harga . '</td>';
        $html .= '<td width="10%" align="center">' . $key->bayaran . '</td>';
        $html .= '<td width="10%" align="center">' . $key->kembalian . '</td>';
        $html .= '<td width="10%" align="center">' . $key->tanggal . '</td>';
        $html .= '</tr>';
    }
}

$html .= '</tbody></table>';

// Output HTML content to PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();

// Capture the output
$pdfOutput = $pdf->Output('', 'S'); // Get PDF content as string

ob_end_clean(); // Clean the output buffer

// Save the PDF content to a file
file_put_contents($filename, $pdfOutput);

// Output the PDF file to download or save
header('Content-Type: application/pdf');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
readfile($filename);

exit;
?>
