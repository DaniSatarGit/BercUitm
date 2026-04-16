<?php
session_start();
require_once('fpdf/fpdf.php'); // Include TCPDF

// Your existing database connection and session check code here

// Prepare form data for PDF
$user_id = $_SESSION['user_id'];
$title = $_SESSION['title'];
$researcher_name = $_SESSION['researcher_name'];
$supervisor_name = $_SESSION['supervisor_name'];
$dept_address = $_SESSION['dept_address'];
$contact_info = $_SESSION['contact_info'];
$study_level = $_SESSION['study_level'];
$research_just = $_SESSION['research_just'];
$research_obj = $_SESSION['research_obj'];
$research_method = $_SESSION['research_method'];
$research_signif = $_SESSION['research_signif'];
$research_risks = $_SESSION['research_risks'];
$ethical_exempt_just = implode(",", $_SESSION['ethical_exempt_just']);
$app_name = $_SESSION['app_name'];
$app_id = $_SESSION['app_id'];
$app_position = $_SESSION['app_position'];
$app_affiliation = $_SESSION['app_affiliation'];
$app_office = $_SESSION['app_office'];
$app_mobile = $_SESSION['app_mobile'];
$app_email = $_SESSION['app_email'];
$app_date = $_SESSION['app_date'];
$app_signature = $_SESSION['app_signature'];
$cb_signature = $_SESSION['cb_signature'];
$cb_stamp = $_SESSION['cb_stamp'];
$sv_name = $_SESSION['sv_name'];
$sv_id = $_SESSION['sv_id'];
$sv_position = $_SESSION['sv_position'];
$sv_affiliation = $_SESSION['sv_affiliation'];
$sv_office = $_SESSION['sv_office'];
$sv_mobile = $_SESSION['sv_mobile'];
$sv_email = $_SESSION['sv_email'];
$sv_signature = $_SESSION['sv_signature'];
$sv_date = $_SESSION['sv_date'];
$cores_name = $_SESSION['cores_name'];
$cores_id = $_SESSION['cores_id'];
$cores_position = $_SESSION['cores_position'];
$cores_affiliation = $_SESSION['cores_affiliation'];
$cores_office = $_SESSION['cores_office'];
$cores_mobile = $_SESSION['cores_mobile'];
$cores_email = $_SESSION['cores_email'];
$cores_signature = $_SESSION['cores_signature'];
$cores_date = $_SESSION['cores_date'];
$date_submitted = $_SESSION['date_submitted'];

// Dapatkan data dari Halaman 2
$fberc1_berc5 = $_SESSION['fberc1_berc5'];
$fberc2_berc5 = $_SESSION['fberc2_berc5'];
$fberc3_berc5 = $_SESSION['fberc3_berc5'];
$fberc4_berc5 = $_SESSION['fberc4_berc5'];
$fberc5_berc5 = $_SESSION['fberc5_berc5'];
$form_signed_berc5 = $_SESSION['form_signed_berc5'];
$approved_by_faculty_berc5 = $_SESSION['approved_by_faculty_berc5'];
$supervisor_checked_berc5 = $_SESSION['supervisor_checked_berc5'];
$additional_comments_berc5 = $_SESSION['additional_comments_berc5'];
$decision_berc5 = $_SESSION['decision_berc5'];
$applicant_signature_berc5 = $_SESSION['applicant_signature_berc5'];
$applicant_date_berc5 = $_SESSION['applicant_date_berc5'];
$supervisor_signature_berc5 = $_SESSION['supervisor_signature_berc5'];
$supervisor_date_berc5 = $_SESSION['supervisor_date_berc5'];
$research_title = $_SESSION['research_title'];

// Masukkan data dari Halaman 1 ke dalam jadual berc4_final
$query1 = "INSERT INTO berc4 (user_id, title, researcher_name, supervisor_name, dept_address, contact_info, study_level, research_just, research_obj, research_method, research_signif, research_risks, ethical_exempt_just, app_name, app_id, app_position, app_affiliation, app_office, app_mobile, app_email, app_date, app_signature, cb_signature, cb_stamp, sv_name, sv_id, sv_position, sv_affiliation, sv_office, sv_mobile, sv_email, sv_signature, sv_date, cores_name, cores_id, cores_position, cores_affiliation, cores_office, cores_mobile, cores_email, cores_signature, cores_date, date_submitted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("sssssssssssssssssssssssssssssssssssssssssss", $user_id, $title, $researcher_name, $supervisor_name, $dept_address, $contact_info, $study_level, $research_just, $research_obj, $research_method, $research_signif, $research_risks, $ethical_exempt_just, $app_name, $app_id, $app_position, $app_affiliation, $app_office, $app_mobile, $app_email, $app_date, $app_signature, $cb_signature, $cb_stamp, $sv_name, $sv_id, $sv_position, $sv_affiliation, $sv_office, $sv_mobile, $sv_email, $sv_signature, $sv_date, $cores_name, $cores_id, $cores_position, $cores_affiliation, $cores_office, $cores_mobile, $cores_email, $cores_signature, $cores_date, $date_submitted);

