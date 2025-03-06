<?php
require_once '../../vendor/autoload.php';
require_once '../../src/shared/database.php';
require_once '../../src/admin/records.php';

ob_start();

$records = new RecordsManager();
$recordsList = $records->getAllRecords();

// Group records by year and month
$groupedRecords = [];
foreach($recordsList as $record) {
    $return_date = new DateTime($record['returned_datetime']);
    $yearMonth = $return_date->format('Y-m');
    $groupedRecords[$yearMonth][] = $record;
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Pliris System');
$pdf->SetTitle('Records Report');

// Column widths
$w = [60, 70, 25, 60, 60];
$header = ['Name', 'Item', 'Quantity', 'Reserved Date', 'Return Date'];
$num_headers = count($header);

foreach($groupedRecords as $yearMonth => $monthRecords) {
    $date = DateTime::createFromFormat('Y-m', $yearMonth);
    
    // Add a new page for each month
    $pdf->AddPage('L', 'A4');
    
    // Add month header
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, $date->format('F Y'), 0, 1, 'L');
    $pdf->Ln(2);
    
    // Table header
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->SetFillColor(240, 240, 240);
    for($i = 0; $i < $num_headers; ++$i) {
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
    }
    $pdf->Ln();
    
    // Table data
    $pdf->SetFont('helvetica', '', 10);
    foreach($monthRecords as $record) {
        $reserve_date = new DateTime($record['scheduled_reserve_datetime']);
        $return_date = new DateTime($record['returned_datetime']);
        
        $pdf->Cell($w[0], 6, $record['first_name'] . ' ' . $record['last_name'], 1);
        $pdf->Cell($w[1], 6, $record['item_name'], 1);
        $pdf->Cell($w[2], 6, $record['quantity_reserved'], 1);
        $pdf->Cell($w[3], 6, $reserve_date->format('M-d-Y h:i:s A'), 1);
        $pdf->Cell($w[4], 6, $return_date->format('M-d-Y h:i:s A'), 1);
        $pdf->Ln();
    }
}

ob_end_clean();
$pdf->Output('records_report.pdf', 'D');
