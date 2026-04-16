<?php
require('fpdf/fpdf.php');
include '../../../config.php'; // Database connection

// Get the application ID and action (view/download)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : 'view';

// Validate the ID
if ($id <= 0) {
    header("HTTP/1.1 400 Bad Request");
    echo "Invalid application ID.";
    exit;
}

// Fetch the BERC2 form details
$sql_berc5 = "SELECT * FROM berc5 WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql_berc5);
if (!$stmt) {
    header("HTTP/1.1 500 Internal Server Error");
    echo "Failed to prepare query: " . $conn->error;
    exit;
}
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("HTTP/1.1 404 Not Found");
    echo "No BERC5 submission found for the provided ID.";
    exit;
}

$row = $result->fetch_assoc();

// Replace null values with "N/A" for missing data
$row = array_map(function ($value) {
    return $value ?? 'N/A';
}, $row);

// Create instance of FPDF class
$pdf = new FPDF();
$pdf->AddPage();

// Header with logo and university details
// Header with logo and university details
    $pdf->Image('image/Uitm.png', 10, 10, 30); // Adjust the image path and size as needed
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Universiti Teknologi MARA', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, '13500 Permatang Pauh', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Tel: 04-382 2888 | Faks: 04-382 2776', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Applicant Checklist', 0, 1, 'C');
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, 'Senarai Semak Pemohon', 0, 1, 'C');
    $pdf->Ln(10); // Space after header

    $pdf->SetFont('Arial', 'I', 10);

    $pdf->Cell(70, 10, 'Have you completed the F/BERC 1 form?:', 1, 0);
    $pdf->Cell(120, 10, $row['fberc1_berc5'], 1, 1);
    $pdf->Cell(70, 10, 'Have you completed the F/BERC 2 form?:', 1, 0);
    $pdf->Cell(120, 10, $row['fberc2_berc5'], 1, 1);
    $pdf->Cell(70, 10, 'Have you completed the F/BERC 3 form?:', 1, 0);
    $pdf->Cell(120, 10, $row['fberc3_berc5'], 1, 1);
    $pdf->Cell(130, 10, 'Have you completed the F/BERC 4 form? (For Exemption from Ethic Review*):', 1, 0);
    $pdf->Cell(60, 10, $row['fberc4_berc5'], 1, 1);
    $pdf->Cell(70, 10, 'Have you completed the F/BERC 5 form?:', 1, 0);
    $pdf->Cell(120, 10, $row['fberc5_berc5'], 1, 1);
    $pdf->Cell(75, 10, 'Has the form been signed by all researchers?:', 1, 0);
    $pdf->Cell(115, 10, $row['form_signed_berc5'], 1, 1);
    $pdf->Cell(160, 10, 'Has your application been approved and endorsement by your Faculty/State Research Committee?:', 1, 0);
    $pdf->Cell(30, 10, $row['approved_by_faculty_berc5'], 1, 1);
    $pdf->Cell(135, 10, 'Has your supervisor checked for grammatical errors in REC 2 and REC 4 forms?:', 1, 0);
    $pdf->Cell(55, 10, $row['supervisor_checked_berc5'], 1, 1);
    $pdf->Cell(50, 10, 'Additional Comments:', 1, 0);
    $pdf->Cell(140, 10, $row['additional_comments_berc5'], 1, 1);
    $pdf->Cell(150, 10, 'Decisions for the applications will be informed within ONE (1) working weeks after the meeting:', 1, 0);
    $pdf->Cell(40, 10, $row['decision_berc5'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Signature:', 1, 0);
    $pdf->Cell(140, 10, $row['applicant_signature_berc5'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Date:', 1, 0);
    $pdf->Cell(140, 10, $row['applicant_date_berc5'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Signature:', 1, 0);
    $pdf->Cell(140, 10, $row['supervisor_signature_berc5'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Date:', 1, 0);
    $pdf->Cell(140, 10, $row['supervisor_date_berc5'], 1, 1);
    $pdf->Cell(50, 10, 'Submission Date:', 1, 0);
    $pdf->Cell(140, 10, $row['submission_date_berc5'], 1, 1);

// Set headers for view or download
$filename = "BERC5_Submission_$id.pdf";
header('Content-Type: application/pdf');
header('Content-Disposition: ' . ($action === 'download' ? 'attachment' : 'inline') . '; filename="' . $filename . '"');

// Output the PDF
$pdf->Output();
?>