<?php
require('fpdf/fpdf.php');
include '../../config.php'; // Database connection

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
$sql_berc2 = "SELECT * FROM berc2 WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql_berc2);
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
    echo "No BERC2 submission found for the provided ID.";
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
    $pdf->Cell(0, 10, 'Participant Information Sheet', 0, 1, 'C');
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, 'Borang Maklumat Peserta', 0, 1, 'C');
    $pdf->Ln(10); // Space after header

    // Part A : Details of Researcher
    $pdf->SetFont('Arial', 'I',10);

    $pdf->Cell(25, 10, 'Project Title:', 1, 0);
    $pdf->Cell(165, 10, $row['projectTitle_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(45, 10, 'Introduction of Research:', 1, 1);
    $pdf->Cell(0, 10, $row['projectDescription_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(40, 10, 'Purpose of Research:', 1, 1);
    $pdf->Cell(0, 10, $row['projectPurpose_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(40, 10, 'Research Procedure:', 1, 1);
    $pdf->Cell(0, 10, $row['projectProcedure_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(45, 10, 'Participation in Research:', 1, 1);
    $pdf->Cell(0, 10, $row['projectParticipation_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(40, 10, 'Benefit of Research:', 1, 1);
    $pdf->Cell(0, 10, $row['projectBenefit_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(40, 10, 'Research Risk:', 1, 1);
    $pdf->Cell(0, 10, $row['projectRisk_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(40, 10, 'Confidentiality:', 1, 1);
    $pdf->Cell(0, 10, $row['projectConfidential_berc2'], 1, 1);
    $pdf->Ln(17);

    $pdf->SetFont('Arial', 'B',12);
    $pdf->Cell(0, 10, 'Consent Form',0,1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Borang Izin', 0, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 0, 'Participant', 0, 1);
    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'I', 10);

    $pdf->Cell(50, 10, 'Participant Name:', 1, 0);
    $pdf->Cell(140, 10, $row['participantName_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Participant Signature:', 1, 0);
    $pdf->Cell(140, 10, $row['participantSignature_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Participant IC:', 1, 0);
    $pdf->Cell(140, 10, $row['participantIC_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Participant Date:', 1, 0);
    $pdf->Cell(140, 10, $row['participantDate_berc2'], 1, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 0, 'Witness', 0, 1);
    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'I', 10);

    $pdf->Cell(50, 10, 'Witness Name:', 1, 0);
    $pdf->Cell(140, 10, $row['witnessName_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Witness Signature:', 1, 0);
    $pdf->Cell(140, 10, $row['witnessSignature_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Witness IC:', 1, 0);
    $pdf->Cell(140, 10, $row['witnessIC_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Witness Date:', 1, 0);
    $pdf->Cell(140, 10, $row['witnessDate_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Consent Taker Name:', 1, 0);
    $pdf->Cell(140, 10, $row['consentTakerName_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Consent Taker Signature:', 1, 0);
    $pdf->Cell(140, 10, $row['consentTakerSignature_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Consent Taker IC:', 1, 0);
    $pdf->Cell(140, 10, $row['consentTakerIC_berc2'], 1, 1);

    $pdf->Cell(50, 10, 'Consent Taker Date:', 1, 0);
    $pdf->Cell(140, 10, $row['consentTakerDate_berc2'], 1, 1);

// Set headers for view or download
$filename = "BERC2_Submission_$id.pdf";
header('Content-Type: application/pdf');
header('Content-Disposition: ' . ($action === 'download' ? 'attachment' : 'inline') . '; filename="' . $filename . '"');

// Output the PDF
$pdf->Output();
?>
