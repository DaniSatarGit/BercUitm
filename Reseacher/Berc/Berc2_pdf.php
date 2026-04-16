<?php
require('../fpdf/fpdf.php');
include '../../config.php'; // Include the database connection
session_start();

// Get the current user's ID
$user_id = $_SESSION['user_id'];

// Get the form ID from the URL
$form_id = $_GET['form_id'];

// Fetch the BERC1 form details from the database
$sql_berc1 = "SELECT * FROM berc2 WHERE user_id = ? AND id = ?";
$stmt_berc1 = $conn->prepare($sql_berc1);
$stmt_berc1->bind_param("ss", $user_id, $form_id);
$stmt_berc1->execute();
$result_berc1 = $stmt_berc1->get_result();

if ($result_berc1->num_rows > 0) {
    $row = $result_berc1->fetch_assoc();

    // Create instance of FPDF class
    $pdf = new FPDF();
    $pdf->AddPage();

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

    $pdf->Cell(30, 10, 'Project Title:', 1, 0);
    $pdf->Cell(160, 10, $row['projectTitle_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(190, 10, 'Introduction of Research:', 1, 1);
    $pdf->Cell(190, 10, $row['projectDescription_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(190, 10, 'Purpose of Research:', 1, 1);
    $pdf->Cell(190, 10, $row['projectPurpose_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(190, 10, 'Research Procedure:', 1, 1);
    $pdf->Cell(190, 10, $row['projectProcedure_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(190, 10, 'Participation in Research:', 1, 1);
    $pdf->Cell(190, 10, $row['projectParticipation_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(190, 10, 'Benefit of Research:', 1, 1);
    $pdf->Cell(190, 10, $row['projectBenefit_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(190, 10, 'Research Risk:', 1, 1);
    $pdf->Cell(190, 10, $row['projectRisk_berc2'], 1, 1);
    $pdf->Ln(5);

    $pdf->Cell(190, 10, 'Confidentiality:', 1, 1);
    $pdf->Cell(190, 10, $row['projectConfidential_berc2'], 1, 1);
    $pdf->Ln(17);

    $pdf->SetFont('Arial', 'B',12);
    $pdf->Cell(0, 10, 'Consent Form',0,1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Borang Izin', 0, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 0, 'Participant Information', 0, 1);
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
    $pdf->Cell(0, 0, 'Witness Information', 0, 1);
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

    // Output the PDF
    $pdf->Output('D', 'BERC2_Submission_' . $row['id'] . '.pdf');
} else {
    echo "No BERC2 submission found for this user.";
}
?>
