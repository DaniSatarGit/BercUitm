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
$sql_berc3 = "SELECT * FROM berc3 WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql_berc3);
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
    echo "No BERC3 submission found for the provided ID.";
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
    $pdf->Cell(0, 10, 'Assent Form', 0, 1, 'C');
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, 'Borang Persetujuan Menyertai Projek', 0, 1, 'C');
    $pdf->Ln(10); // Space after header

    // Project Information Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Project Information', 0, 1);
    $pdf->Ln(4);

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(50, 10, 'Project Name:', 1, 0);
    $pdf->Cell(140, 10, $row['projectName_berc3'], 1, 1);
    $pdf->Ln(4); // Space after header

    $pdf->Cell(0, 10, 'Project Description:', 1, 1);
    $pdf->MultiCell(0, 10, $row['projectDescription_berc3'], 1, 1);
    $pdf->Ln(4);

    $pdf->Cell(0, 10, 'Project Purpose:', 1, 1);
    $pdf->MultiCell(0, 10, $row['projectPurpose_berc3'], 1, 1);
    $pdf->Ln(4);

    $pdf->Cell(0, 10, 'Project Role:', 1, 1);
    $pdf->MultiCell(0, 10, $row['projectRole_berc3'], 1, 1);
    $pdf->Ln(4);

    $pdf->Cell(0, 10, 'Project Risk:', 1, 1);
    $pdf->MultiCell(0, 10, $row['projectRisk_berc3'], 1, 1);
    $pdf->Ln(4);

    $pdf->Cell(0, 10, 'Project Participation:', 1, 1);
    $pdf->MultiCell(0, 10, $row['projectParticipation_berc3'], 1, 1);
    $pdf->Ln(4);

    // Researcher Information Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Researcher Information', 0, 1);
    $pdf->Ln(4);

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(50, 10, 'Researcher Name:', 1, 0);
    $pdf->Cell(140, 10, $row['researcherName_berc3'], 1, 1);
    $pdf->Cell(50, 10, 'Researcher Contact:', 1, 0);
    $pdf->Cell(140, 10, $row['researcherContact_berc3'], 1, 1);
    $pdf->Ln(4);

    $pdf->Cell(0, 10, 'Confidentiality:', 1, 1);
    $pdf->MultiCell(0, 10, $row['confidentiality_berc3'], 1, 1);
    $pdf->Ln(10);

    // Assent Questions Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Assent Questions', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Soalan Persetujuan', 0, 1);
    $pdf->Ln(4);

    // Adding Header Titles for Yes and No Columns for Clarity
    $pdf->Cell(150, 10, '', 0, 0); // Blank Cell for alignment
    $pdf->Cell(20, 10, 'Yes', 1, 0, 'C');
    $pdf->Cell(20, 10, 'No', 1, 1, 'C'); // Move to next line

    // Function to add rows for each question
    function addRow($pdf, $label, $valueYes, $valueNo) {
        $pdf->Cell(150, 10, $label, 1, 0); // Question Label
        $pdf->Cell(20, 10, ($valueYes == 'Yes' ? 'X' : ''), 1, 0, 'C'); // Yes Column
        $pdf->Cell(20, 10, ($valueNo == 'No' ? 'X' : ''), 1, 1, 'C'); // No Column and move to next line
    }

    // Add each question row using the function for clarity and consistency
    addRow($pdf, 'Has somebody explained this project to you?', $row['explained_project_berc3'], $row['explained_project_berc3']);
    addRow($pdf, 'Do you understand what this project is about?', $row['understand_project_berc3'], $row['understand_project_berc3']);
    addRow($pdf, 'Do you have any questions about the project?', $row['questions_about_project_berc3'], $row['questions_about_project_berc3']);
    addRow($pdf, 'If you have asked a question, do you understand the answer?', $row['question_answer_berc3'], $row['question_answer_berc3']);
    addRow($pdf, 'Do you understand it’s ok to stop taking part at any time?', $row['stop_participation_berc3'], $row['stop_participation_berc3']);
    addRow($pdf, 'Are you okay to take part?', $row['ok_to_participate_berc3'], $row['ok_to_participate_berc3']);
    addRow($pdf, 'Are you okay for your voice to be recorded?', $row['voice_recording_berc3'], $row['voice_recording_berc3']);
    addRow($pdf, 'Are you okay to be on video?', $row['on_video_berc3'], $row['on_video_berc3']);
    addRow($pdf, 'Are you okay to have photographs taken?', $row['photographs_berc3'], $row['photographs_berc3']);

    // Adding some space at the end of the table
    $pdf->Ln(10);

    // Participant Information Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Participant Information', 0, 1);
    $pdf->Ln(4);

    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(50, 10, 'Participant Name:', 1, 0);
    $pdf->Cell(140, 10, $row['participantName_berc3'], 1, 1);
    $pdf->Cell(50, 10, 'Participant Signature:', 1, 0);
    $pdf->Cell(140, 10, $row['participantSignature_berc3'], 1, 1);
    $pdf->Cell(50, 10, 'Participant Date:', 1, 0);
    $pdf->Cell(140, 10, $row['participantDate_berc3'], 1, 1);

    $pdf->Cell(50, 10, 'Consent Taker Name:', 1, 0);
    $pdf->Cell(140, 10, $row['consentTakerName_berc3'], 1, 1);
    $pdf->Cell(50, 10, 'Consent Taker Signature:', 1, 0);
    $pdf->Cell(140, 10, $row['consentTakerSignature_berc3'], 1, 1);
    $pdf->Cell(50, 10, 'Consent Taker Date:', 1, 0);
    $pdf->Cell(140, 10, $row['consentTakerDate_berc3'], 1, 1);

    $pdf->Cell(50, 10, 'Witness Name:', 1, 0);
    $pdf->Cell(140, 10, $row['witnessName_berc3'], 1, 1);
    $pdf->Cell(50, 10, 'Witness Signature:', 1, 0);
    $pdf->Cell(140, 10, $row['witnessSignature_berc3'], 1, 1);
    $pdf->Cell(50, 10, 'Witness Date:', 1, 0);
    $pdf->Cell(140, 10, $row['witnessDate_berc3'], 1, 1);

// Set headers for view or download
$filename = "BERC3_Submission_$id.pdf";
header('Content-Type: application/pdf');
header('Content-Disposition: ' . ($action === 'download' ? 'attachment' : 'inline') . '; filename="' . $filename . '"');

// Output the PDF
$pdf->Output();
?>