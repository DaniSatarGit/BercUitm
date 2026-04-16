<?php
require('../fpdf/fpdf.php');
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
$sql_berc4 = "SELECT * FROM berc4 WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql_berc4);
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
    echo "No BERC4 submission found for the provided ID.";
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
     $pdf->Image('image/Uitm.png', 10, 10, 30); // Adjust the image path and size as needed
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Universiti Teknologi MARA', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, '13500 Permatang Pauh', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Tel: 04-382 2888 | Faks: 04-382 2776', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Application for Exemption from Ethical Review', 0, 1, 'C');
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, 'Permohonan Pengeculian daripada Semakan Etika', 0, 1, 'C');
    $pdf->Ln(10); // Space after header

    // Part A : Details of Researcher
    $pdf->SetFont('Arial', 'B',12);
    $pdf->Cell(0, 10, 'Part A: Details of Researcher',0,1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian A: Maklumat Penyelidik', 0, 1);
    $pdf->Ln(4); // Space after header
    $pdf->SetFont('Arial', '',10);

    $pdf->Cell(70, 10, 'Research Title:', 1, 0);
    $pdf->Cell(120, 10, $row['research_title'], 1, 1);
    $pdf->Cell(70, 10, 'Researcher Name:', 1, 0);
    $pdf->Cell(120, 10, $row['researcher_name'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor Name:', 1, 0);
    $pdf->Cell(120, 10, $row['supervisor_name'], 1, 1);
    $pdf->Cell(70, 10, 'Department Address:', 1, 0);
    $pdf->Cell(120, 10, $row['dept_address'], 1, 1);
    $pdf->Cell(70, 10, 'Contact Information:', 1, 0);
    $pdf->Cell(120, 10, $row['contact_info'], 1, 1);
    $pdf->Cell(70, 10, 'Study Level:', 1, 0);
    $pdf->Cell(120, 10, $row['study_level'], 1, 1);
    $pdf->Ln(5); // Space after header

    // Part B : Research Details
    $pdf->SetFont('Arial', 'B',12);
    $pdf->Cell(0, 10, 'Part B: Research Details',0,1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian B: Maklumat Penyelidikan', 0, 1);
    $pdf->Ln(4); // Space after header

    $pdf->Cell(70, 10, 'Research Justification:', 1, 0);
    $pdf->Cell(120, 10, $row['research_just'], 1, 1);
    $pdf->Cell(70, 10, 'Research Objectives:', 1, 0);
    $pdf->Cell(120, 10, $row['research_obj'], 1, 1);
    $pdf->Cell(70, 10, 'Research Method:', 1, 0);
    $pdf->Cell(120, 10, $row['research_method'], 1, 1);
    $pdf->Cell(70, 10, 'Research Significance:', 1, 0);
    $pdf->Cell(120, 10, $row['research_signif'], 1, 1);
    $pdf->Cell(70, 10, 'Research Risks:', 1, 0);
    $pdf->Cell(120, 10, $row['research_risks'], 1, 1);
    $pdf->Ln(5); // Space after header

    // Part C : Justification for Exemption from Ethical Review
    $pdf->SetFont('Arial', 'B',12);
    $pdf->Cell(0, 10, 'Part C : Justification for Exemption from Ethical Review',0,1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian C: Justifikasi Pengecualian daripada Semakan Etika', 0, 1);
    $pdf->Ln(4); // Space after header

    $pdf->Cell(70, 10, 'Ethical Exemption Justification:', 1, 0);
    $pdf->Cell(120, 10, $row['ethical_exempt_just'], 1, 1);
    $pdf->Ln(25); // Space after header

    // Part D : Agreement to Conduct the Research Project.
    $pdf->SetFont('Arial', 'B',12);
    $pdf->Cell(0, 10, 'Part D: Agreement to Conduct the Research Project.',0,1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian D: Pengesahan Persetujuan Menjalankan Penyelidikan', 0, 1);

    // Applicant
    $pdf->Cell(0, 10, '1. Applicant', 0, 1);
    $pdf->Cell(70, 10, 'Applicant Name:', 1, 0);
    $pdf->Cell(120, 10, $row['app_name'], 1, 1);
    $pdf->Cell(70, 10, 'Applicant ID:', 1, 0);
    $pdf->Cell(120, 10, $row['app_id'], 1, 1);
    $pdf->Cell(70, 10, 'Applicant Position:', 1, 0);
    $pdf->Cell(120, 10, $row['app_position'], 1, 1);
    $pdf->Cell(70, 10, 'Applicant Affiliation:', 1, 0);
    $pdf->Cell(120, 10, $row['app_affiliation'], 1, 1);
    $pdf->Cell(70, 10, 'Applicant Office:', 1, 0);
    $pdf->Cell(120, 10, $row['app_office'], 1, 1);
    $pdf->Cell(70, 10, 'Applicant Mobile:', 1, 0);
    $pdf->Cell(120, 10, $row['app_mobile'], 1, 1);
    $pdf->Cell(70, 10, 'Applicant Email:', 1, 0);
    $pdf->Cell(120, 10, $row['app_email'], 1, 1);
    $pdf->Cell(70, 10, 'Application Date:', 1, 0);
    $pdf->Cell(120, 10, $row['app_date'], 1, 1);
    $pdf->Cell(70, 10, 'Applicant Signature:', 1, 0);
    $pdf->Cell(120, 10, $row['app_signature'], 1, 1);
    $pdf->Ln(5); // Space after header

    // Supervisor
    $pdf->Cell(0, 10, '2. Supervisor', 0, 1);
    $pdf->Cell(70, 10, 'Supervisor Name:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_name'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor ID:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_id'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor Position:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_position'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor Affiliation:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_affiliation'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor Office:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_office'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor Mobile:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_mobile'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor Email:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_email'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor Signature:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_signature'], 1, 1);
    $pdf->Cell(70, 10, 'Supervisor Date:', 1, 0);
    $pdf->Cell(120, 10, $row['sv_date'], 1, 1);
    $pdf->Ln(5); // Space after header

    // Co-Researcher 
    $pdf->Cell(0, 10, '3. Co-Researcher', 0, 1);
    $pdf->Cell(70, 10, 'Co-Researcher Name:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_name'], 1, 1);
    $pdf->Cell(70, 10, 'Co-Researcher ID:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_id'], 1, 1);
    $pdf->Cell(70, 10, 'Co-Researcher Position:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_position'], 1, 1);
    $pdf->Cell(70, 10, 'Co-Researcher Affiliation:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_affiliation'], 1, 1);
    $pdf->Cell(70, 10, 'Co-Researcher Office:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_office'], 1, 1);
    $pdf->Cell(70, 10, 'Co-Researcher Mobile:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_mobile'], 1, 1);
    $pdf->Cell(70, 10, 'Co-Researcher Email:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_email'], 1, 1);
    $pdf->Cell(70, 10, 'Co-Researcher Signature:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_signature'], 1, 1);
    $pdf->Cell(70, 10, 'Co-Researcher Date:', 1, 0);
    $pdf->Cell(120, 10, $row['cores_date'], 1, 1);
    $pdf->Cell(70, 10, 'Submission Date:', 1, 0);
    $pdf->Cell(120, 10, $row['submission_date'], 1, 1);
    $pdf->Ln(5); // Space after header

    // Part E : Agreement to Conduct the Research Project.
    $pdf->SetFont('Arial', 'B',12);
    $pdf->Cell(0, 10, 'Part E: Verification from Department or Postgraduate Research Sub-Committee',0,1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian E: Pengesahan Jawatankuasa Penyelidikan Jabatan atau Pascasiswazah', 0, 1);
    $pdf->Ln(4); // Space after header

    $pdf->Cell(70, 10, 'CB Signature:', 1, 0);
    $pdf->Cell(120, 10, $row['cb_signature'], 1, 1);
    $pdf->Cell(70, 10, 'CB Stamp:', 1, 0);
    $pdf->Cell(120, 10, $row['cb_stamp'], 1, 1);

// Set headers for view or download
$filename = "BERC4_Submission_$id.pdf";
header('Content-Type: application/pdf');
header('Content-Disposition: ' . ($action === 'download' ? 'attachment' : 'inline') . '; filename="' . $filename . '"');

// Output the PDF
$pdf->Output();
?>