if ($stmt1->execute()) {
    echo "Data dari Halaman 1 berjaya disimpan!<br>";
    header("Location: submit.php");
} else {
    echo "Ralat: " . $stmt1->error . "<br>";
}

// Masukkan data dari Halaman 2 ke dalam jadual berc5_final
$query2 = "INSERT INTO berc5ex (user_id, fberc1_berc5, fberc2_berc5, fberc3_berc5, fberc4_berc5, fberc5_berc5, form_signed_berc5, approved_by_faculty_berc5, supervisor_checked_berc5, additional_comments_berc5, decision_berc5, applicant_signature_berc5, applicant_date_berc5, supervisor_signature_berc5, supervisor_date_berc5, research_title, submission_date_berc5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("ssssssssssssssss", $user_id, $fberc1_berc5, $fberc2_berc5, $fberc3_berc5, $fberc4_berc5, $fberc5_berc5, $form_signed_berc5, $approved_by_faculty_berc5, $supervisor_checked_berc5, $additional_comments_berc5, $decision_berc5, $applicant_signature_berc5, $applicant_date_berc5, $supervisor_signature_berc5, $supervisor_date_berc5, $research_title);

if ($stmt2->execute()) {
    echo "Data dari Halaman 2 berjaya disimpan!";
    header("Location: submit.php");
} else {
    echo "Ralat: " . $stmt2->error;
}

class Berc4PDF extends FPDF {
    public function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'BERC4 Submission Details', 0, 1, 'C');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Generate PDF for BERC5 (Page 2)
class Berc5PDF extends FPDF {
    public function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'BERC5 Submission Details', 0, 1, 'C');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Generate and save BERC4 PDF
$berc4_pdf = new Berc4PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$berc4_pdf->SetCreator(PDF_CREATOR);
$berc4_pdf->SetTitle('BERC4 Submission PDF');
$berc4_pdf->AddPage();
$berc4_pdf->SetFont('helvetica', '', 10);

// Logo and University Information
$pdf->Image('image/Uitm.png', 10, 10, 30);
$pdf->SetXY(50, 10);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Universiti Teknologi MARA', 0, 1, 'L');
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetXY(50, 18);
$pdf->Cell(0, 10, '13500 Permatang Pauh', 0, 1, 'L');
$pdf->SetXY(50, 24);
$pdf->Cell(0, 10, 'Tel: 04-382 2888 | Faks: 04-382 2776', 0, 1, 'L');
$pdf->Ln(10);

// Section Headers and Content
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Application for Exemption from Ethical Review', 0, 1, 'C');
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Permohonan Pengeculian daripada Semakan Etika', 0, 1, 'C');
$pdf->Ln(10);

// Part A: Researcher Details
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Part A: Details of Researcher', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, "Title of Research Project: $title", 0, 1, 'L');
$pdf->Cell(0, 8, "Name of Researcher: $researcher_name", 0, 1, 'L');
$pdf->Cell(0, 8, "Name of Supervisor: $supervisor_name", 0, 1, 'L');
$pdf->MultiCell(0, 8, "Address of Department/Institute: $dept_address", 0, 'L');
$pdf->Cell(0, 8, "Contact No/Email: $contact_info", 0, 1, 'L');
$pdf->Cell(0, 8, "Level of Study: $study_level", 0, 1, 'L');
$pdf->Ln(5);

// Part B: Research Details
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Part B: Research Details', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 8, "Research Justification: $research_just", 0, 'L');
$pdf->MultiCell(0, 8, "Research Objectives: $research_obj", 0, 'L');
$pdf->MultiCell(0, 8, "Research Methodology: $research_method", 0, 'L');
$pdf->MultiCell(0, 8, "Research Significance: $research_signif", 0, 'L');
$pdf->MultiCell(0, 8, "Research Risks: $research_risks", 0, 'L');
$pdf->Ln(5);

// Part C: Justification for Exemption
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Part C: Justification for Exemption from Ethical Review', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 8, "Ethical Exemption Justification: $ethical_exempt_just", 0, 'L');
$pdf->Ln(5);

// Part D: Agreement to Conduct Research
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Part D: Agreement to Conduct the Research Project', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 8, "Applicant's Name: $app_name", 0, 'L');
$pdf->Cell(0, 8, "Staff/Student ID: $app_id", 0, 1, 'L');
$pdf->Cell(0, 8, "Position/Specialisation: $app_position", 0, 1, 'L');
$pdf->Cell(0, 8, "Affiliation: $app_affiliation", 0, 1, 'L');
$pdf->Cell(0, 8, "Office: $app_office", 0, 1, 'L');
$pdf->Cell(0, 8, "Mobile Phone: $app_mobile", 0, 1, 'L');
$pdf->Cell(0, 8, "Email: $app_email", 0, 1, 'L');
$pdf->Cell(0, 8, "Date: $app_date", 0, 1, 'L');
$pdf->Ln(5);

