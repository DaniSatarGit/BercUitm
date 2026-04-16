<?php
session_start();

// Include the database connection
include '../../config.php'; // Include the connection from db_connection.php

// Semak jika pengguna log masuk
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Assign session variables to local variables
$research_title = $_SESSION['research_title'];
$researcher_name = $_SESSION['researcher_name'];
$part_a_supervisor_name = $_SESSION['part_a_supervisor_name'];
$department_address = $_SESSION['department_address'];
$contact_info = $_SESSION['contact_info'];
$researcher_level = $_SESSION['researcher_level'];
$ethics_approval = $_SESSION['ethics_approval'];
$research_funding = $_SESSION['research_funding'];
$research_methods = implode(",", $_SESSION['research_methods']);
$background = $_SESSION['background'];
$problem_statement = $_SESSION['problem_statement'];
$rujukan = $_SESSION['rujukan'];
$research_objectives = $_SESSION['research_objectives'];
$expected_benefits = $_SESSION['expected_benefits'];
$research_dates = $_SESSION['research_dates'];
$data_collection_date = $_SESSION['data_collection_date'];
$research_location = $_SESSION['research_location'];
$research_design = $_SESSION['research_design'];
$inclusion_criteria = $_SESSION['inclusion_criteria'];
$exclusion_criteria = $_SESSION['exclusion_criteria'];
$sample_size = $_SESSION['sample_size'];
$calculation = $_SESSION['calculation'];
$calculation_upload = $_SESSION['calculation_upload'];
$flowchart = $_SESSION['flowchart'];
$statistical_analysis = $_SESSION['statistical_analysis'];
$grant_source = $_SESSION['grant_source'];
$grant_approval_date = $_SESSION['grant_approval_date'];
$total_allocation = $_SESSION['total_allocation'];
$grant_duration = $_SESSION['grant_duration'];
$grant_others = $_SESSION['grant_others'];
$applicant_name = $_SESSION['applicant_name'];
$applicant_staff_id = $_SESSION['applicant_staff_id'];
$applicant_position = $_SESSION['applicant_position'];
$applicant_affiliation = $_SESSION['applicant_affiliation'];
$applicant_office_phone = $_SESSION['applicant_office_phone'];
$applicant_mobile_phone = $_SESSION['applicant_mobile_phone'];
$applicant_email = $_SESSION['applicant_email'];
$applicant_signature = $_SESSION['applicant_signature'];
$applicant_date = $_SESSION['applicant_date'];
$supervisor_name = $_SESSION['supervisor_name'];
$supervisor_staff_id = $_SESSION['supervisor_staff_id'];
$supervisor_position = $_SESSION['supervisor_position'];
$supervisor_affiliation = $_SESSION['supervisor_affiliation'];
$supervisor_office_phone = $_SESSION['supervisor_office_phone'];
$supervisor_mobile_phone = $_SESSION['supervisor_mobile_phone'];
$supervisor_email = $_SESSION['supervisor_email'];
$supervisor_signature = $_SESSION['supervisor_signature'];
$supervisor_date = $_SESSION['supervisor_date'];
$co_researcher_name = $_SESSION['co_researcher_name'];
$co_researcher_staff_id = $_SESSION['co_researcher_staff_id'];
$co_researcher_position = $_SESSION['co_researcher_position'];
$co_researcher_affiliation = $_SESSION['co_researcher_affiliation'];
$co_researcher_office_phone = $_SESSION['co_researcher_office_phone'];
$co_researcher_mobile_phone = $_SESSION['co_researcher_mobile_phone'];
$co_researcher_email = $_SESSION['co_researcher_email'];
$co_researcher_signature = $_SESSION['co_researcher_signature'];
$co_researcher_date = $_SESSION['co_researcher_date'];
$is_children_under_18 = $_SESSION['is_children_under_18'];
$is_vulnerable_group = $_SESSION['is_vulnerable_group'];
$is_terminal_care = $_SESSION['is_terminal_care'];
$is_unable_to_give_consent = $_SESSION['is_unable_to_give_consent'];
$is_emolument = $_SESSION['is_emolument'];
$children_under_18_description = $_SESSION['children_under_18_description'];
$vulnerable_group_description = $_SESSION['vulnerable_group_description'];
$terminal_care_description = $_SESSION['terminal_care_description'];
$unable_to_give_consent_description = $_SESSION['unable_to_give_consent_description'];
$emolument_description = $_SESSION['emolument_description'];
$data_discomfort = $_SESSION['data_discomfort'];
$undeclared_measures = $_SESSION['undeclared_measures'];
$data_availability = $_SESSION['data_availability'];
$data_discomfort_description = $_SESSION['data_discomfort_description'];
$undeclared_measures_description = $_SESSION['undeclared_measures_description'];
$data_availability_description = $_SESSION['data_availability_description'];
$collects_biological_samples = $_SESSION['collects_biological_samples'];
$can_identify_participants = $_SESSION['can_identify_participants'];
$is_invasive_method = $_SESSION['is_invasive_method'];
$involves_vigorous_tests = $_SESSION['involves_vigorous_tests'];
$is_non_athlete_or_chronic = $_SESSION['is_non_athlete_or_chronic'];
$involves_maximal_exercise = $_SESSION['involves_maximal_exercise'];
$involves_procedure_or_medication = $_SESSION['involves_procedure_or_medication'];
$involves_unapproved_indication = $_SESSION['involves_unapproved_indication'];
$consent_from_others = $_SESSION['consent_from_others'];
$risk_if_withdraw = $_SESSION['risk_if_withdraw'];
$stores_samples = $_SESSION['stores_samples'];
$analyses_sample_other_purpose = $_SESSION['analyses_sample_other_purpose'];
$consent_for_other_purpose = $_SESSION['consent_for_other_purpose'];
$biological_samples_type = $_SESSION['biological_samples_type'];
$biological_samples_description = $_SESSION['biological_samples_description'];
$identify_participants_description = $_SESSION['identify_participants_description'];
$invasive_method_description = $_SESSION['invasive_method_description'];
$vigorous_tests_description = $_SESSION['vigorous_tests_description'];
$non_athletes_chronic_illness_description = $_SESSION['non_athletes_chronic_illness_description'];
$maximal_exercise_description = $_SESSION['maximal_exercise_description'];
$procedure_medication_description = $_SESSION['procedure_medication_description'];
$unapproved_indication_description = $_SESSION['unapproved_indication_description'];
$consent_other_than_participants_description = $_SESSION['consent_other_than_participants_description'];
$risk_withdrawal_description = $_SESSION['risk_withdrawal_description'];
$store_samples_future_research_description = $_SESSION['store_samples_future_research_description'];
$analyse_sample_other_purpose_description = $_SESSION['analyse_sample_other_purpose_description'];
$consent_for_other_purpose_description = $_SESSION['consent_for_other_purpose_description'];
$other_ethical_issues = $_SESSION['other_ethical_issues'];
$other_ethical_issues_description = $_SESSION['other_ethical_issues_description'];
$presented_proposal = $_SESSION['presented_proposal'];
$completed_berc1 = $_SESSION['completed_berc1'];
$completed_berc2_or_3 = $_SESSION['completed_berc2_or_3'];
$supervisor_checked = $_SESSION['supervisor_checked'];
$signed_by_all_researchers = $_SESSION['signed_by_all_researchers'];
$endorsed_by_committee = $_SESSION['endorsed_by_committee'];
$additional_comments = $_SESSION['additional_comments'];
$Applicants_Signature_F = $_SESSION['Applicants_Signature_F'];
$Applicants_Date_F = $_SESSION['Applicants_Date_F'];
$Supervisors_Signature = $_SESSION['Supervisors_Signature'];
$Supervisors_Date = $_SESSION['Supervisors_Date'];
$Risk = $_SESSION['Risk'];
$Coordinator_Signature_G = $_SESSION['Coordinator_Signature_G'];
$Official_stamp_G = $_SESSION['Official_stamp_G'];
$Coordinator_Date = $_SESSION['Coordinator_Date'];
$submission_date = $_SESSION['submission_date'];

    // Handling uploaded files
    $uploadDir = 'uploads/';
    $calculationFilePath = '';
    $flowchartFilePath = '';

    // Handling Calculation File
    if (isset($_FILES['calculation_upload']) && $_FILES['calculation_upload']['error'] == UPLOAD_ERR_OK) {
        $calculationFileName = basename($_FILES['calculation_upload']['name']);
        $calculationFilePath = $uploadDir . $calculationFileName;
        if (move_uploaded_file($_FILES['calculation_upload']['tmp_name'], $calculationFilePath)) {
            $_SESSION['calculation'] = $calculationFilePath;
        } else {
            echo "Error uploading calculation file.";
        }
    } else {
        // If no new file was uploaded, keep the existing file if any
        $_SESSION['calculation'] = $draft['calculation'] ?? '';
    }

    // Handling Flowchart File
    if (isset($_FILES['flowchart_file']) && $_FILES['flowchart_file']['error'] == UPLOAD_ERR_OK) {
        $flowchartFileName = basename($_FILES['flowchart_file']['name']);
        $flowchartFilePath = $uploadDir . $flowchartFileName;
        if (move_uploaded_file($_FILES['flowchart_file']['tmp_name'], $flowchartFilePath)) {
            $_SESSION['flowchart'] = $flowchartFilePath;
        } else {
            echo "Error uploading flowchart file.";
        }
    } else {
        // If no new file was uploaded, keep the existing file if any
        $_SESSION['flowchart'] = $draft['flowchart'] ?? '';
    }

