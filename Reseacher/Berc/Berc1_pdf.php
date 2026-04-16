<?php
require('../fpdf/fpdf.php');
include '../../config.php'; // Include the database connection
session_start();

// Get the current user's ID
$user_id = $_SESSION['user_id'];

// Get the form ID from the URL
$form_id = $_GET['form_id'];

// Fetch the BERC1 form details from the database
$sql_berc1 = "SELECT * FROM berc1 WHERE user_id = ? AND id = ?";
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
    $pdf->Cell(0, 10, 'Ethics Approval Application Form for ', 0, 1, 'C');
    $pdf->Cell(0, 0, 'Undergraduates or Postgraduates by Coursework', 0, 1, 'C');
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Ln(4); // Space after header
    $pdf->Cell(0, 10, 'Borang Permohonan Kelulusan Etika bagi Pelajar', 0, 1, 'C');
    $pdf->Cell(0, 0, 'Sarjana Muda atau Pasca Siswazah Kerja Kursus', 0, 1, 'C');
    $pdf->Ln(10); // Space after header

    // Part A : Details of Researcher
    $pdf->SetFont('Arial', 'B',12);
    $pdf->Cell(0, 10, 'Part A: Details of Researcher',0,1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian A: Maklumat Penyelidik', 0, 1);
    $pdf->Ln(4); // Space after header
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 10, 'Research Title:', 1, 0);
    $pdf->Cell(140, 10, $row['research_title'], 1, 1);
    $pdf->Cell(50, 10, 'Researcher Name:', 1, 0);
    $pdf->Cell(140, 10, $row['researcher_name'], 1, 1);
    $pdf->Cell(50, 10, 'Part A Supervisor Name:', 1, 0);
    $pdf->Cell(140, 10, $row['part_a_supervisor_name'], 1, 1);
    $pdf->Cell(50, 10, 'Department Address:', 1, 0);
    $pdf->Cell(140, 10, $row['department_address'], 1, 1);
    $pdf->Cell(50, 10, 'Contact Info:', 1, 0);
    $pdf->Cell(140, 10, $row['contact_info'], 1, 1);
    $pdf->Cell(50, 10, 'Researcher Level:', 1, 0);
    $pdf->Cell(140, 10, $row['researcher_level'], 1, 1);
    $pdf->Cell(50, 10, 'Ethics Approval:', 1, 0);
    $pdf->Cell(140, 10, $row['ethics_approval'], 1, 1);
    $pdf->Cell(50, 10, 'Research Funding:', 1, 0);
    $pdf->Cell(140, 10, $row['research_funding'], 1, 1);
    $pdf->Ln(5);

    // Part B: Research Details
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Part B : Research Details', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian B: Maklumat Penyelidikan', 0, 1);
    
    // Part B2
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Part B1', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian B1', 0, 1);
    $pdf->Ln(4);

    // Research_methods
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 10, 'Research Methods:', 1, 0);
    $pdf->MultiCell(140, 10, $row['research_methods'], 1, 1);
    $pdf->Ln(5);

    //Part B3
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Part B2', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian B2', 0, 1);
    $pdf->Ln(4);

    $pdf->Cell(50, 10, 'Background:', 1, 0);
    $pdf->MultiCell(0, 10, $row['background'], 1, 1);
    $pdf->Cell(50, 10, 'Problem Statement:', 1, 0);
    $pdf->MultiCell(0, 10, $row['problem_statement'], 1, 1);
    $pdf->Cell(50, 10, 'References (Rujukan):', 1, 0);
    $pdf->MultiCell(0, 10, $row['rujukan'], 1, 1);
    $pdf->Cell(50, 10, 'Research Objectives:', 1, 0);
    $pdf->MultiCell(0, 10, $row['research_objectives'], 1, 1);
    $pdf->Cell(50, 10, 'Expected Benefits:', 1, 0);
    $pdf->MultiCell(0, 10, $row['expected_benefits'], 1, 1);
    $pdf->Cell(70, 10, 'Date of Research Commencement-End:', 1, 0);
    $pdf->MultiCell(0, 10, $row['research_dates'], 1, 1);
    $pdf->Cell(70, 10, 'Expected Date of Initial Data Collection:', 1, 0);
    $pdf->MultiCell(0, 10, $row['data_collection_date'], 1, 1);
    $pdf->Cell(50, 10, 'Location of Research:', 1, 0);
    $pdf->MultiCell(0, 10, $row['research_location'], 1, 1);
    $pdf->Cell(60, 10, 'Research Design and Methodology:', 1, 0);
    $pdf->MultiCell(0, 10, $row['research_design'], 1, 1);
    $pdf->Cell(50, 10, 'Inclusion Criteria:', 1, 0);
    $pdf->MultiCell(0, 10, $row['inclusion_criteria'], 1, 1);
    $pdf->Cell(50, 10, 'Exclusion Criteria:', 1, 0);
    $pdf->MultiCell(0, 10, $row['exclusion_criteria'], 1, 1);
    $pdf->Cell(50, 10, 'Sample Size:', 1, 0);
    $pdf->MultiCell(0, 10, $row['sample_size'], 1, 1);
    // Calculation (Teks + Gambar)
    $pdf->Cell(50, 10, 'Calculation:', 1, 0); // Tambah label teks Calculation
    $pdf->MultiCell(140, 10, $row['calculation'], 1, 1); // Papar teks calculation dalam sel

    // Semak jika ada gambar untuk calculation
    if (!empty($row['calculation_upload']) && file_exists($row['calculation_upload'])) {
        // Simpan koordinat untuk gambar
        $x = $pdf->GetX(); 
        $y = $pdf->GetY();

        // Tambah sel kosong untuk imej (saiz laras)
        $pdf->Cell(50, 60, 'Flowchart Image', 1, 0, 'C'); // Sel label kosong
        $pdf->Cell(140, 60, '', 1, 0); // Sel untuk gambar

        // Tambah gambar
        
        $pdf->Image($row['calculation_upload'], $x + 85, $y + 5, 50, 50); // Laraskan saiz & posisi gambar
        $pdf->Ln(60); // Laraskan ruang selepas gambar
    } else {
        // Jika tiada gambar, paparkan mesej
        $pdf->Cell(0, 10, 'Calculation image not found.', 1, 1, 'C');
    }

    // Flowchart (Gambar Sahaja)
    $pdf->Cell(50, 60, 'Research Flowchart:', 1, 0, 'C'); // Laraskan teks di tengah
    if (!empty($row['flowchart']) && file_exists($row['flowchart'])) {
        // Simpan koordinat semasa untuk imej
        $x = $pdf->GetX(); 
        $y = $pdf->GetY();

        // Buat sel kosong dengan sempadan untuk imej
        $pdf->Cell(140, 60, '', 1, 0); // Laraskan lebar sel bergantung pada keperluan
        $pdf->Image($row['flowchart'], $x + 35, $y + 5, 50, 50); // Posisi & saiz imej
        $pdf->Ln(60); // Pindah ke baris baru selepas imej
    } else {
        // Jika imej tiada, paparkan mesej
        $pdf->Cell(140, 60, 'Flowchart image not found.', 1, 0, 'C');
        $pdf->Ln(60); // Pindah ke baris baru selepas mesej
    }

    // Part C
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Part C: Fundings Details', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian C: Maklumat Dana', 0, 1);
    $pdf->Ln(4);

    $pdf->Cell(50, 10, 'Grant/Source:', 1, 0);
    $pdf->MultiCell(0, 10, $row['grant_source'], 1, 1);
    $pdf->Cell(50, 10, 'Date of Grant Approval:', 1, 0);
    $pdf->MultiCell(0, 10, $row['grant_approval_date'], 1, 1);
    $pdf->Cell(50, 10, 'Total Allocation:', 1, 0);
    $pdf->MultiCell(0, 10, $row['total_allocation'], 1, 1);
    $pdf->Cell(50, 10, 'Duration of Grant:', 1, 0);
    $pdf->MultiCell(0, 10, $row['grant_duration'], 1, 1);
    $pdf->Cell(50, 10, 'Others:', 1, 0);
    $pdf->MultiCell(0, 10, $row['grant_others'], 1, 1);
    $pdf->Ln(5);

    // Part D
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Part D: Agreement to Conduct The Research Project', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian D: Pengesahan Persetujuan Menjalankan Penyelidikan', 0, 1);
    $pdf->Ln(4);

    // Applicant
    $pdf->Cell(0, 10, '1. Applicant', 0, 1);
    $pdf->Cell(50, 10, 'Applicant Name:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_name'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Staff ID:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_staff_id'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Position:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_position'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Affiliation:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_affiliation'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Office Phone:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_office_phone'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Mobile Phone:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_mobile_phone'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Email:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_email'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Signature:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_signature'], 1, 1);
    $pdf->Cell(50, 10, 'Applicant Date:', 1, 0);
    $pdf->MultiCell(0, 10, $row['applicant_date'], 1, 1);
    $pdf->Ln(5);

    // Supervisor
    $pdf->Cell(0, 10, '2. Supervisor', 0, 1);
    $pdf->Cell(50, 10, 'Supervisor Name:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_name'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Staff ID:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_staff_id'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Position:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_position'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Affiliation:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_affiliation'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Office Phone:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_office_phone'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Mobile Phone:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_mobile_phone'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Email:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_email'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Signature:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_signature'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisor Date:', 1, 0);
    $pdf->MultiCell(0, 10, $row['supervisor_date'], 1, 1);
    $pdf->Ln(5);

    // Co-Researcher
    $pdf->Cell(0, 10, '3. Co-Researcher', 0, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Name:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_name'], 1, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Staff ID:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_staff_id'], 1, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Position:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_position'], 1, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Affiliation:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_affiliation'], 1, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Office Phone:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_office_phone'], 1, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Mobile Phone:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_mobile_phone'], 1, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Email:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_email'], 1, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Signature:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_signature'], 1, 1);
    $pdf->Cell(50, 10, 'Co-Researcher Date:', 1, 0);
    $pdf->MultiCell(0, 10, $row['co_researcher_date'], 1, 1);
    $pdf->Ln(30);

    // Part E
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Part E: Research Risk Classification', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian E: Klasifikasi Risiko Kajian', 0, 1);
    $pdf->Ln(4);

    // Participant Profile Table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'PARTICIPANT PROFILE', 0, 1);

    // Set font
    $pdf->SetFont('Arial', '', 10);

    // Header Row
    $pdf->Cell(170, 10, 'PARTICIPANT PROFILE', 1, 0, 'C');
    $pdf->Cell(10, 10, 'Yes', 1, 0, 'C');
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1); // Empty cell to move to next line

    // Row 1
    $pdf->MultiCell(170, 10, 'Are the participants children (under 18 years old)?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['is_children_under_18'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['is_children_under_18'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['children_under_18_description'], 1);

    // Row 2
    $pdf->MultiCell(170, 10, 'Are the participants from a particular vulnerable group?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['is_vulnerable_group'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['is_vulnerable_group'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['vulnerable_group_description'], 1);

    // Row 3
    $pdf->MultiCell(170, 10, 'Are any of these participants/patients in terminal care?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['is_terminal_care'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['is_terminal_care'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['terminal_care_description'], 1);

    // Row 4
    $pdf->MultiCell(170, 10, 'Are any of these participants unable or are incapable of giving consent?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['is_unable_to_give_consent'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['is_unable_to_give_consent'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['unable_to_give_consent_description'], 1);

    // Row 5
    $pdf->MultiCell(170, 10, 'Are the participants given any form of emolument to participate?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['is_emolument'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['is_emolument'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['emolument_description'], 1);
    $pdf->Ln(4);

    // Privacy and Confidentiality Table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'PRIVACY AND CONFIDENTIALITY', 0, 1);

    // Set font for content
    $pdf->SetFont('Arial', '', 10);

    // Header Row
    $pdf->Cell(170, 10, 'PRIVACY AND CONFIDENTIALITY', 1, 0, 'C');
    $pdf->Cell(10, 10, 'Yes', 1, 0, 'C');
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1); // Empty cell to move to next line

    // Row 6
    $pdf->MultiCell(170, 10, 'Could the collected data cause discomfort or harm to participants?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['data_discomfort'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['data_discomfort'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['data_discomfort_description'], 1);

    // Row 7
    $pdf->MultiCell(170, 10, 'Does your research involve measures undeclared to the participants?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['undeclared_measures'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['undeclared_measures'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['undeclared_measures_description'], 1);

    // Row 8
    $pdf->MultiCell(170, 10, 'Will the collected data be made available to other parties not involved in the research?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['data_availability'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['data_availability'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['data_availability_description'], 1);

    // Add spacing between sections
    $pdf->Ln(40);

    // RISK OF HARM Table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'RISK OF HARM', 0, 1);

    // Set font for content
    $pdf->SetFont('Arial', '', 10);

    // Header Row
    $pdf->Cell(170, 10, 'RISK OF HARM', 1, 0, 'C');
    $pdf->Cell(10, 10, 'Yes', 1, 0, 'C');
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1); // Empty cell to move to next line

    // Row 9 to Row 21
    $questions = [
        ['Will you be collecting biological samples e.g. body fluids?', 'biological_samples_type', 'biological_samples_description'],
        ['Do you have access to any information that will allow the identification of individual human participants?', 'can_identify_participants', 'identify_participants_description'],
        ['Is the collection method invasive and has the potential to cause harm, pain or discomfort?', 'is_invasive_method', 'invasive_method_description'],
        ['Will the participants be subjected to vigorous physical tests or exercise regime?', 'involves_vigorous_tests', 'vigorous_tests_description'],
        ['Are the participants non-athletes or patients with chronic illness?', 'is_non_athlete_or_chronic', 'non_athletes_chronic_illness_description'],
        ['Will they be subjected to maximal exercise intensity?', 'involves_maximal_exercise', 'maximal_exercise_description'],
        ['Is there any form of procedure/medication involved?', 'involves_procedure_or_medication', 'procedure_medication_description'],
        ['Is there any drug or device used with an unapproved indication?', 'involves_unapproved_indication', 'unapproved_indication_description'],
        ['Can the informed consent be obtained from anyone other than the patient/participants?', 'consent_from_others', 'consent_other_than_participants_description'],
        ['Is there any kind of risk to the participants if he/she chose to withdraw?', 'risk_if_withdraw', 'risk_withdrawal_description'],
        ['Will the samples obtained be stored for future research?', 'stores_samples', 'store_samples_future_research_description'],
        ['Do you propose to analyse the sample outside of the original purpose for which it was collected?', 'analyses_sample_other_purpose', 'analyse_sample_other_purpose_description'],
        ['If Yes to No. 20, have you obtained consent from participants for this purpose?', 'consent_for_other_purpose', 'consent_for_other_purpose_description']
    ];

    foreach ($questions as $question) {
        $pdf->MultiCell(170, 10, $question[0], 1);
        $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
        $pdf->Cell(10, 10, ($row[$question[1]] == 'Yes' ? 'X' : ''), 1, 0, 'C');
        $pdf->Cell(10, 10, ($row[$question[1]] == 'No' ? 'X' : ''), 1, 1, 'C');
        $pdf->MultiCell(0, 10, 'Brief Description: ' . $row[$question[2]], 1);
    }

    // Row 22 - Separate question about biological samples type
    $pdf->MultiCell(190, 10, 'What type of biological samples collected?', 1);
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['biological_samples_type'], 1);
    $pdf->Ln(5);

    // OTHER ETHICAL ISSUES Table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'OTHER ETHICAL ISSUES', 0, 1);

    $pdf->SetFont('Arial', '', 10);

    // Header Row
    $pdf->Cell(170, 10, 'OTHER ETHICAL ISSUES', 1, 0, 'C');
    $pdf->Cell(10, 10, 'Yes', 1, 0, 'C');
    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(0, 10, '', 0, 1); // Empty cell to move to next line

    // Row 23
    $pdf->MultiCell(170, 10, 'Are there any other ethical issues not stated in this checklist?', 1);
    $pdf->SetXY($pdf->GetX() + 170, $pdf->GetY() - 10);
    $pdf->Cell(10, 10, ($row['other_ethical_issues'] == 'Yes' ? 'X' : ''), 1, 0, 'C');
    $pdf->Cell(10, 10, ($row['other_ethical_issues'] == 'No' ? 'X' : ''), 1, 1, 'C');
    $pdf->MultiCell(0, 10, 'Brief Description: ' . $row['other_ethical_issues_description'], 1);
    $pdf->Ln(5);

    // Part F: Applicant Checklist
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Part F: Applicant Checklist', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Bahagian F: Senarai Semak Pemohon', 0, 1);

    // Part A - For All Applicants Table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 0, 'PART A : FOR ALL APPLICANTS', 0, 1);
    $pdf->Ln(4);

    // Part A: Untuk Semua Pemohon
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(170, 10, 'Part A : Untuk Semua Pemohon', 1, 0, 'C');
    $pdf->Cell(10, 10, 'Yes', 1, 0, 'C');
    $pdf->Cell(10, 10, 'No', 1, 1, 'C');

    // Function to create rows
    function createRow($pdf, $question, $yesNoValue) {
        // Print Question
        $yStart = $pdf->GetY();  // Save current Y position
        $pdf->MultiCell(170, 10, $question, 1);
        $yEnd = $pdf->GetY();  // Save the Y position after the question is printed
        
        // Align the Yes/No boxes correctly
        $height = $yEnd - $yStart; // Calculate height used by MultiCell
        $pdf->SetXY(180, $yStart);  // Set position for "Yes" box (X:130 + Cell width 10)
        
        // Print Yes box
        $pdf->Cell(10, $height, ($yesNoValue == 'Yes' ? 'X' : ''), 1, 0, 'C');
        
        // Print No box
        $pdf->Cell(10, $height, ($yesNoValue == 'No' ? 'X' : ''), 1, 1, 'C');
    }
    createRow($pdf, '1. Have you presented your proposal at the Department or Postgraduate Research Sub-Committee?', $row['presented_proposal']);
    createRow($pdf, '2. Have you completed the F/BERC 1 form?', $row['completed_berc1']);
    createRow($pdf, '3. Have you completed the F/BERC 2 or F/BERC 3 form?', $row['completed_berc2_or_3']);
    createRow($pdf, '4. Has your supervisor checked your application forms?', $row['supervisor_checked']);
    createRow($pdf, '5. Has the form been signed by all researchers?', $row['signed_by_all_researchers']);
    createRow($pdf, '6. Has your application been endorsed by the Department or Postgraduate Research Sub-Committee?', $row['endorsed_by_committee']);
    $pdf->Ln(5);

    $pdf->Cell(50, 10, 'Additional Comments:', 1, 0);
    $pdf->MultiCell(0, 10, $row['additional_comments'], 1, 1);
    $pdf->Cell(50, 10, 'Applicants Signature:', 1, 0);
    $pdf->MultiCell(0, 10, $row['Applicants_Signature_F'], 1, 1);
    $pdf->Cell(50, 10, 'Applicants Date:', 1, 0);
    $pdf->MultiCell(0, 10, $row['Applicants_Date_F'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisors Signature:', 1, 0);
    $pdf->MultiCell(0, 10, $row['Supervisors_Signature'], 1, 1);
    $pdf->Cell(50, 10, 'Supervisors Date:', 1, 0);
    $pdf->MultiCell(0, 10, $row['Supervisors_Date'], 1, 1);
    $pdf->Ln(30);

    // Part G
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Part G: Verification from Department or Postgraduate Research Sub-Committee', 0, 1);
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 0, 'Bahagian G: Pengesahan Jawatankuasa Kecil Penyelidikan Jabatan atau Pascasiswazah', 0, 1);
    $pdf->Ln(4);

    $pdf->Cell(50, 10, 'Risk:', 1, 0);
    $pdf->MultiCell(0, 10, $row['Risk'], 1, 1);
    $pdf->Cell(60, 10, 'Signature Coordinator of Committee:', 1, 0);
    $pdf->MultiCell(0, 10, $row['Coordinator_Signature_G'], 1, 1);
    $pdf->Cell(50, 10, 'Official Stamp:', 1, 0);
    $pdf->MultiCell(0, 10, $row['Official_stamp_G'], 1, 1);
    $pdf->Cell(50, 10, 'Coordinator Date:', 1, 0);
    $pdf->MultiCell(0, 10, $row['Coordinator_Date'], 1, 1);

    // Output the PDF
    $pdf->Output('D', 'BERC1_Submission_' . $row['id'] . '.pdf');
} else {
    echo "No BERC1 submission found for this user.";
}
?>
