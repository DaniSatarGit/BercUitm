<?php
// Include the FPDF library
require('fpdf/fpdf.php');

// Capture the form data
$projectTitle = $_POST['projectTitle'];
$projectDescription = $_POST['projectDescription'];
$projectPurpose = $_POST['projectPurpose'];
$projectProcedure = $_POST['projectProcedure'];
$projectParticipation = $_POST['projectParticipation'];
$projectBenefit = $_POST['projectBenefit'];
$projectRisk = $_POST['projectRisk'];
$projectConfidential = $_POST['projectConfidential'];
$submission_date = $_POST['submission_date'];

// Create a new PDF instance
$pdf = new FPDF();
$pdf->AddPage();

// Set title font
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Ethics Approval Application Form', 0, 1, 'C');
$pdf->Ln(10);

// Set basic font for body
$pdf->SetFont('Arial', '', 12);

// Add content
$pdf->Cell(0, 10, "Research Title:", 0, 1);
$pdf->MultiCell(0, 10, $projectTitle);
$pdf->Ln(5);

$pdf->Cell(0, 10, "Introduction of Research:", 0, 1);
$pdf->MultiCell(0, 10, $projectDescription);
$pdf->Ln(5);

$pdf->Cell(0, 10, "Purpose of Research:", 0, 1);
$pdf->MultiCell(0, 10, $projectPurpose);
$pdf->Ln(5);

$pdf->Cell(0, 10, "Research Procedure:", 0, 1);
$pdf->MultiCell(0, 10, $projectProcedure);
$pdf->Ln(5);

$pdf->Cell(0, 10, "Participation in Research:", 0, 1);
$pdf->MultiCell(0, 10, $projectParticipation);
$pdf->Ln(5);

$pdf->Cell(0, 10, "Benefit of Research:", 0, 1);
$pdf->MultiCell(0, 10, $projectBenefit);
$pdf->Ln(5);

$pdf->Cell(0, 10, "Research Risk:", 0, 1);
$pdf->MultiCell(0, 10, $projectRisk);
$pdf->Ln(5);

$pdf->Cell(0, 10, "Confidentiality:", 0, 1);
$pdf->MultiCell(0, 10, $projectConfidential);
$pdf->Ln(5);

$pdf->Cell(0, 10, "Submission Date: " . $submission_date, 0, 1);
$pdf->Ln(10);

// Output the PDF to the browser
$pdf->Output('D', 'Ethics_Approval_Form.pdf');
?>