// Corrected Insert query
$query1 = "INSERT INTO berc1 (
    user_id, research_title, researcher_name, part_a_supervisor_name, department_address, contact_info, 
    researcher_level, ethics_approval, research_funding, research_methods, background, problem_statement, 
    rujukan, research_objectives, expected_benefits, research_dates, data_collection_date, research_location, 
    research_design, inclusion_criteria, exclusion_criteria, sample_size, calculation, calculation_upload, flowchart, statistical_analysis, 
    grant_source, grant_approval_date, total_allocation, grant_duration, grant_others, applicant_name, applicant_staff_id, 
    applicant_position, applicant_affiliation, applicant_office_phone, applicant_mobile_phone, applicant_email, 
    applicant_signature, applicant_date, supervisor_name, supervisor_staff_id, supervisor_position, supervisor_affiliation, 
    supervisor_office_phone, supervisor_mobile_phone, supervisor_email, supervisor_signature, supervisor_date, co_researcher_name, 
    co_researcher_staff_id, co_researcher_position, co_researcher_affiliation, co_researcher_office_phone, co_researcher_mobile_phone, 
    co_researcher_email, co_researcher_signature, co_researcher_date, is_children_under_18, is_vulnerable_group, is_terminal_care, 
    is_unable_to_give_consent, is_emolument, children_under_18_description, vulnerable_group_description, terminal_care_description, 
    unable_to_give_consent_description, emolument_description, data_discomfort, undeclared_measures, data_availability, data_discomfort_description, 
    undeclared_measures_description, data_availability_description, collects_biological_samples, can_identify_participants, is_invasive_method, involves_vigorous_tests, 
    is_non_athlete_or_chronic, involves_maximal_exercise, involves_procedure_or_medication, involves_unapproved_indication, consent_from_others, 
    risk_if_withdraw, stores_samples, analyses_sample_other_purpose, consent_for_other_purpose, biological_samples_type, biological_samples_description, 
    identify_participants_description, invasive_method_description, vigorous_tests_description, non_athletes_chronic_illness_description, 
    maximal_exercise_description, procedure_medication_description, unapproved_indication_description, consent_other_than_participants_description, 
    risk_withdrawal_description, store_samples_future_research_description, analyse_sample_other_purpose_description, consent_for_other_purpose_description, 
    other_ethical_issues, other_ethical_issues_description, presented_proposal, completed_berc1, completed_berc2_or_3, supervisor_checked, 
    signed_by_all_researchers, endorsed_by_committee, additional_comments, Applicants_Signature_F, Applicants_Date_F, Supervisors_Signature, 
    Supervisors_Date, Risk, Coordinator_Signature_G, Official_stamp_G, Coordinator_Date, submission_date
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
          ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
          ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
          ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query1);

