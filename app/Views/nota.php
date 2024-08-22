<?php
require_once(ROOTPATH . 'vendor/autoload.php'); // Adjust the path as necessary

// Create a new TCPDF instance with a smaller page size
$pdf = new TCPDF('P', 'mm', array(80, 100), true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Darren');
$pdf->SetTitle('Nota');
$pdf->SetSubject('Nota');

// Set margins
$leftMargin = 5;
$rightMargin = 5;
$topMargin = 5;
$bottomMargin = 5;
$pdf->SetMargins($leftMargin, $topMargin, $rightMargin);
$pdf->SetAutoPageBreak(TRUE, $bottomMargin);

// Add a page
$pdf->AddPage();

// Add heading image
$headingPath = 'img/logo_cv.png'; // Adjust the path to your heading image
$pdf->Image($headingPath, $leftMargin, $topMargin, 70, '', 'PNG', '', 'T', true, 150, '', false, false, 0, false, false, false);

// Add background image with adjusted size and opacity
// Path to your image with adjusted opacity
$backgroundPath = 'img/cv_diesel_tp.png'; 
$pdf->SetAlpha(0.5);
$imageWidth = 50; // in mm
$imageHeight = 75; // in mm

// Adjust the position and size of the image
$pdf->Image(
    $backgroundPath,   // Path to the image
    15,                 // X position
    25,                 // Y position
    $imageWidth,        // Image width
    $imageHeight,       // Image height
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

$pdf->SetAlpha(1.0);
// Set font for header
$pdf->SetFont('helvetica', 'B', 10);

// Add logo and store information
$logoPath = 'path_to_logo.png'; // Adjust the path to your logo
$pdf->Image($logoPath, $leftMargin, $topMargin + 20, 30, '', 'PNG', '', 'T', true, 150, '', false, false, 0, false, false, false);
$pdf->SetXY($leftMargin + 35, $topMargin + 20);
$pdf->SetFont('helvetica', '', 8);

// Add transaction details
$pdf->SetXY($leftMargin, $topMargin + 20);
$pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 6, 'Nota Transaksi', 0, 1, 'C');

// Add transaction table
// Set font for the table
$pdf->SetFont('helvetica', '', 8);

// Adjust the Y position (reduce the margin value to move the content up)
$newTopMargin = $topMargin + 30; // Example: Move up by reducing the top margin

// Set X and Y position
$pdf->SetXY($leftMargin, $newTopMargin);

// Create HTML content for the table

$html = '
<table border="0" cellpadding="2">
    <tr>
        <td><strong>Tanggal:</strong> ' . $transaction->tanggal . '</td>
    </tr>
    <tr>
        <td><strong>Pemilik:</strong> ' . $transaction->nama_pemilik . '</td>
    </tr>
    <tr>
        <td><strong>Jenis Service:</strong> ' . $transaction->jenis_service . '</td>
    </tr>
    <tr>
        <td><strong>Harga:</strong> Rp ' . number_format($transaction->harga, 2, ',', '.') . '</td>
    </tr>
    <tr>
        <td><strong>Bayaran:</strong> Rp ' . number_format($transaction->bayaran, 2, ',', '.') . '</td>
    </tr>
    <tr>
        <td><strong>Kembalian:</strong> Rp ' . number_format($transaction->kembalian, 2, ',', '.') . '</td>
    </tr>
    <tr>
        <td><strong>Teknisi:</strong> ' . $teknisi->nama_teknisi . '</td>
    </tr>
</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// Add footer with additional information
$pdf->SetY(-20);
$pdf->SetFont('helvetica', 'I', 8);
$pdf->Cell(0, 6, 'Thank you for your purchase!', 0, 1, 'C');


// Output PDF directly to browser
$pdf->Output('nota_transaksi.pdf', 'I');

// Exit the script
exit;
?>