// Part E: Verification from Department
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Part E: Verification from Department or Postgraduate Research Sub-Committee', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 8, "Signature Coordinator of Committee: " . ($_SESSION['cb_signature'] ?? ''), 0, 'L');
$pdf->MultiCell(0, 8, "Official Stamp: " . ($_SESSION['cb_stamp'] ?? ''), 0, 'L');
$pdf->Cell(0, 8, "Date Submitted: $date_submitted", 0, 1, 'L');
$pdf->Ln(5);

// Output the PDF
$pdf->Output('D', 'Ethics_Approval_Application_Form.pdf');





// Generate and save BERC5 PDF
// University Header
$pdf->Image('image/Uitm.png', 10, 10, 30);
$pdf->SetXY(50, 10);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Universiti Teknologi MARA', 0, 1, 'L');
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetXY(50, 18);
$pdf->Cell(0, 10, '13500 Permatang Pauh', 0, 1, 'L');
$pdf->SetXY(50, 24);
$pdf->Cell(0, 10, 'Tel: 04-382 2888 | Faks: 04-382 2776', 0, 1, 'L');
$pdf->Ln(10);

// Form Title
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Applicant Checklist', 0, 1, 'C');
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Senarai Semak Pemohon', 0, 1, 'C');
$pdf->Ln(10);

// Terms of Submission
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Terms of Submission of Faculty/Branch Research Ethics Approval Application', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 8, "1. Ensure all research team members have signed the application.\n2. Ensure the application is endorsed by the Faculty/Campus Research Committee.\n3. Submit all required documents two weeks before the BERC meeting.\n4. Forms must be in English (unless approved for other languages).\n5. Data collection instruments must be in Malay, English, or other languages understood by participants.\n", 0, 'L');
$pdf->Ln(5);

// Part A - For All Applicants
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Part A – For All Applicants / Bahagian A - Untuk Semua Pemohon', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

// Part A Questions
$questions = [
    "Have you completed the F/BERC 1 form? (Adakah anda telah melengkapkan borang F/BERC 1?)",
    "Have you completed the F/BERC 2 form? (Adakah anda telah melengkapkan borang F/BERC 2?)",
    "Have you completed the F/BERC 3 form? (Adakah anda telah melengkapkan borang F/BERC 3?)",
    "Have you completed the F/BERC 4 form? (Adakah anda telah melengkapkan borang F/BERC 4?)",
    "Have you completed the F/BERC 5 form? (Adakah anda telah melengkapkan borang F/BERC 5?)",
    "Has the form been signed by all researchers? (Adakah borang ditandatangani oleh semua penyelidik?)",
    "Has your application been endorsed by your Faculty/State Research Committee? (Adakah permohonan anda mendapat kelulusan Jawatankuasa Penyelidikan Fakulti/Negeri?)",
    "Has your supervisor checked for grammatical errors in REC 2 and REC 4 forms? (Adakah penyelia anda menyemak borang REC 2 dan REC 4?)"
];

// Responses from session
$responses = [
    $formData['fberc1_berc5'],
    $formData['fberc2_berc5'],
    $formData['fberc3_berc5'],
    $formData['fberc4_berc5'],
    $formData['fberc5_berc5'],
    $formData['form_signed_berc5'],
    $formData['approved_by_faculty_berc5'],
    $formData['supervisor_checked_berc5']
];

// Display Part A Questions and Responses
foreach ($questions as $index => $question) {
    $pdf->Cell(0, 8, $question, 0, 1, 'L');
    $pdf->Cell(0, 8, "Response: " . $responses[$index], 0, 1, 'L');
}
$pdf->Ln(5);

// Part B - Upload Forms Instructions
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Part B – Upload Forms / Bahagian B - Muat Naik Borang', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 8, "Please upload scanned forms (BERC 1, BERC 2, BERC 3, BERC 5 / BERC 4) to the following link:\nhttps://forms.gle/aMZLG7zuwEZpL6KP8\nSubmit applications at least two weeks before the meeting:\nhttps://penang.uitm.edu.my/index.php/component/sppagebuilder/?view=page&id=41", 0, 'L');
$pdf->Ln(5);

// Decision
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Decision / Keputusan', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$decision = ($formData['decision_berc5'] == 'approved') ? "Approve / Lulus" : "Not approved due to ethical issues / Tidak lulus disebabkan isu etika";
$pdf->Cell(0, 8, "Decision: $decision", 0, 1, 'L');
$pdf->Ln(5);

// Additional Comments
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Additional Comments / Komen Tambahan', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 8, $formData['additional_comments_berc5'], 0, 'L');
$pdf->Ln(5);

// Applicant Signature
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Applicant's Signature / Tandatangan Pemohon", 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, "Date: " . $formData['applicant_date_berc5'], 0, 1, 'L');
$pdf->Ln(5);

// Supervisor Signature
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Supervisor's Signature / Tandatangan Penyelia", 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, "Date: " . $formData['supervisor_date_berc5'], 0, 1, 'L');
$pdf->Ln(10);

// Output the PDF
$pdf->Output('D', 'Applicant_Checklist.pdf');

// Close the connection
$conn->close();