// Ensure you bind exactly 117 values
$stmt1->bind_param(
    str_repeat('s', 119), // This is a shorthand for repeating 's' 117 times to match all placeholders
    $user_id, $research_title, $researcher_name, $part_a_supervisor_name, $department_address, $contact_info, 
    $researcher_level, $ethics_approval, $research_funding, $research_methods, $background, $problem_statement, 
    $rujukan, $research_objectives, $expected_benefits, $research_dates, $data_collection_date, $research_location, 
    $research_design, $inclusion_criteria, $exclusion_criteria, $sample_size, $calculation, $calculation_upload, $flowchart, $statistical_analysis, 
    $grant_source, $grant_approval_date, $total_allocation, $grant_duration, $grant_others, $applicant_name, $applicant_staff_id, 
    $applicant_position, $applicant_affiliation, $applicant_office_phone, $applicant_mobile_phone, $applicant_email, 
    $applicant_signature, $applicant_date, $supervisor_name, $supervisor_staff_id, $supervisor_position, $supervisor_affiliation, 
    $supervisor_office_phone, $supervisor_mobile_phone, $supervisor_email, $supervisor_signature, $supervisor_date, $co_researcher_name, 
    $co_researcher_staff_id, $co_researcher_position, $co_researcher_affiliation, $co_researcher_office_phone, $co_researcher_mobile_phone, 
    $co_researcher_email, $co_researcher_signature, $co_researcher_date, $is_children_under_18, $is_vulnerable_group, $is_terminal_care, 
    $is_unable_to_give_consent, $is_emolument, $children_under_18_description, $vulnerable_group_description, $terminal_care_description, 
    $unable_to_give_consent_description, $emolument_description, $data_discomfort, $undeclared_measures, $data_availability, $data_discomfort_description,
    $undeclared_measures_description, $data_availability_description, $collects_biological_samples, $can_identify_participants, $is_invasive_method, $involves_vigorous_tests, 
    $is_non_athlete_or_chronic, $involves_maximal_exercise, $involves_procedure_or_medication, $involves_unapproved_indication, $consent_from_others, 
    $risk_if_withdraw, $stores_samples, $analyses_sample_other_purpose, $consent_for_other_purpose, $biological_samples_type, $biological_samples_description, 
    $identify_participants_description, $invasive_method_description, $vigorous_tests_description, $non_athletes_chronic_illness_description, 
    $maximal_exercise_description, $procedure_medication_description, $unapproved_indication_description, $consent_other_than_participants_description, 
    $risk_withdrawal_description, $store_samples_future_research_description, $analyse_sample_other_purpose_description, $consent_for_other_purpose_description, 
    $other_ethical_issues, $other_ethical_issues_description, $presented_proposal, $completed_berc1, $completed_berc2_or_3, $supervisor_checked, 
    $signed_by_all_researchers, $endorsed_by_committee, $additional_comments, $Applicants_Signature_F, $Applicants_Date_F, $Supervisors_Signature, 
    $Supervisors_Date, $Risk, $Coordinator_Signature_G, $Official_stamp_G, $Coordinator_Date, $submission_date
);

