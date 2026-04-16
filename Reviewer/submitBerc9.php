<?php
// Start session and include FPDF + DB
if (session_status() === PHP_SESSION_NONE) session_start();
require('fpdf/fpdf.php'); // Ensure the path to FPDF is correct
include '../config.php'; // DB connection

// Collect form data (basic fields)
$title_project = $_POST['title_project'] ?? '';
$researcher_name = $_POST['researcher_name'] ?? '';
$supervisor_name = $_POST['supervisor_name'] ?? '';
$faculty_state = $_POST['faculty_state'] ?? '';
$date_submitted = $_POST['date_submitted'] ?? '';

// Link info (sent from the form)
$application_id = isset($_POST['application_id']) && is_numeric($_POST['application_id']) ? (int)$_POST['application_id'] : null;
$reviewer_application_id = isset($_POST['reviewer_application_id']) && is_numeric($_POST['reviewer_application_id']) ? (int)$_POST['reviewer_application_id'] : null;
$reviewer_id = isset($_POST['reviewer_id']) && is_numeric($_POST['reviewer_id']) ? (int)$_POST['reviewer_id'] : ($_SESSION['user_id'] ?? null);

// Collecting Research Methods (checkboxes)
$research_methods = isset($_POST['research_methods']) ? implode(", ", $_POST['research_methods']) : '';
$others_comment_A = $_POST['others_comment_A'] ?? '';

// Collecting Subjects (checkboxes)
$subjects = isset($_POST['subjects']) ? implode(", ", $_POST['subjects']) : '';
$others_comment_B = $_POST['others_comment_B'] ?? '';

// Collecting BERC Forms and Comments (Yes/No options)
$form_sections = [
    'title' => ['response' => $_POST['title'] ?? '', 'comment' => $_POST['title_comment'] ?? ''],
    'background' => ['response' => $_POST['background'] ?? '', 'comment' => $_POST['background_comment'] ?? ''],
    'problem_statement' => ['response' => $_POST['problem_statement'] ?? '', 'comment' => $_POST['problem_statement_comment'] ?? ''],
    'objectives' => ['response' => $_POST['objectives'] ?? '', 'comment' => $_POST['objectives_comment'] ?? ''],
    'expected_benefits' => ['response' => $_POST['expected_benefits'] ?? '', 'comment' => $_POST['expected_benefits_comment'] ?? ''],
    'research_dates' => ['response' => $_POST['research_dates'] ?? '', 'comment' => $_POST['research_dates_comment'] ?? ''],
    'data_collection_date' => ['response' => $_POST['data_collection_date'] ?? '', 'comment' => $_POST['data_collection_date_comment'] ?? ''],
    'project_location' => ['response' => $_POST['project_location'] ?? '', 'comment' => $_POST['project_location_comment'] ?? ''],
    'experimental_design' => ['response' => $_POST['experimental_design'] ?? '', 'comment' => $_POST['experimental_design_comment'] ?? ''],
    'criteria' => ['response' => $_POST['criteria'] ?? '', 'comment' => $_POST['criteria_comment'] ?? ''],
    'sample_size' => ['response' => $_POST['sample_size'] ?? '', 'comment' => $_POST['sample_size_comment'] ?? ''],
    'flow_chart' => ['response' => $_POST['flow_chart'] ?? '', 'comment' => $_POST['flow_chart_comment'] ?? ''],
    'statistical_analysis' => ['response' => $_POST['statistical_analysis'] ?? '', 'comment' => $_POST['statistical_analysis_comment'] ?? ''],
];

// BERC Sections Status
$berc2 = $_POST['berc2'] ?? '';
$berc3 = $_POST['berc3'] ?? '';
$berc4 = $_POST['berc4'] ?? '';

// Final Decision
$decision = $_POST['decision'] ?? '';
$modifications = $_POST['modifications'] ?? '';
$comment_decision = $_POST['comment_decision'] ?? '';

