<?php
require('../fpdf/fpdf.php');
include '../../config.php'; // Include the database connection
session_start();

// Get the current user's ID
$user_id = $_SESSION['user_id'];

// Get the form ID from the URL
$form_id = $_GET['form_id'];

// Fetch the BERC1 form details from the database
$sql_berc1 = "SELECT * FROM berc5 WHERE user_id = ? AND id = ?";
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

    // Output the PDF
    $pdf->Output('D', 'BERC5_Submission_' . $row['id'] . '.pdf');
} else {
    echo "No BERC5 submission found for this user.";
}
?>