// Execute the statement
if ($stmt1->execute()) {
    echo "Data dari Halaman 1 berjaya disimpan!<br>";
} else {
    echo "Ralat: " . $stmt1->error . "<br>";
}

// Assign session variables to local variables BERC 2
$projectTitle_berc2 = $_SESSION['projectTitle_berc2'];
$projectDescription_berc2 = $_SESSION['projectDescription_berc2'];
$projectPurpose_berc2 = $_SESSION['projectPurpose_berc2'];
$projectProcedure_berc2 = $_SESSION['projectProcedure_berc2'];
$projectParticipation_berc2 = $_SESSION['projectParticipation_berc2'];
$projectBenefit_berc2 = $_SESSION['projectBenefit_berc2'];
$projectRisk_berc2 = $_SESSION['projectRisk_berc2'];
$projectConfidential_berc2 = $_SESSION['projectConfidential_berc2'];
$participantName_berc2 = $_SESSION['participantName_berc2'];
$participantSignature_berc2 = $_SESSION['participantSignature_berc2'];
$participantIC_berc2 = $_SESSION['participantIC_berc2'];
$participantDate_berc2 = $_SESSION['participantDate_berc2'];
$witnessName_berc2 = $_SESSION['witnessName_berc2'];
$witnessSignature_berc2 = $_SESSION['witnessSignature_berc2'];
$witnessIC_berc2 = $_SESSION['witnessIC_berc2'];
$witnessDate_berc2 = $_SESSION['witnessDate_berc2'];
$consentTakerName_berc2 = $_SESSION['consentTakerName_berc2'];
$consentTakerSignature_berc2 = $_SESSION['consentTakerSignature_berc2'];
$consentTakerIC_berc2 = $_SESSION['consentTakerIC_berc2'];
$consentTakerDate_berc2 = $_SESSION['consentTakerDate_berc2'];