// Insert into project_evaluations to keep backward compatibility
$sql = "INSERT INTO project_evaluations (title_project, researcher_name, supervisor_name, faculty_state, date_submitted) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('sssss', $title_project, $researcher_name, $supervisor_name, $faculty_state, $date_submitted);
    if ($stmt->execute()) {
        $project_id = $stmt->insert_id;
        $stmt->close();

        // Create PDF with FPDF (same content as before)
        $pdf = new FPDF();
        $pdf->AddPage();

        // Header with logo and university details
        $pdf->Image('image/Uitm.png', 10, 10, 30);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Universiti Teknologi MARA', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, '13500 Permatang Pauh', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Tel: 04-382 2888 | Faks: 04-382 2776', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Branch Ethics Application Review Form', 0, 1, 'C');
        $pdf->SetFont('Arial', 'I', 12);
        $pdf->Cell(0, 10, 'Borang Semakan Permohonan Etika Cawangan', 0, 1, 'C');
        $pdf->Ln(10);

        // Main content
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Part A: Brief Details of Project Reviewed', 0, 1);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, 'Bahagian A: Maklumat Penyelidik', 0, 1);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(50, 8, 'Title of Project:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $title_project, 1, 1);
        $pdf->Cell(50, 8, 'Researcher Name:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $researcher_name, 1, 1);
        $pdf->Cell(50, 8, 'Supervisor Name:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $supervisor_name, 1, 1);
        $pdf->Cell(50, 8, 'Faculty/State:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $faculty_state, 1, 1);
        $pdf->Cell(50, 8, 'Date Submitted:', 1, 0, 'L', true);
        $pdf->Cell(0, 8, $date_submitted, 1, 1);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Section A: Research Methods Summary', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 8, "Research Methods: $research_methods", 1);
        if (!empty($others_comment_A)) {
            $pdf->MultiCell(0, 8, "Other Methods Specification: $others_comment_A", 1);
        }
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Section B: Subjects', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 8, "Subjects: $subjects", 1);
        if (!empty($others_comment_B)) {
            $pdf->MultiCell(0, 8, "Other Subjects Specification: $others_comment_B", 1);
        }
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Section C: BERC Forms", 0, 1);
        foreach ($form_sections as $section => $details) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(50, 8, ucfirst($section) . ":", 1, 0, 'L', true);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 8, $details['response'], 1, 1);
            if (!empty($details['comment'])) {
                $pdf->Cell(50, 8, "Comments:", 1, 0, 'L', true);
                $pdf->MultiCell(0, 8, $details['comment'], 1);
            }
        }
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "BERC Section Completion Status:", 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 8, "BERC2:", 1, 0, 'L', true);
        $pdf->Cell(0, 8, $berc2, 1, 1);
        $pdf->Cell(50, 8, "BERC3:", 1, 0, 'L', true);
        $pdf->Cell(0, 8, $berc3, 1, 1);
        $pdf->Cell(50, 8, "BERC4:", 1, 0, 'L', true);
        $pdf->Cell(0, 8, $berc4, 1, 1);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Final Decision:", 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 8, "Decision:", 1, 0, 'L', true);
        $pdf->Cell(0, 8, $decision, 1, 1);
        if ($decision == 'approve_with_changes') {
            $pdf->Cell(50, 8, "Modifications:", 1, 0, 'L', true);
            $pdf->Cell(0, 8, $modifications, 1, 1);
        }
        if (!empty($comment_decision)) {
            $pdf->Cell(50, 8, "Comments:", 1, 0, 'L', true);
            $pdf->MultiCell(0, 8, $comment_decision, 1);
        }

        // Prepare PDF filename and path
        $sanitized_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $title_project ?: 'review');
        $pdfFileName = $sanitized_title . '_review_' . time() . '.pdf';
        $pdfDir = __DIR__ . '/reviews_pdf/';
        if (!is_dir($pdfDir)) mkdir($pdfDir, 0755, true);

        // Save PDF to string and to file
        $pdfString = $pdf->Output('S');
        $pdfFullPath = $pdfDir . $pdfFileName;
        file_put_contents($pdfFullPath, $pdfString);

        // Insert into `reviews` table linking to assignment/application
        $reviewData = json_encode($_POST);
        $insertReviewSql = "INSERT INTO reviews (project_evaluation_id, application_id, reviewer_application_id, reviewer_id, review_data, decision, modifications, pdf_filename) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insStmt = $conn->prepare($insertReviewSql);
        if ($insStmt) {
            $insStmt->bind_param('iiiissss', $project_id, $application_id, $reviewer_application_id, $reviewer_id, $reviewData, $decision, $modifications, $pdfFileName);
            $insStmt->execute();
            $insStmt->close();
        }

        // Update reviewer_application status to 'Completed' when possible
        if ($reviewer_application_id) {
            $upd = $conn->prepare("UPDATE reviewer_application SET status = 'Completed' WHERE id = ?");
            if ($upd) {
                $upd->bind_param('i', $reviewer_application_id);
                $upd->execute();
                $upd->close();
            }
        } elseif ($application_id && $reviewer_id) {
            $upd2 = $conn->prepare("UPDATE reviewer_application SET status = 'Completed' WHERE application_id = ? AND reviewer_id = ?");
            if ($upd2) {
                $upd2->bind_param('ii', $application_id, $reviewer_id);
                $upd2->execute();
                $upd2->close();
            }
        }

        // Send PDF to browser for download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $pdfFileName . '"');
        echo $pdfString;
        exit();
    } else {
        echo "Error inserting project_evaluations: " . $stmt->error;
    }
} else {
    echo "Error preparing project_evaluations statement: " . $conn->error;
}

$conn->close();
?>