// Insert query
$query2 = "INSERT INTO berc2 (
    user_id, projectTitle_berc2, projectDescription_berc2, projectPurpose_berc2, projectProcedure_berc2, 
    projectParticipation_berc2, projectBenefit_berc2, projectRisk_berc2, projectConfidential_berc2,
    participantName_berc2, participantSignature_berc2, participantIC_berc2, participantDate_berc2,
    witnessName_berc2, witnessSignature_berc2, witnessIC_berc2, witnessDate_berc2,
    consentTakerName_berc2, consentTakerSignature_berc2, consentTakerIC_berc2, consentTakerDate_berc2
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare statement
$stmt2 = $conn->prepare($query2);

// Bind the parameters
$stmt2->bind_param(
    'sssssssssssssssssssss',
    $user_id, $projectTitle_berc2, $projectDescription_berc2, $projectPurpose_berc2, $projectProcedure_berc2, $projectParticipation_berc2, $projectBenefit_berc2,
    $projectRisk_berc2, $projectConfidential_berc2, $participantName_berc2, $participantSignature_berc2, $participantIC_berc2, $participantDate_berc2, $witnessName_berc2, 
    $witnessSignature_berc2, $witnessIC_berc2, $witnessDate_berc2, $consentTakerName_berc2, $consentTakerSignature_berc2, $consentTakerIC_berc2, $consentTakerDate_berc2
);

// Execute the statement
if ($stmt2->execute()) {
    echo "Data berjaya disimpan!<br>";
} else {
    echo "Ralat: " . $stmt2->error . "<br>";
}

//berc
$projectName_berc3 = $_SESSION['projectName_berc3'];
$projectDescription_berc3 = $_SESSION['projectDescription_berc3'];
$projectPurpose_berc3 = $_SESSION['projectPurpose_berc3'];
$projectRole_berc3 = $_SESSION['projectRole_berc3'];
$projectRisk_berc3 = $_SESSION['projectRisk_berc3'];
$projectParticipation_berc3 = $_SESSION['projectParticipation_berc3'];
$researcherName_berc3 = $_SESSION['researcherName_berc3'];
$researcherContact_berc3 = $_SESSION['researcherContact_berc3'];
$confidentiality_berc3 = $_SESSION['confidentiality_berc3'];
$explained_project_berc3 = $_SESSION['explained_project_berc3'];
$understand_project_berc3 = $_SESSION['understand_project_berc3'];
$questions_about_project_berc3 = $_SESSION['questions_about_project_berc3'];
$question_answer_berc3 = $_SESSION['question_answer_berc3'];
$stop_participation_berc3 = $_SESSION['stop_participation_berc3'];
$ok_to_participate_berc3 = $_SESSION['ok_to_participate_berc3'];
$voice_recording_berc3 = $_SESSION['voice_recording_berc3'];
$on_video_berc3 = $_SESSION['on_video_berc3'];
$photographs_berc3 = $_SESSION['photographs_berc3'];
$participantName_berc3 = $_SESSION['participantName_berc3'];
$participantSignature_berc3 = $_SESSION['participantSignature_berc3'];
$participantDate_berc3 = $_SESSION['participantDate_berc3'];
$consentTakerName_berc3 = $_SESSION['consentTakerName_berc3'];
$consentTakerSignature_berc3 = $_SESSION['consentTakerSignature_berc3'];
$consentTakerDate_berc3 = $_SESSION['consentTakerDate_berc3'];
$witnessName_berc3 = $_SESSION['witnessName_berc3'];
$witnessSignature_berc3 = $_SESSION['witnessSignature_berc3'];
$witnessDate_berc3 = $_SESSION['witnessDate_berc3'];

// Insert into ber3
        $query3 = "INSERT INTO berc3 (user_id, projectName_berc3, projectDescription_berc3, projectPurpose_berc3, projectRole_berc3, projectRisk_berc3, projectParticipation_berc3, researcherName_berc3, researcherContact_berc3, confidentiality_berc3, explained_project_berc3, understand_project_berc3, questions_about_project_berc3, question_answer_berc3, stop_participation_berc3, ok_to_participate_berc3, voice_recording_berc3, on_video_berc3, photographs_berc3, participantName_berc3, participantSignature_berc3, participantDate_berc3, consentTakerName_berc3, consentTakerSignature_berc3, consentTakerDate_berc3, witnessName_berc3, witnessSignature_berc3, witnessDate_berc3)  
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt3 = $conn->prepare($query3); 
$stmt3->bind_param(
"ssssssssssssssssssssssssssss",
$user_id, $projectName_berc3, $projectDescription_berc3,
$projectPurpose_berc3, $projectRole_berc3, $projectRisk_berc3,$projectParticipation_berc3,$researcherName_berc3, $researcherContact_berc3, $confidentiality_berc3, $explained_project_berc3,
$understand_project_berc3, $questions_about_project_berc3, $question_answer_berc3, $stop_participation_berc3, $ok_to_participate_berc3, $voice_recording_berc3, $on_video_berc3,$photographs_berc3, $participantName_berc3, $participantSignature_berc3, $participantDate_berc3, $consentTakerName_berc3, $consentTakerSignature_berc3, $consentTakerDate_berc3, $witnessName_berc3, $witnessSignature_berc3, $witnessDate_berc3
);

if ($stmt3->execute()) {
    echo "Data dari Berc3 berjaya disimpan!<br>";
} else {
    echo "Ralat: " . $stmt3->error . "<br>";
}

// Dapatkan data dari BERC5
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

$query4 = "INSERT INTO berc5 (user_id, fberc1_berc5, fberc2_berc5, fberc3_berc5, fberc4_berc5, fberc5_berc5, form_signed_berc5, approved_by_faculty_berc5, supervisor_checked_berc5, additional_comments_berc5, decision_berc5, applicant_signature_berc5, applicant_date_berc5, supervisor_signature_berc5, supervisor_date_berc5, submission_date_berc5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt4 = $conn->prepare($query4);
$stmt4->bind_param("sssssssssssssss", $user_id, $fberc1_berc5, $fberc2_berc5, $fberc3_berc5, $fberc4_berc5, $fberc5_berc5, $form_signed_berc5, $approved_by_faculty_berc5, $supervisor_checked_berc5, $additional_comments_berc5, $decision_berc5, $applicant_signature_berc5, $applicant_date_berc5, $supervisor_signature_berc5, $supervisor_date_berc5);

if ($stmt4->execute()) {
    echo "Data dari Berc5 berjaya disimpan!";
} else {
    echo "Ralat: " . $stmt4->error;
}

$delete_draft1_sql = "DELETE FROM berc1_draft WHERE user_id = ?";
$stmt_delete1 = $conn->prepare($delete_draft1_sql);
$stmt_delete1->bind_param("s", $user_id);
$stmt_delete1->execute();

if ($stmt_delete1->affected_rows > 0) {
    echo "Data draf Halaman 1 berjaya dipadamkan!<br>";
} else {
    echo "Tiada data draf untuk dipadamkan dari Halaman 1 atau ralat berlaku.<br>";
}

// Padam data draf dari berc2_draft
$delete_draft2_sql = "DELETE FROM berc2_draft WHERE user_id = ?";
$stmt_delete2 = $conn->prepare($delete_draft2_sql);
$stmt_delete2->bind_param("s", $user_id);
$stmt_delete2->execute();

if ($stmt_delete2->affected_rows > 0) {
    echo "Data draf Halaman 2 berjaya dipadamkan!<br>";
} else {
    echo "Tiada data draf untuk dipadamkan dari Halaman 2 atau ralat berlaku.<br>";
}

// Padam data draf dari berc3_draft
$delete_draft3_sql = "DELETE FROM berc3_draft WHERE user_id = ?";
$stmt_delete3 = $conn->prepare($delete_draft3_sql);
$stmt_delete3->bind_param("s", $user_id);
$stmt_delete3->execute();

if ($stmt_delete3->affected_rows > 0) {
    echo "Data draf Halaman 3 berjaya dipadamkan!<br>";
} else {
    echo "Tiada data draf untuk dipadamkan dari Halaman 3 atau ralat berlaku.<br>";
}

// Padam data draf dari berc5_draft
$delete_draft5_sql = "DELETE FROM berc5_draft WHERE user_id = ?";
$stmt_delete5 = $conn->prepare($delete_draft5_sql);
$stmt_delete5->bind_param("s", $user_id);
$stmt_delete5->execute();

if ($stmt_delete5->affected_rows > 0) {
    echo "Data draf Halaman 5 berjaya dipadamkan!<br>";
} else {
    echo "Tiada data draf untuk dipadamkan dari Halaman 5 atau ralat berlaku.<br>";
}

// Alihkan ke halaman pengesahan
header("Location: submit.php");

// Tutup sambungan
$conn->close();
?>