<?php
session_start(); // Start session if not already started

// Include the database connection
include '../../config.php'; // Include the connection from db_connection.php

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing draft if available
$query = "SELECT * FROM berc1_draft WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$draft = $result->fetch_assoc();

// If the form is submitted to save a draft, use submitted values from $_POST, otherwise use the draft values
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['save_draft']) || isset($_POST['next']))) {
    // Use the submitted form values
    $_SESSION['research_title'] = $_POST['research_title'] ?? '';
    $_SESSION['researcher_name'] = $_POST['researcher_name'] ?? '';
    $_SESSION['part_a_supervisor_name'] = $_POST['part_a_supervisor_name'] ?? '';
    $_SESSION['department_address'] = $_POST['department_address'] ?? '';
    $_SESSION['contact_info'] = $_POST['contact_info'] ?? '';
    $_SESSION['researcher_level'] = $_POST['researcher_level'] ?? '';
    $_SESSION['ethics_approval'] = $_POST['ethics_approval'] ?? '';
    $_SESSION['research_funding'] = $_POST['research_funding'] ?? '';
    $_SESSION['research_methods'] = $_POST['research_methods'] ?? [];
    $_SESSION['background'] = $_POST['background'] ?? '';
    $_SESSION['problem_statement'] = $_POST['problem_statement'] ?? '';
    $_SESSION['rujukan'] = $_POST['rujukan'] ?? '';
    $_SESSION['research_objectives'] = $_POST['research_objectives'] ?? '';
    $_SESSION['expected_benefits'] = $_POST['expected_benefits'] ?? '';
    $_SESSION['research_dates'] = $_POST['research_dates'] ?? '';
    $_SESSION['data_collection_date'] = $_POST['data_collection_date'] ?? '';
    $_SESSION['research_location'] = $_POST['research_location'] ?? '';
    $_SESSION['research_design'] = $_POST['research_design'] ?? '';
    $_SESSION['inclusion_criteria'] = $_POST['inclusion_criteria'] ?? '';
    $_SESSION['exclusion_criteria'] = $_POST['exclusion_criteria'] ?? '';
    $_SESSION['sample_size'] = $_POST['sample_size'] ?? '';
    $_SESSION['calculation'] = $_POST['calculation'] ?? '';
    $_SESSION['statistical_analysis'] = $_POST['statistical_analysis'] ?? '';
    $_SESSION['grant_source'] = $_POST['grant_source'] ?? '';
    $_SESSION['grant_approval_date'] = $_POST['grant_approval_date'] ?? '';
    $_SESSION['total_allocation'] = $_POST['total_allocation'] ?? '';
    $_SESSION['grant_duration'] = $_POST['grant_duration'] ?? '';
    $_SESSION['grant_others'] = $_POST['grant_others'] ?? '';
    $_SESSION['applicant_name'] = $_POST['applicant_name'] ?? '';
    $_SESSION['applicant_staff_id'] = $_POST['applicant_staff_id'] ?? '';
    $_SESSION['applicant_position'] = $_POST['applicant_position'] ?? '';
    $_SESSION['applicant_affiliation'] = $_POST['applicant_affiliation'] ?? '';
    $_SESSION['applicant_office_phone'] = $_POST['applicant_office_phone'] ?? '';
    $_SESSION['applicant_mobile_phone'] = $_POST['applicant_mobile_phone'] ?? '';
    $_SESSION['applicant_email'] = $_POST['applicant_email'] ?? '';
    $_SESSION['applicant_signature'] = $_POST['applicant_signature'] ?? '';
    $_SESSION['applicant_date'] = $_POST['applicant_date'] ?? '';
    $_SESSION['supervisor_name'] = $_POST['supervisor_name'] ?? '';
    $_SESSION['supervisor_staff_id'] = $_POST['supervisor_staff_id'] ?? '';
    $_SESSION['supervisor_position'] = $_POST['supervisor_position'] ?? '';
    $_SESSION['supervisor_affiliation'] = $_POST['supervisor_affiliation'] ?? '';
    $_SESSION['supervisor_office_phone'] = $_POST['supervisor_office_phone'] ?? '';
    $_SESSION['supervisor_mobile_phone'] = $_POST['supervisor_mobile_phone'] ?? '';
    $_SESSION['supervisor_email'] = $_POST['supervisor_email'] ?? '';
    $_SESSION['supervisor_signature'] = $_POST['supervisor_signature'] ?? '';
    $_SESSION['supervisor_date'] = $_POST['supervisor_date'] ?? '';
    $_SESSION['co_researcher_name'] = $_POST['co_researcher_name'] ?? '';
    $_SESSION['co_researcher_staff_id'] = $_POST['co_researcher_staff_id'] ?? '';
    $_SESSION['co_researcher_position'] = $_POST['co_researcher_position'] ?? '';
    $_SESSION['co_researcher_affiliation'] = $_POST['co_researcher_affiliation'] ?? '';
    $_SESSION['co_researcher_office_phone'] = $_POST['co_researcher_office_phone'] ?? '';
    $_SESSION['co_researcher_mobile_phone'] = $_POST['co_researcher_mobile_phone'] ?? '';
    $_SESSION['co_researcher_email'] = $_POST['co_researcher_email'] ?? '';
    $_SESSION['co_researcher_signature'] = $_POST['co_researcher_signature'] ?? '';
    $_SESSION['co_researcher_date'] = $_POST['co_researcher_date'] ?? '';
    $_SESSION['is_children_under_18'] = $_POST['is_children_under_18'] ?? '';
    $_SESSION['is_vulnerable_group'] = $_POST['is_vulnerable_group'] ?? '';
    $_SESSION['is_terminal_care'] = $_POST['is_terminal_care'] ?? '';
    $_SESSION['is_unable_to_give_consent'] = $_POST['is_unable_to_give_consent'] ?? '';
    $_SESSION['is_emolument'] = $_POST['is_emolument'] ?? '';
    $_SESSION['children_under_18_description'] = $_POST['children_under_18_description'] ?? '';
    $_SESSION['vulnerable_group_description'] = $_POST['vulnerable_group_description'] ?? '';
    $_SESSION['terminal_care_description'] = $_POST['terminal_care_description'] ?? '';
    $_SESSION['unable_to_give_consent_description'] = $_POST['unable_to_give_consent_description'] ?? '';
    $_SESSION['emolument_description'] = $_POST['emolument_description'] ?? '';
    $_SESSION['data_discomfort'] = $_POST['data_discomfort'] ?? '';
    $_SESSION['undeclared_measures'] = $_POST['undeclared_measures'] ?? '';
    $_SESSION['data_availability'] = $_POST['data_availability'] ?? '';
    $_SESSION['data_discomfort_description'] = $_POST['data_discomfort_description'] ?? '';
    $_SESSION['undeclared_measures_description'] = $_POST['undeclared_measures_description'] ?? '';
    $_SESSION['data_availability_description'] = $_POST['data_availability_description'] ?? '';
    $_SESSION['collects_biological_samples'] = $_POST['collects_biological_samples'] ?? '';
    $_SESSION['can_identify_participants'] = $_POST['can_identify_participants'] ?? '';
    $_SESSION['is_invasive_method'] = $_POST['is_invasive_method'] ?? '';
    $_SESSION['invasive_method_description'] = $_POST['invasive_method_description'] ?? '';
    $_SESSION['involves_vigorous_tests'] = $_POST['involves_vigorous_tests'] ?? '';
    $_SESSION['vigorous_tests_description'] = $_POST['vigorous_tests_description'] ?? '';
    $_SESSION['is_non_athlete_or_chronic'] = $_POST['is_non_athlete_or_chronic'] ?? '';
    $_SESSION['non_athletes_chronic_illness_description'] = $_POST['non_athletes_chronic_illness_description'] ?? '';
    $_SESSION['involves_maximal_exercise'] = $_POST['involves_maximal_exercise'] ?? '';
    $_SESSION['maximal_exercise_description'] = $_POST['maximal_exercise_description'] ?? '';
    $_SESSION['involves_procedure_or_medication'] = $_POST['involves_procedure_or_medication'] ?? '';
    $_SESSION['procedure_medication_description'] = $_POST['procedure_medication_description'] ?? '';
    $_SESSION['involves_unapproved_indication'] = $_POST['involves_unapproved_indication'] ?? '';
    $_SESSION['unapproved_indication_description'] = $_POST['unapproved_indication_description'] ?? '';
    $_SESSION['consent_from_others'] = $_POST['consent_from_others'] ?? '';
    $_SESSION['consent_other_than_participants_description'] = $_POST['consent_other_than_participants_description'] ?? '';
    $_SESSION['risk_if_withdraw'] = $_POST['risk_if_withdraw'] ?? '';
    $_SESSION['risk_withdrawal_description'] = $_POST['risk_withdrawal_description'] ?? '';
    $_SESSION['stores_samples'] = $_POST['stores_samples'] ?? '';
    $_SESSION['store_samples_future_research_description'] = $_POST['store_samples_future_research_description'] ?? '';
    $_SESSION['analyses_sample_other_purpose'] = $_POST['analyses_sample_other_purpose'] ?? '';
    $_SESSION['analyse_sample_other_purpose_description'] = $_POST['analyse_sample_other_purpose_description'] ?? '';
    $_SESSION['consent_for_other_purpose'] = $_POST['consent_for_other_purpose'] ?? '';
    $_SESSION['consent_for_other_purpose_description'] = $_POST['consent_for_other_purpose_description'] ?? '';
    $_SESSION['biological_samples_type'] = $_POST['biological_samples_type'] ?? '';
    $_SESSION['biological_samples_description'] = $_POST['biological_samples_description'] ?? '';
    $_SESSION['identify_participants_description'] = $_POST['identify_participants_description'] ?? '';
    $_SESSION['other_ethical_issues'] = $_POST['other_ethical_issues'] ?? '';
    $_SESSION['other_ethical_issues_description'] = $_POST['other_ethical_issues_description'] ?? '';
    $_SESSION['presented_proposal'] = $_POST['presented_proposal'] ?? '';
    $_SESSION['completed_berc1'] = $_POST['completed_berc1'] ?? '';
    $_SESSION['completed_berc2_or_3'] = $_POST['completed_berc2_or_3'] ?? '';
    $_SESSION['supervisor_checked'] = $_POST['supervisor_checked'] ?? '';
    $_SESSION['signed_by_all_researchers'] = $_POST['signed_by_all_researchers'] ?? '';
    $_SESSION['endorsed_by_committee'] = $_POST['endorsed_by_committee'] ?? '';
    $_SESSION['additional_comments'] = $_POST['additional_comments'] ?? '';
    $_SESSION['Applicants_Signature_F'] = $_POST['Applicants_Signature_F'] ?? '';
    $_SESSION['Applicants_Date_F'] = $_POST['Applicants_Date_F'] ?? '';
    $_SESSION['Supervisors_Signature'] = $_POST['Supervisors_Signature'] ?? '';
    $_SESSION['Supervisors_Date'] = $_POST['Supervisors_Date'] ?? '';
    $_SESSION['Risk'] = $_POST['Risk'] ?? '';
    $_SESSION['Coordinator_Signature_G'] = $_POST['Coordinator_Signature_G'] ?? '';
    $_SESSION['Official_stamp_G'] = $_POST['Official_stamp_G'] ?? '';
    $_SESSION['Coordinator_Date'] = $_POST['Coordinator_Date'] ?? '';
    $_SESSION['submission_date'] = $_POST['submission_date'] ?? '';

    // Handling uploaded files
    $uploadDir = 'uploads/';
    $calculationFilePath = '';
    $flowchartFilePath = '';

    // Handling Calculation File
    if (isset($_FILES['calculation_upload']) && $_FILES['calculation_upload']['error'] == UPLOAD_ERR_OK) {
        $calculationFileName = basename($_FILES['calculation_upload']['name']);
        $calculationFilePath = $uploadDir . $calculationFileName;
        if (move_uploaded_file($_FILES['calculation_upload']['tmp_name'], $calculationFilePath)) {
            $_SESSION['calculation_upload'] = $calculationFilePath;
        } else {
            echo "Error uploading calculation file.";
        }
    } else {
        // If no new file was uploaded, keep the existing file if any
        $_SESSION['calculation_upload'] = $draft['calculation_upload'] ?? '';
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

// Insert or update draft in the database
    if ($draft) {
        // Update existing draft
        $query = "UPDATE berc1_draft SET
            research_title = '$_SESSION[research_title]', researcher_name = '$_SESSION[researcher_name]', part_a_supervisor_name = '$_SESSION[part_a_supervisor_name]',
            department_address = '$_SESSION[department_address]', contact_info = '$_SESSION[contact_info]', researcher_level = '$_SESSION[researcher_level]',
            ethics_approval = '$_SESSION[ethics_approval]', research_funding = '$_SESSION[research_funding]', research_methods = '" . implode(",", $_SESSION['research_methods']) . "',
            background = '$_SESSION[background]', problem_statement = '$_SESSION[problem_statement]', rujukan = '$_SESSION[rujukan]',
            research_objectives = '$_SESSION[research_objectives]', expected_benefits = '$_SESSION[expected_benefits]', research_dates = '$_SESSION[research_dates]',
            data_collection_date = '$_SESSION[data_collection_date]', research_location = '$_SESSION[research_location]', research_design = '$_SESSION[research_design]',
            inclusion_criteria = '$_SESSION[inclusion_criteria]', exclusion_criteria = '$_SESSION[exclusion_criteria]', sample_size = '$_SESSION[sample_size]',
            calculation = '$_SESSION[calculation]',calculation_upload = '$_SESSION[calculation_upload]', flowchart = '$_SESSION[flowchart]', statistical_analysis = '$_SESSION[statistical_analysis]',
            grant_source = '$_SESSION[grant_source]', grant_approval_date = '$_SESSION[grant_approval_date]', total_allocation = '$_SESSION[total_allocation]',
            grant_duration = '$_SESSION[grant_duration]', grant_others = '$_SESSION[grant_others]', applicant_name = '$_SESSION[applicant_name]',
            applicant_staff_id = '$_SESSION[applicant_staff_id]', applicant_position = '$_SESSION[applicant_position]', applicant_affiliation = '$_SESSION[applicant_affiliation]',
            applicant_office_phone = '$_SESSION[applicant_office_phone]', applicant_mobile_phone = '$_SESSION[applicant_mobile_phone]',
            applicant_email = '$_SESSION[applicant_email]', applicant_signature = '$_SESSION[applicant_signature]', applicant_date = '$_SESSION[applicant_date]',
            supervisor_name = '$_SESSION[supervisor_name]', supervisor_staff_id = '$_SESSION[supervisor_staff_id]', supervisor_position = '$_SESSION[supervisor_position]',
            supervisor_affiliation = '$_SESSION[supervisor_affiliation]', supervisor_office_phone = '$_SESSION[supervisor_office_phone]',
            supervisor_mobile_phone = '$_SESSION[supervisor_mobile_phone]', supervisor_email = '$_SESSION[supervisor_email]',
            supervisor_signature = '$_SESSION[supervisor_signature]', supervisor_date = '$_SESSION[supervisor_date]',
            co_researcher_name = '$_SESSION[co_researcher_name]', co_researcher_staff_id = '$_SESSION[co_researcher_staff_id]', co_researcher_position = '$_SESSION[co_researcher_position]',
            co_researcher_affiliation = '$_SESSION[co_researcher_affiliation]', co_researcher_office_phone = '$_SESSION[co_researcher_office_phone]',
            co_researcher_mobile_phone = '$_SESSION[co_researcher_mobile_phone]', co_researcher_email = '$_SESSION[co_researcher_email]',
            co_researcher_signature = '$_SESSION[co_researcher_signature]', co_researcher_date = '$_SESSION[co_researcher_date]',
            is_children_under_18 = '$_SESSION[is_children_under_18]', is_vulnerable_group = '$_SESSION[is_vulnerable_group]', is_terminal_care = '$_SESSION[is_terminal_care]',
            is_unable_to_give_consent = '$_SESSION[is_unable_to_give_consent]', is_emolument = '$_SESSION[is_emolument]', children_under_18_description = '$_SESSION[children_under_18_description]',
            vulnerable_group_description = '$_SESSION[vulnerable_group_description]', terminal_care_description = '$_SESSION[terminal_care_description]',
            unable_to_give_consent_description = '$_SESSION[unable_to_give_consent_description]', emolument_description = '$_SESSION[emolument_description]',
            data_discomfort = '$_SESSION[data_discomfort]', undeclared_measures = '$_SESSION[undeclared_measures]', data_availability = '$_SESSION[data_availability]',
            data_discomfort_description = '$_SESSION[data_discomfort_description]', undeclared_measures_description = '$_SESSION[undeclared_measures_description]',
            data_availability_description = '$_SESSION[data_availability_description]', collects_biological_samples = '$_SESSION[collects_biological_samples]',
            can_identify_participants = '$_SESSION[can_identify_participants]', is_invasive_method = '$_SESSION[is_invasive_method]',
            involves_vigorous_tests = '$_SESSION[involves_vigorous_tests]', is_non_athlete_or_chronic = '$_SESSION[is_non_athlete_or_chronic]',
            involves_maximal_exercise = '$_SESSION[involves_maximal_exercise]', involves_procedure_or_medication = '$_SESSION[involves_procedure_or_medication]',
            involves_unapproved_indication = '$_SESSION[involves_unapproved_indication]', consent_from_others = '$_SESSION[consent_from_others]',
            risk_if_withdraw = '$_SESSION[risk_if_withdraw]', stores_samples = '$_SESSION[stores_samples]', analyses_sample_other_purpose = '$_SESSION[analyses_sample_other_purpose]',
            consent_for_other_purpose = '$_SESSION[consent_for_other_purpose]', biological_samples_type = '$_SESSION[biological_samples_type]',
            biological_samples_description = '$_SESSION[biological_samples_description]', identify_participants_description = '$_SESSION[identify_participants_description]',
            invasive_method_description = '$_SESSION[invasive_method_description]', vigorous_tests_description = '$_SESSION[vigorous_tests_description]',
            non_athletes_chronic_illness_description = '$_SESSION[non_athletes_chronic_illness_description]', maximal_exercise_description = '$_SESSION[maximal_exercise_description]',
            procedure_medication_description = '$_SESSION[procedure_medication_description]', unapproved_indication_description = '$_SESSION[unapproved_indication_description]',
            consent_other_than_participants_description = '$_SESSION[consent_other_than_participants_description]', risk_withdrawal_description = '$_SESSION[risk_withdrawal_description]',
            store_samples_future_research_description = '$_SESSION[store_samples_future_research_description]', analyse_sample_other_purpose_description = '$_SESSION[analyse_sample_other_purpose_description]',
            consent_for_other_purpose_description = '$_SESSION[consent_for_other_purpose_description]', other_ethical_issues = '$_SESSION[other_ethical_issues]',
            other_ethical_issues_description = '$_SESSION[other_ethical_issues_description]', presented_proposal = '$_SESSION[presented_proposal]',
            completed_berc1 = '$_SESSION[completed_berc1]', completed_berc2_or_3 = '$_SESSION[completed_berc2_or_3]', supervisor_checked = '$_SESSION[supervisor_checked]',
            signed_by_all_researchers = '$_SESSION[signed_by_all_researchers]', endorsed_by_committee = '$_SESSION[endorsed_by_committee]',
            additional_comments = '$_SESSION[additional_comments]', Applicants_Signature_F = '$_SESSION[Applicants_Signature_F]', Applicants_Date_F = '$_SESSION[Applicants_Date_F]',
            Supervisors_Signature = '$_SESSION[Supervisors_Signature]', Supervisors_Date = '$_SESSION[Supervisors_Date]', Risk = '$_SESSION[Risk]',
            Coordinator_Signature_G = '$_SESSION[Coordinator_Signature_G]', Official_stamp_G = '$_SESSION[Official_stamp_G]', Coordinator_Date = '$_SESSION[Coordinator_Date]',
            submission_date = NOW()
            WHERE user_id = '$_SESSION[user_id]';";
    } else {
        // Insert new draft
        $query = "INSERT INTO berc1_draft (
            user_id, research_title, researcher_name, part_a_supervisor_name, department_address, contact_info,
            researcher_level, ethics_approval, research_funding, research_methods, background, problem_statement, rujukan,
            research_objectives, expected_benefits, research_dates, data_collection_date, research_location, research_design,
            inclusion_criteria, exclusion_criteria, sample_size, calculation, calculation_upload, flowchart, statistical_analysis, grant_source, 
            grant_approval_date, total_allocation, grant_duration, grant_others, applicant_name, applicant_staff_id, applicant_position, 
            applicant_affiliation, applicant_office_phone, applicant_mobile_phone, applicant_email, applicant_signature, applicant_date,
            supervisor_name, supervisor_staff_id, supervisor_position, supervisor_affiliation, supervisor_office_phone, supervisor_mobile_phone,
            supervisor_email, supervisor_signature, supervisor_date, co_researcher_name, co_researcher_staff_id, co_researcher_position,
            co_researcher_affiliation, co_researcher_office_phone, co_researcher_mobile_phone, co_researcher_email, co_researcher_signature,
            co_researcher_date, is_children_under_18, is_vulnerable_group, is_terminal_care, is_unable_to_give_consent, is_emolument,
            children_under_18_description, vulnerable_group_description, terminal_care_description, unable_to_give_consent_description, emolument_description,
            data_discomfort, undeclared_measures, data_availability, data_discomfort_description, undeclared_measures_description, data_availability_description,
            collects_biological_samples, can_identify_participants, is_invasive_method, involves_vigorous_tests, is_non_athlete_or_chronic,
            involves_maximal_exercise, involves_procedure_or_medication, involves_unapproved_indication, consent_from_others, risk_if_withdraw,
            stores_samples, analyses_sample_other_purpose, consent_for_other_purpose, biological_samples_type, biological_samples_description,
            identify_participants_description, invasive_method_description, vigorous_tests_description, non_athletes_chronic_illness_description,
            maximal_exercise_description, procedure_medication_description, unapproved_indication_description, consent_other_than_participants_description,
            risk_withdrawal_description, store_samples_future_research_description, analyse_sample_other_purpose_description, consent_for_other_purpose_description,
            other_ethical_issues, other_ethical_issues_description, presented_proposal, completed_berc1, completed_berc2_or_3, 
            supervisor_checked, signed_by_all_researchers, endorsed_by_committee, additional_comments, 
            Applicants_Signature_F, Applicants_Date_F, Supervisors_Signature, Supervisors_Date, 
            Risk, Coordinator_Signature_G, Official_stamp_G, Coordinator_Date 
            ) VALUES (
                '$_SESSION[user_id]', '$_SESSION[research_title]', '$_SESSION[researcher_name]', '$_SESSION[part_a_supervisor_name]', '$_SESSION[department_address]', '$_SESSION[contact_info]',
            '$_SESSION[researcher_level]', '$_SESSION[ethics_approval]', '$_SESSION[research_funding]','" . implode(",", $_SESSION['research_methods']) . "', '$_SESSION[background]', '$_SESSION[problem_statement]', '$_SESSION[rujukan]',
            '$_SESSION[research_objectives]', '$_SESSION[expected_benefits]', '$_SESSION[research_dates]', '$_SESSION[data_collection_date]', '$_SESSION[research_location]', '$_SESSION[research_design]',
            '$_SESSION[inclusion_criteria]', '$_SESSION[exclusion_criteria]', '$_SESSION[sample_size]', '$_SESSION[calculation]', '$_SESSION[calculation_upload]', '$_SESSION[flowchart]', '$_SESSION[statistical_analysis]', '$_SESSION[grant_source]',
            '$_SESSION[grant_approval_date]', '$_SESSION[total_allocation]', '$_SESSION[grant_duration]', '$_SESSION[grant_others]', '$_SESSION[applicant_name]', '$_SESSION[applicant_staff_id]', '$_SESSION[applicant_position]',
            '$_SESSION[applicant_affiliation]', '$_SESSION[applicant_office_phone]', '$_SESSION[applicant_mobile_phone]', '$_SESSION[applicant_email]', '$_SESSION[applicant_signature]', '$_SESSION[applicant_date]',
            '$_SESSION[supervisor_name]', '$_SESSION[supervisor_staff_id]', '$_SESSION[supervisor_position]', '$_SESSION[supervisor_affiliation]', '$_SESSION[supervisor_office_phone]', '$_SESSION[supervisor_mobile_phone]',
            '$_SESSION[supervisor_email]', '$_SESSION[supervisor_signature]', '$_SESSION[supervisor_date]', '$_SESSION[co_researcher_name]', '$_SESSION[co_researcher_staff_id]', '$_SESSION[co_researcher_position]',
            '$_SESSION[co_researcher_affiliation]', '$_SESSION[co_researcher_office_phone]', '$_SESSION[co_researcher_mobile_phone]', '$_SESSION[co_researcher_email]', '$_SESSION[co_researcher_signature]',
            '$_SESSION[co_researcher_date]', '$_SESSION[is_children_under_18]', '$_SESSION[is_vulnerable_group]', '$_SESSION[is_terminal_care]', '$_SESSION[is_unable_to_give_consent]', '$_SESSION[is_emolument]',
            '$_SESSION[children_under_18_description]', '$_SESSION[vulnerable_group_description]', '$_SESSION[terminal_care_description]', '$_SESSION[unable_to_give_consent_description]', '$_SESSION[emolument_description]',
            '$_SESSION[data_discomfort]', '$_SESSION[undeclared_measures]', '$_SESSION[data_availability]', '$_SESSION[data_discomfort_description]', '$_SESSION[undeclared_measures_description]', '$_SESSION[data_availability_description]',
            '$_SESSION[collects_biological_samples]', '$_SESSION[can_identify_participants]', '$_SESSION[is_invasive_method]', '$_SESSION[involves_vigorous_tests]', '$_SESSION[is_non_athlete_or_chronic]',
            '$_SESSION[involves_maximal_exercise]', '$_SESSION[involves_procedure_or_medication]', '$_SESSION[involves_unapproved_indication]', '$_SESSION[consent_from_others]', '$_SESSION[risk_if_withdraw]',
            '$_SESSION[stores_samples]', '$_SESSION[analyses_sample_other_purpose]', '$_SESSION[consent_for_other_purpose]', '$_SESSION[biological_samples_type]', '$_SESSION[biological_samples_description]',
            '$_SESSION[identify_participants_description]', '$_SESSION[invasive_method_description]', '$_SESSION[vigorous_tests_description]', '$_SESSION[non_athletes_chronic_illness_description]',
            '$_SESSION[maximal_exercise_description]', '$_SESSION[procedure_medication_description]', '$_SESSION[unapproved_indication_description]', '$_SESSION[consent_other_than_participants_description]',
            '$_SESSION[risk_withdrawal_description]', '$_SESSION[store_samples_future_research_description]', '$_SESSION[analyse_sample_other_purpose_description]', '$_SESSION[consent_for_other_purpose_description]',
            '$_SESSION[other_ethical_issues]', '$_SESSION[other_ethical_issues_description]', '$_SESSION[presented_proposal]', '$_SESSION[completed_berc1]', '$_SESSION[completed_berc2_or_3]', 
            '$_SESSION[supervisor_checked]', '$_SESSION[signed_by_all_researchers]', '$_SESSION[endorsed_by_committee]', '$_SESSION[additional_comments]', 
            '$_SESSION[Applicants_Signature_F]', '$_SESSION[Applicants_Date_F]', '$_SESSION[Supervisors_Signature]', '$_SESSION[Supervisors_Date]', 
            '$_SESSION[Risk]', '$_SESSION[Coordinator_Signature_G]', '$_SESSION[Official_stamp_G]', '$_SESSION[Coordinator_Date]'
            );";
    }

    // Execute the query and handle the result
    if (mysqli_query($conn, $query)) {
        echo '<div id="successMessage" class="success-message">Draft saved successfully!</div>';
        echo '<script>
                const successMessage = document.getElementById("successMessage");
                successMessage.style.opacity = 1;
                setTimeout(() => {
                    successMessage.style.opacity = 0;
                }, 1000);
              </script>';
    } else {
        echo '<div id="errorMessage" class="error-message">Error: ' . htmlspecialchars(mysqli_error($conn)) . '</div>';
    }

    // If the "Next" button is clicked, redirect to the next page
    if (isset($_POST['next'])) {
        header("Location: Berc2.php");
        exit();
    }
} else {
    // Populate the form with the draft values if no submission
    $_SESSION['research_title'] = $draft['research_title'] ?? '';
    $_SESSION['researcher_name'] = $draft['researcher_name'] ?? '';
    $_SESSION['part_a_supervisor_name'] = $draft['part_a_supervisor_name'] ?? '';
    $_SESSION['department_address'] = $draft['department_address'] ?? '';
    $_SESSION['contact_info'] = $draft['contact_info'] ?? '';
    $_SESSION['researcher_level'] = $draft['researcher_level'] ?? '';
    $_SESSION['ethics_approval'] = $draft['ethics_approval'] ?? '';
    $_SESSION['research_funding'] = $draft['research_funding'] ?? '';
    $_SESSION['research_methods'] = explode(",", $draft['research_methods'] ?? '');  // Convert string to array
    $_SESSION['background'] = $draft['background'] ?? '';
    $_SESSION['problem_statement'] = $draft['problem_statement'] ?? '';
    $_SESSION['rujukan'] = $draft['rujukan'] ?? '';
    $_SESSION['research_objectives'] = $draft['research_objectives'] ?? '';
    $_SESSION['expected_benefits'] = $draft['expected_benefits'] ?? '';
    $_SESSION['research_dates'] = $draft['research_dates'] ?? '';
    $_SESSION['data_collection_date'] = $draft['data_collection_date'] ?? '';
    $_SESSION['research_location'] = $draft['research_location'] ?? '';
    $_SESSION['research_design'] = $draft['research_design'] ?? '';
    $_SESSION['inclusion_criteria'] = $draft['inclusion_criteria'] ?? '';
    $_SESSION['exclusion_criteria'] = $draft['exclusion_criteria'] ?? '';
    $_SESSION['sample_size'] = $draft['sample_size'] ?? '';
    $_SESSION['calculation'] = $draft['calculation'] ?? '';
    $_SESSION['calculation_upload'] = $draft['calculation_upload'] ?? '';
    $_SESSION['flowchart'] = $draft['flowchart'] ?? '';
    $_SESSION['statistical_analysis'] = $draft['statistical_analysis'] ?? '';
    $_SESSION['grant_source'] = $draft['grant_source'] ?? '';
    $_SESSION['grant_approval_date'] = $draft['grant_approval_date'] ?? '';
    $_SESSION['total_allocation'] = $draft['total_allocation'] ?? '';
    $_SESSION['grant_duration'] = $draft['grant_duration'] ?? '';
    $_SESSION['grant_others'] = $draft['grant_others'] ?? '';
    $_SESSION['applicant_name'] = $draft['applicant_name'] ?? '';
    $_SESSION['applicant_staff_id'] = $draft['applicant_staff_id'] ?? '';
    $_SESSION['applicant_position'] = $draft['applicant_position'] ?? '';
    $_SESSION['applicant_affiliation'] = $draft['applicant_affiliation'] ?? '';
    $_SESSION['applicant_office_phone'] = $draft['applicant_office_phone'] ?? '';
    $_SESSION['applicant_mobile_phone'] = $draft['applicant_mobile_phone'] ?? '';
    $_SESSION['applicant_email'] = $draft['applicant_email'] ?? '';
    $_SESSION['applicant_signature'] = $draft['applicant_signature'] ?? '';
    $_SESSION['applicant_date'] = $draft['applicant_date'] ?? '';
    $_SESSION['supervisor_name'] = $draft['supervisor_name'] ?? '';
    $_SESSION['supervisor_staff_id'] = $draft['supervisor_staff_id'] ?? '';
    $_SESSION['supervisor_position'] = $draft['supervisor_position'] ?? '';
    $_SESSION['supervisor_affiliation'] = $draft['supervisor_affiliation'] ?? '';
    $_SESSION['supervisor_office_phone'] = $draft['supervisor_office_phone'] ?? '';
    $_SESSION['supervisor_mobile_phone'] = $draft['supervisor_mobile_phone'] ?? '';
    $_SESSION['supervisor_email'] = $draft['supervisor_email'] ?? '';
    $_SESSION['supervisor_signature'] = $draft['supervisor_signature'] ?? '';
    $_SESSION['supervisor_date'] = $draft['supervisor_date'] ?? '';
    $_SESSION['co_researcher_name'] = $draft['co_researcher_name'] ?? '';
    $_SESSION['co_researcher_staff_id'] = $draft['co_researcher_staff_id'] ?? '';
    $_SESSION['co_researcher_position'] = $draft['co_researcher_position'] ?? '';
    $_SESSION['co_researcher_affiliation'] = $draft['co_researcher_affiliation'] ?? '';
    $_SESSION['co_researcher_office_phone'] = $draft['co_researcher_office_phone'] ?? '';
    $_SESSION['co_researcher_mobile_phone'] = $draft['co_researcher_mobile_phone'] ?? '';
    $_SESSION['co_researcher_email'] = $draft['co_researcher_email'] ?? '';
    $_SESSION['co_researcher_signature'] = $draft['co_researcher_signature'] ?? '';
    $_SESSION['co_researcher_date'] = $draft['co_researcher_date'] ?? '';
    $_SESSION['is_children_under_18'] = $draft['is_children_under_18'] ?? '';
    $_SESSION['is_vulnerable_group'] = $draft['is_vulnerable_group'] ?? '';
    $_SESSION['is_terminal_care'] = $draft['is_terminal_care'] ?? '';
    $_SESSION['is_unable_to_give_consent'] = $draft['is_unable_to_give_consent'] ?? '';
    $_SESSION['is_emolument'] = $draft['is_emolument'] ?? '';
    $_SESSION['children_under_18_description'] = $draft['children_under_18_description'] ?? '';
    $_SESSION['vulnerable_group_description'] = $draft['vulnerable_group_description'] ?? '';
    $_SESSION['terminal_care_description'] = $draft['terminal_care_description'] ?? '';
    $_SESSION['unable_to_give_consent_description'] = $draft['unable_to_give_consent_description'] ?? '';
    $_SESSION['emolument_description'] = $draft['emolument_description'] ?? '';
    $_SESSION['data_discomfort'] = $draft['data_discomfort'] ?? '';
    $_SESSION['undeclared_measures'] = $draft['undeclared_measures'] ?? '';
    $_SESSION['data_availability'] = $draft['data_availability'] ?? '';
    $_SESSION['data_discomfort_description'] = $draft['data_discomfort_description'] ?? '';
    $_SESSION['undeclared_measures_description'] = $draft['undeclared_measures_description'] ?? '';
    $_SESSION['data_availability_description'] = $draft['data_availability_description'] ?? '';
    $_SESSION['collects_biological_samples'] = $draft['collects_biological_samples'] ?? '';
    $_SESSION['can_identify_participants'] = $draft['can_identify_participants'] ?? '';
    $_SESSION['is_invasive_method'] = $draft['is_invasive_method'] ?? '';
    $_SESSION['involves_vigorous_tests'] = $draft['involves_vigorous_tests'] ?? '';
    $_SESSION['is_non_athlete_or_chronic'] = $draft['is_non_athlete_or_chronic'] ?? '';
    $_SESSION['involves_maximal_exercise'] = $draft['involves_maximal_exercise'] ?? '';
    $_SESSION['involves_procedure_or_medication'] = $draft['involves_procedure_or_medication'] ?? '';
    $_SESSION['involves_unapproved_indication'] = $draft['involves_unapproved_indication'] ?? '';
    $_SESSION['consent_from_others'] = $draft['consent_from_others'] ?? '';
    $_SESSION['risk_if_withdraw'] = $draft['risk_if_withdraw'] ?? '';
    $_SESSION['stores_samples'] = $draft['stores_samples'] ?? '';
    $_SESSION['analyses_sample_other_purpose'] = $draft['analyses_sample_other_purpose'] ?? '';
    $_SESSION['consent_for_other_purpose'] = $draft['consent_for_other_purpose'] ?? '';
    $_SESSION['biological_samples_type'] = $draft['biological_samples_type'] ?? '';
    $_SESSION['biological_samples_description'] = $draft['biological_samples_description'] ?? '';
    $_SESSION['identify_participants_description'] = $draft['identify_participants_description'] ?? '';
    $_SESSION['invasive_method_description'] = $draft['invasive_method_description'] ?? '';
    $_SESSION['vigorous_tests_description'] = $draft['vigorous_tests_description'] ?? '';
    $_SESSION['non_athletes_chronic_illness_description'] = $draft['non_athletes_chronic_illness_description'] ?? '';
    $_SESSION['maximal_exercise_description'] = $draft['maximal_exercise_description'] ?? '';
    $_SESSION['procedure_medication_description'] = $draft['procedure_medication_description'] ?? '';
    $_SESSION['unapproved_indication_description'] = $draft['unapproved_indication_description'] ?? '';
    $_SESSION['consent_other_than_participants_description'] = $draft['consent_other_than_participants_description'] ?? '';
    $_SESSION['risk_withdrawal_description'] = $draft['risk_withdrawal_description'] ?? '';
    $_SESSION['store_samples_future_research_description'] = $draft['store_samples_future_research_description'] ?? '';
    $_SESSION['analyse_sample_other_purpose_description'] = $draft['analyse_sample_other_purpose_description'] ?? '';
    $_SESSION['consent_for_other_purpose_description'] = $draft['consent_for_other_purpose_description'] ?? '';
    $_SESSION['other_ethical_issues'] = $draft['other_ethical_issues'] ?? '';
    $_SESSION['other_ethical_issues_description'] = $draft['other_ethical_issues_description'] ?? '';
    $_SESSION['presented_proposal'] = $draft['presented_proposal'] ?? '';
    $_SESSION['completed_berc1'] = $draft['completed_berc1'] ?? '';
    $_SESSION['completed_berc2_or_3'] = $draft['completed_berc2_or_3'] ?? '';
    $_SESSION['supervisor_checked'] = $draft['supervisor_checked'] ?? '';
    $_SESSION['signed_by_all_researchers'] = $draft['signed_by_all_researchers'] ?? '';
    $_SESSION['endorsed_by_committee'] = $draft['endorsed_by_committee'] ?? '';
    $_SESSION['additional_comments'] = $draft['additional_comments'] ?? '';
    $_SESSION['Applicants_Signature_F'] = $draft['Applicants_Signature_F'] ?? '';
    $_SESSION['Applicants_Date_F'] = $draft['Applicants_Date_F'] ?? '';
    $_SESSION['Supervisors_Signature'] = $draft['Supervisors_Signature'] ?? '';
    $_SESSION['Supervisors_Date'] = $draft['Supervisors_Date'] ?? '';
    $_SESSION['Risk'] = $draft['Risk'] ?? '';
    $_SESSION['Coordinator_Signature_G'] = $draft['Coordinator_Signature_G'] ?? '';
    $_SESSION['Official_stamp_G'] = $draft['Official_stamp_G'] ?? '';
    $_SESSION['Coordinator_Date'] = $draft['Coordinator_Date'] ?? ''; 
    $_SESSION['submission_date'] = $draft['submission_date'] ?? '';   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethics Approval Application Form</title>
    <style>
        /* Success Message Styling */
        .success-message {
            position: fixed;
            top: 2.9%;
            right: 84.3%;
            padding: 15px 20px;
            background-color: #28a745; /* Green background for success */
            color: #fff;
            font-size: 16px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            z-index: 1000;
        }

        /* Error Message Styling */
        .error-message {
            position: fixed;
            top: 2.9%;
            right: 84.3%;
            padding: 15px 20px;
            background-color: #dc3545; /* Red background for error */
            color: #fff;
            font-size: 16px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 1;
            z-index: 1000;
        }
    
    /* Base Styling */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
        color: #343a40;
    }

    /* Container Styling */
    .container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 40px;
        padding-top: 20px;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Default styling for larger screens */
    nav {
        background-color: whitesmoke;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 10px;
        top: 0;
        z-index: 1000;
        outline: 1px solid #6c757d;
    }

    nav ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    nav ul li {
        margin: 0 20px; /* Adjust margin for spacing */
        position: relative; /* For the underline effect */
    }

    nav ul li a {
        color: #444; /* Link text color */
        text-decoration: none;
        padding: 10px 0; /* Adjust padding for spacing */
        transition: color 0.3s ease; /* Smooth color transition */
    }

    nav ul li a:hover {
        color: #0056b3; /* Change text color on hover */
    }

    /* Underline effect */
    nav ul li a::after {
        content: ''; /* Creates an empty element for the underline */
        display: block; /* Allows the element to take up space */
        height: 2px; /* Thickness of the underline */
        background-color: #0056b3; /* Color of the underline */
        transform: scaleX(0); /* Start with no underline */
        transition: transform 0.3s ease; /* Smooth transition for the scaling */
        width: 100%; /* Full width of the link */
        margin: 0 auto; /* Center the underline */
    }

    nav ul li a:hover::after,
    nav ul li a.active::after {
        transform: scaleX(1); /* Scale up the underline on hover or active */
    }

    /* Section Styling */
    .section {
        margin-bottom: 30px;
    }

    .section h3 {
        font-size: 18px;
        margin-bottom: 15px;
        color: #0056b3;
        border-bottom: 2px solid #007bff;
        padding-bottom: 8px;
    }

    /* Header Styling */
    .header {
        text-align: center;
        margin-bottom: 40px;
    }

    .header img {
        width: 120px;
        height: auto;
    }

    .header h3 {
        font-size: 28px;
        font-weight: bold;
        color: #004085;
    }

    .header h5, .header h6 {
        color: #6c757d;
    }

    .header h4 {
        font-size: 24px;
        margin-top: 20px;
        margin-bottom: 10px;
        font-weight: bold;
        color: #495057;
    }

    .header p {
        font-style: italic;
        color: #6c757d;
    }

    /* Label Styling */
    label {
        display: block;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: normal;
        color: #333;
    }

    /* Input and Textarea Styling */
    input[type="text"],
    textarea {
        width: 100%;
        padding: 12px 10px;
        margin-top: 5px;
        border: 2px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color 0.3s ease-in-out;
    }

    input[type="text"]:focus,
    textarea:focus {
        border-color: #007bff;
        outline: none;
    }

    textarea {
        resize: vertical;
    }

    /* Date Styling */
    input[type="date"] {
        padding: 7px;
        font-size: 14px;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 8px;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }

    input[type="date"]:hover {
        background-color: #0056b3;
    }

    input[type="date"]:focus {
        outline: none;
        background-color: #28a745;
    }

    /* Radio Button Styling */
    .radio-group {
        display: flex;
        align-items: center;
    }

    .radio-group label {
        margin-left: 5px;
        margin-right: 20px;
        font-weight: normal;
    }

    .radio-group input[type="radio"] {
        margin-right: 10px;
    }

    /* Checkbox Styling */
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
        margin-right: 15px;
        align-items: center;
    }

    .checkbox-group label {
        margin-right: 15px;
    }

    .checkbox-group input[type="checkbox"] {
        margin-right: 10px;
    }

    .button-container {
            display: flex; /* Use flexbox to align buttons side by side */
            gap: 10px; /* Space between buttons */
        }

        .submit-button {
            background-color: #0056b3; /* Set the background color */
            color: white; /* Text color */
            border: none; /* Remove border */
            padding: 10px 20px; /* Padding for spacing */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Change cursor on hover */
            font-size: 16px; /* Font size */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .submit-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .next-button {
            background-color: #28a745; /* Green background color for the next button */
            color: white; /* Text color */
            border: none; /* Remove border */
            padding: 10px 20px; /* Padding for spacing */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Change cursor on hover */
            font-size: 16px; /* Font size */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .next-button:hover {
            background-color: #218838; /* Darker shade on hover */
        }


    /* Form Enhancements */
    form {
        padding: 20px 0;
    }

    /* Responsive for smaller screens */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        nav ul li a {
        font-size: 11px; 
        padding: 10px 0; 
        }

        nav ul li {
        margin: 0 14px; 
        position: relative; 
        }

        .header h3 {
            font-size: 20px;
        }

        .header h4 {
            font-size: 16px;
        }

        .section th {
            font-size: 10px;
        }

        .section h3 {
            font-size: 16px;
        }

        .section i {
            font-size: 9px;
        }

        .section td {
            font-size: 11px;
        }

        .section b {
            font-size: 12px;
        }

        label, input[type="text"], textarea {
            font-size: 10px;
            padding: 8px;
        }

        input[type="submit"] {
            font-size: 12px;
            padding: 10px 20px;
        }
    }

    @media (max-width: 425px) {
        .container {
            padding: 10px;
        }

        nav ul li a {
            font-size: 9px; 
            padding: 10px 0; 
        }

        nav ul li {
            margin: 0 10px; 
            position: relative; 
        }

        .header h3 {
            font-size: 18px;
        }

        .header h4 {
            font-size: 14px;
        }

        .section h3 {
            font-size: 16px;
        }

        .section i {
            font-size: 8px;
        }

        .section td {
            font-size: 10px;
        }

        .section b {
            font-size: 12px;
        }

        label, input[type="text"], textarea {
            font-size: 10px;
            padding: 8px;
        }

        input[type="submit"] {
            font-size: 10px;
            padding: 8px 16px;
        }
    }
</style>

</head>
<body>
        <nav>
            <ul>
                <li><a href="../ReseacherPage.php" style="font-weight: bold;">HOME</a></li>
                <li><a class="active">BERC1</a></li>
                <li><a href="Berc2.php">BERC2</a></li>
                <li><a href="Berc3.php">BERC3</a></li>
                <li><a href="Berc5.php">BERC5</a></li>
            </ul>
        </nav>
    <div class="container">
        <div class="header">
            <img src="image/Uitm.png" alt="University Logo">
            <h3>Universiti Teknologi MARA</h3>
            <h5>13500 Permatang Pauh</h5>
            <h6>Tel: 04-382 2888 | Faks: 04-382 2776</h6>
            <h4>Ethics Approval Application Form for Undergraduates or Postgraduates by Coursework</h4>
            <p>Borang Permohonan Kelulusan Etika bagi Pelajar Sarjana Muda atau Pasca Siswazah Kerja Kursus</p>
        </div>

        
        <p>This application is for the purpose of obtaining approval to conduct research. Please attach a copy of Research Proposal.</p>
        <p>Permohonan ini dikemukakan untuk tujuan kelulusan menjalankan penyelidikan. Sila lampirkan salinan kertas cadangan penyelidikan.</p>
        
    <form id="myForm" method="post" enctype="multipart/form-data">
        <!-- Part A: Details of Researcher -->
        <div class="section">
        <h3>Part A: Details of Researcher<br><i>Bahagian A: Maklumat Penyelidik</i></h3>

        <!-- Research Title -->
        <label for="research_title"><b>Title of Research Project:</b><br><i>Tajuk Penyelidikan:</i></label>
        <input type="text" id="research_title" name="research_title" style="width: 90%" 
            value="<?php echo htmlspecialchars($_SESSION['research_title'] ?? ''); ?>" required>
        <br><br>

        <!-- Researcher Name -->
        <label for="researcher_name"><b>Name of Researcher:</b><br><i>Nama Penyelidik:</i></label>
        <input type="text" id="researcher_name" name="researcher_name" style="width: 70%" 
            value="<?php echo htmlspecialchars($_SESSION['researcher_name'] ?? ''); ?>" required>
        <br><br>

        <!-- Supervisor Name -->
        <label for="part_a_supervisor_name"><b>Name of Supervisor:</b><br><i>Nama Penyelia:</i></label>
        <input type="text" id="part_a_supervisor_name" name="part_a_supervisor_name" style="width: 70%" 
            value="<?php echo htmlspecialchars($_SESSION['part_a_supervisor_name'] ?? ''); ?>" required>
        <br><br>

        <!-- Department Address -->
        <label for="department_address"><b>Address of Department/Institute:</b><br><i>Alamat Jabatan/Institut:</i></label>
        <textarea id="department_address" name="department_address" style="width: 80%" rows="4" required><?php echo htmlspecialchars($_SESSION['department_address'] ?? ''); ?></textarea>
        <br><br>

        <!-- Contact Info -->
        <label for="contact_info"><b>Contact No/Email:</b><br><i>No. Telefon/Emel:</i></label>
        <input type="text" id="contact_info" name="contact_info" style="width: 50%" 
            value="<?php echo htmlspecialchars($_SESSION['contact_info'] ?? ''); ?>" required>
        <br><br>

        <!-- Researcher Level -->
        <label><b>Level of Study:</b><br><i>Tahap Pengajian:</i></label>
        <div class="radio-group">
            <label for="undergraduate">
                <input type="radio" id="undergraduate" name="researcher_level" value="undergraduate" 
                    <?php if ($_SESSION['researcher_level'] ?? '' == 'undergraduate') echo 'checked'; ?> required>Undergraduate / Sarjana Muda
            </label>
            <label for="postgraduate">
                <input type="radio" id="postgraduate" name="researcher_level" value="postgraduate" 
                    <?php if ($_SESSION['researcher_level'] ?? '' == 'postgraduate') echo 'checked'; ?>>Postgraduate by Coursework / Pasca Siswazah Kerja Kursus
            </label>
        </div>
        <hr><br>

        <!-- External Research Ethics Committee -->
        <label><b>Does the research require an external Research Ethics Committee approval? (e.g. MREC)</b>
        <br><i>Adakah penyelidikan ini memerlukan kelulusan Jawatankuasa Etika Penyelidikan Luaran? (contoh MREC)</i></label>
        <div class="radio-group">
            <label for="yes">
                <input type="radio" id="yes" name="ethics_approval" value="yes" 
                    <?php if ($_SESSION['ethics_approval'] ?? '' == 'yes') echo 'checked'; ?> required>Yes
            </label>
            <label for="no">
                <input type="radio" id="no" name="ethics_approval" value="no" 
                    <?php if ($_SESSION['ethics_approval'] ?? '' == 'no') echo 'checked'; ?>>No
            </label>
        </div>
        <hr><br>

        <!-- Research Funding -->
        <label><b>Research Funding:</b><br><i>Dana Penyelidikan:</i></label>
        <div class="radio-group">
            <label for="funding-yes">
                <input type="radio" id="funding-yes" name="research_funding" value="yes" 
                    <?php if ($_SESSION['research_funding'] ?? '' == 'yes') echo 'checked'; ?> required>Yes
            </label>
            <label for="funding-no">
                <input type="radio" id="funding-no" name="research_funding" value="no" 
                    <?php if ($_SESSION['research_funding'] ?? '' == 'no') echo 'checked'; ?>>No
            </label>
        </div>
        <hr><br>
        <i>If obtained, please complete section C</i><br>
        <i>Jika ada, sila lengkapkan bahagian C.</i>
<!-- Part B: Research Details -->
<div class="section">
    <h3>Part B: Research Details<br><i>Bahagian B: Maklumat Penyelidikan</i></h3>

    <h2>Part B1<br><i>Bahagian B1</i></h2>
    <form action="process_form.php" method="POST">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 8px; background-color: #007bff; color: white;">List</th>
                    <th style="text-align: left; padding: 8px; background-color: #007bff; color: white;">Select</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ensure research_methods is an array
                $research_methods = isset($_SESSION['research_methods']) ? (array)$_SESSION['research_methods'] : [];
                ?>
                <tr>
                    <td style="padding: 8px;"><b>Interviews</b><br><i>Temubual</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="Interviews" 
                               <?php echo in_array('Interviews', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Focus Groups</b><br><i>Kumpulan Fokus</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="FocusGroups" 
                               <?php echo in_array('FocusGroups', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Questionnaires</b><br><i>Soal Selidik</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="Questionnaires" 
                               <?php echo in_array('Questionnaires', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Action Research</b><br><i>Kajian Tindakan</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="ActionResearch" 
                               <?php echo in_array('ActionResearch', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Observation</b><br><i>Pemerhatian</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="Observation" 
                               <?php echo in_array('Observation', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Case Study</b><br><i>Kajian Kes</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="CaseStudy" 
                               <?php echo in_array('CaseStudy', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Intervention Study</b><br><i>Kajian Intervensi</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="InterventionStudy" 
                               <?php echo in_array('InterventionStudy', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Personal Records</b><br><i>Rekod Peribadi</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="PersonalRecords" 
                               <?php echo in_array('PersonalRecords', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Secondary Data Analysis</b><br><i>Analisis Data Sekunder</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="SecondaryDataAnalysis" 
                               <?php echo in_array('SecondaryDataAnalysis', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px;"><b>Others (provide details)</b><br><i>Lain-lain (nyatakan):</i></td>
                    <td style="padding: 8px;">
                        <input type="checkbox" name="research_methods[]" value="Others" 
                               <?php echo in_array('Others', $research_methods) ? 'checked' : ''; ?>>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <!-- Research Details -->
    <br><br>
            <h2>Part B2<br><i>Bahagian B2</i></h2>

            <!-- Background and Problem Statement -->
            <label for="background" style="font: normal;"><b>Background:</b><br><i>Latar Belakang:</i></label>
            <textarea id="background" name="background" rows="6" placeholder="A brief explanation of the problem to be studied..."><?php echo htmlspecialchars($_SESSION['background'] ?? $background); ?></textarea>
            <br><br>

            <label for="problem_statement"><b>Problem Statement:</b><br> <i>Penyataan Masalah:</i></label>
            <textarea id="problem_statement" name="problem_statement" rows="4"><?php echo htmlspecialchars($_SESSION['problem_statement'] ?? $problem_statement); ?></textarea>
            <br><br>

            <label for="references"><b>References:</b><br><i>Rujukan:</i></label>
            <textarea id="rujukan" name="rujukan" rows="4"><?php echo htmlspecialchars($_SESSION['rujukan'] ?? $rujukan); ?></textarea>
            <br><br>

            <!-- Research Objectives -->
            <label for="research_objectives"><b>Research Objectives:</b><br> <i>Objektif Penyelidikan:</i></label>
            <textarea id="research_objectives" name="research_objectives" rows="4"><?php echo htmlspecialchars($_SESSION['research_objectives'] ?? $research_objectives); ?></textarea>
            <br><br>

            <!-- Expected Benefits -->
            <label for="expected_benefits"><b>Expected Benefits:</b><br> <i>Faedah yang Dijangka:</i></label>
            <textarea id="expected_benefits" name="expected_benefits" rows="4"><?php echo htmlspecialchars($_SESSION['expected_benefits'] ?? $expected_benefits); ?></textarea>
            <br><br>

            <!-- Research Dates -->
            <label for="research_dates"><b>Date of Research Commencement-End:</b><br><i>Tarikh Penyelidikan Bermula-Berakhir:</i></label>
            <input type="date" id="research_dates" name="research_dates" value="<?php echo htmlspecialchars($_SESSION['research_dates'] ?? $research_dates); ?>">
            <br><br>

            <label for="data_collection-date"><b>Expected Date of Initial Data Collection:</b><br><i>Jangkaan Tarikh Pengumpulan Data Bermula:</i></label>
            <input type="date" id="data_collection_date" name="data_collection_date" value="<?php echo htmlspecialchars($_SESSION['data_collection_date'] ?? $data_collection_date); ?>">
            <br><br>

            <!-- Location of Research -->
            <label for="research_location"><b>Location of Research:</b><br><i>Lokasi Penyelidikan Dijalankan:</i></label>
            <input type="text" id="research_location" name="research_location" value="<?php echo htmlspecialchars($_SESSION['research_location'] ?? $research_location); ?>">
            <br><br>

            <!-- Research Design and Methodology -->
            <label for="research_design"><b>Research Design and Methodology:</b><br><i>Rekabentuk Penyelidikan dan Metodologi:</i></label>
            <textarea id="research_design" name="research_design" rows="4"><?php echo htmlspecialchars($_SESSION['research_design'] ?? $research_design); ?></textarea>
            <br><br>

            <!-- Inclusion and Exclusion Criteria -->
            <label for="inclusion_criteria"><b>Inclusion Criteria:</b><br><i>Kriteria Kemasukan:</i></label>
            <textarea id="inclusion_criteria" name="inclusion_criteria" rows="3"><?php echo htmlspecialchars($_SESSION['inclusion_criteria'] ?? $inclusion_criteria); ?></textarea>
            <br><br>

            <label for="exclusion_criteria"><b>Exclusion Criteria:</b><br> <i>Kriteria Pengecualian:</i></label>
            <textarea id="exclusion_criteria" name="exclusion_criteria" rows="3"><?php echo htmlspecialchars($_SESSION['exclusion_criteria'] ?? $exclusion_criteria); ?></textarea>
            <br><br>

            <!-- Sample Size -->
            <label for="sample_size"><b>Sample Size:</b><br><i>Saiz Sampel:</i></label>
            <input type="text" id="sample_size" name="sample_size" value="<?php echo htmlspecialchars($_SESSION['sample_size'] ?? $sample_size); ?>">
            <br><br>

            <!-- Calculation Section -->
            <label for="calculation"><b>Calculation:</b><br><i>Pengiraan:</i></label>
            <textarea id="calculation" name="calculation" rows="3"><?php echo htmlspecialchars($_SESSION['calculation'] ?? $calculation); ?></textarea>
            <br><br>

            <label for="calculation_upload"><b>Upload Calculation File:</b><br><i>Muat naik fail pengiraan:</i></label>
            <?php if (!empty($_SESSION['calculation_upload'])): ?>
                <p>Existing File: <a href="<?php echo htmlspecialchars($_SESSION['calculation_upload']); ?>" target="_blank">View Uploaded File</a></p>
            <?php endif; ?>
            <input type="file" id="calculation_upload" name="calculation_upload">
            <br><br>

            <!-- Research Flowchart Section -->
            <label for="flowchart_file"><b>Upload Flowchart File:</b><br><i>Muat naik fail carta alir:</i></label>
            <input type="file" id="flowchart_file" name="flowchart_file">
            <br><br>

            <!-- Statistical Analysis -->
            <label for="statistical_analysis"><b>Statistical Analysis:</b><br> <i>Analisa Statistik:</i></label>
            <textarea id="statistical_analysis" name="statistical_analysis" rows="4"><?php echo htmlspecialchars($_SESSION['statistical_analysis'] ?? $statistical_analysis); ?></textarea>
            <br>

            <!-- Reminder about 'NA' -->
            <i>* If not applicable, please write ‘-NA-’ in the spaces provided. / Jika tiada kaitan sila tulis ‘-NA-’ di ruangan disediakan.</i>
            <br><br>

            <!-- Part C: Fundings Details -->
            <div class="section">
                <h3>Part C: Fundings Details<br><i>Bahagian C: Maklumat Dana</i></h3>

                <!-- Fundings Table -->
                <table border="1" cellspacing="0" cellpadding="10" style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 1%;"> 1.</td>
                        <td><strong>Grant / Source:</strong><br><i>Geran / Sumber:</i></td>
                        <td><input type="text" id="grant_source" name="grant_source" style="width: 100%;" 
                                value="<?php echo htmlspecialchars($_SESSION['grant_source'] ?? $grant_source); ?>"></td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td><strong>Date of Grant Approval:</strong><br><i>Tarikh Kelulusan Geran:</i></td>
                        <td><input type="date" id="grant_approval_date" name="grant_approval_date" style="width: 60%;" 
                                value="<?php echo htmlspecialchars($_SESSION['grant_approval_date'] ?? $grant_approval_date); ?>"></td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td><strong>Total Allocation:</strong><br><i>Jumlah Peruntukan:</i></td>
                        <td><input type="text" id="total_allocation" name="total_allocation" style="width: 100%;" 
                                value="<?php echo htmlspecialchars($_SESSION['total_allocation'] ?? $total_allocation); ?>"></td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td><strong>Duration of Grant:</strong><br><i>Jangkamasa Peruntukan:</i></td>
                        <td><input type="text" id="grant_duration" name="grant_duration" style="width: 100%;" 
                                value="<?php echo htmlspecialchars($_SESSION['grant_duration'] ?? $grant_duration); ?>"></td>
                    </tr>
                    <tr>
                        <td>5.</td>
                        <td><strong>Others:</strong><br><i>Lain-lain:</i></td>
                        <td><textarea id="grant_others" name="grant_others" rows="3" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['grant_others'] ?? $grant_others); ?></textarea></td>
                    </tr>
                </table>
            </div>
            <br>

        <!-- Part D: Agreement to conduct the research project -->
        <div class="section">
            <h3>Part D: Agreement to Conduct The Research Project<br><i>Bahagian D: Pengesahan Persetujuan Menjalankan Penyelidikan</i></h3>
            <p>Must be completed and signed by all members of the research group.<br>Mesti dilengkapkan dan ditandatangani oleh semua ahli kumpulan penyelidikan.</p>

            <!-- Table for Applicant -->
            <h4>1. Applicant (to be filled by Undergraduate/Post Graduate by Coursework Student only)<br><i>Pemohon (untuk dilengkapkan oleh Pelajar Siswazah / Pasca-siswazah Kerja Kursus sahaja)</i></h4>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #000;">
                <!-- Name -->
                <tr>
                    <td style="padding: 10px; width: 30%; border: 1px solid #000;"><b>Name:</b><br><i>Nama:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="applicant_name" id="applicant_name" rows="4" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['applicant_name'] ?? $applicant_name); ?></textarea>
                    </td>
                </tr>
                <!-- Staff ID/Student ID -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Staff ID/Student ID:</b><br><i>No. Staf/No. Pelajar:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="applicant_staff_id" id="applicant_staff_id" rows="4" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['applicant_staff_id'] ?? $applicant_staff_id); ?></textarea>
                    </td>
                </tr>
                <!-- Position/Specialisation -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Position/Specialisation:</b><br><i>Jawatan/Kepakaran:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="applicant_position" id="applicant_position" rows="4" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['applicant_position'] ?? $applicant_position); ?></textarea>
                    </td>
                </tr>
                <!-- Affiliation -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Affiliation:</b><br><i>Jabatan:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="applicant_affiliation" id="applicant_affiliation" rows="4" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['applicant_affiliation'] ?? $applicant_affiliation); ?></textarea>
                    </td>
                </tr>
                <!-- Office -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><strong>Office:</strong><br><i>Telefon Pejabat:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="applicant_office_phone" id="applicant_office_phone" rows="4" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['applicant_office_phone'] ?? $applicant_office_phone); ?></textarea>
                    </td>
                </tr>
                <!-- Mobile phone -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Mobile phone:</b><br><i>Telefon Bimbit:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="applicant_mobile_phone" id="applicant_mobile_phone" rows="4" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['applicant_mobile_phone'] ?? $applicant_mobile_phone); ?></textarea>
                    </td>
                </tr>
                <!-- Email -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Email:</b><br><i>Emel:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="email" name="applicant_email" id="applicant_email" style="width: 70%;" value="<?php echo htmlspecialchars($_SESSION['applicant_email'] ?? $applicant_email); ?>">
                    </td>
                </tr>
                <!-- Signature -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Signature:</b><br><i>Tandatangan:</i></td>
                    <td><br>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" id="applicant_signature" name="applicant_signature" required 
                                <?php if (!empty($_SESSION['applicant_signature'] ?? $applicant_signature)) echo 'checked'; ?>>
                                I have read and understood the terms and conditions of my participation.<br>
                                <i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i>
                            </label>
                        </div>
                    </td>
                </tr>
                <!-- Date -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Date:</b><br><i>Tarikh:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="date" name="applicant_date" id="applicant_date" style="width: 50%;" 
                            value="<?php echo htmlspecialchars($_SESSION['applicant_date'] ?? $applicant_date); ?>">
                    </td>
                </tr>
            </table>
            <br>

        <!-- Table for Supervisor -->
        <h4>2. Supervisor<br><i>Penyelia</i></h4>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #000;">
            <!-- Name -->
            <tr>
                <td style="padding: 10px; width: 30%; border: 1px solid #000;"><b>Name:</b><br><i>Nama:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="supervisor_name" id="supervisor_name" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['supervisor_name'] ?? $supervisor_name); ?>">
                </td>
            </tr>
            <!-- Staff ID/Student ID -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Staff ID/Student ID:</b><br><i>No. Staf/No. Pelajar:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="supervisor_staff_id" id="supervisor_staff_id" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['supervisor_staff_id'] ?? $supervisor_staff_id); ?>">
                </td>
            </tr>
            <!-- Position/Specialisation -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Position/Specialisation:</b><br><i>Jawatan/Kepakaran:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="supervisor_position" id="supervisor_position" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['supervisor_position'] ?? $supervisor_position); ?>">
                </td>
            </tr>
            <!-- Affiliation -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Affiliation:</b><br><i>Jabatan:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="supervisor_affiliation" id="supervisor_affiliation" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['supervisor_affiliation'] ?? $supervisor_affiliation); ?>">
                </td>
            </tr>
            <!-- Office -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Office:</b><br><i>Telefon pejabat:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="supervisor_office_phone" id="supervisor_office_phone" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['supervisor_office_phone'] ?? $supervisor_office_phone); ?>">
                </td>
            </tr>
            <!-- Mobile phone -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Mobile phone:</b><br><i>Telefon bimbit:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="supervisor_mobile_phone" id="supervisor_mobile_phone" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['supervisor_mobile_phone'] ?? $supervisor_mobile_phone); ?>">
                </td>
            </tr>
            <!-- Email -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Email:</b><br><i>Emel:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="email" name="supervisor_email" id="supervisor_email" style="width: 70%;" 
                        value="<?php echo htmlspecialchars($_SESSION['supervisor_email'] ?? $supervisor_email); ?>">
                </td>
            </tr>
            <!-- Signature -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Signature:</b><br><i>Tandatangan:</i></td>
                <td><br>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" id="supervisor_signature" name="supervisor_signature" required 
                            <?php if (!empty($_SESSION['supervisor_signature'] ?? $supervisor_signature)) echo 'checked'; ?>>
                            I have read and understood the terms and conditions of my participation.<br>
                            <i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i>
                        </label>
                    </div>
                </td>
            </tr>
            <!-- Date -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Date:</b><br><i>Tarikh:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="date" name="supervisor_date" id="supervisor_date" style="width: 50%;" 
                        value="<?php echo htmlspecialchars($_SESSION['supervisor_date'] ?? $supervisor_date); ?>">
                </td>
            </tr>
        </table>
        <br>

        <!-- Table for Co-Researcher -->
        <h4>3. Co-Researcher<br><i>Penyelidik Bersama</i></h4>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #000;">
            <!-- Name -->
            <tr>
                <td style="padding: 10px; width: 30%; border: 1px solid #000;"><b>Name:</b><br><i>Nama:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="co_researcher_name" id="co_researcher_name" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['co_researcher_name'] ?? $co_researcher_name); ?>">
                </td>
            </tr>
            <!-- Staff ID/Student ID -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Staff ID/Student ID:</b><br><i>No. Staf/No. Pelajar:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="co_researcher_staff_id" id="co_researcher_staff_id" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['co_researcher_staff_id'] ?? $co_researcher_staff_id); ?>">
                </td>
            </tr>
            <!-- Position/Specialisation -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Position/Specialisation:</b><br><i>Jawatan/Kepakaran:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="co_researcher_position" id="co_researcher_position" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['co_researcher_position'] ?? $co_researcher_position); ?>">
                </td>
            </tr>
            <!-- Affiliation -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Affiliation:</b><br><i>Jabatan:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="co_researcher_affiliation" id="co_researcher_affiliation" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['co_researcher_affiliation'] ?? $co_researcher_affiliation); ?>">
                </td>
            </tr>
            <!-- Office -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Office:</b><br><i>Telefon pejabat:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="co_researcher_office_phone" id="co_researcher_office_phone" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['co_researcher_office_phone'] ?? $co_researcher_office_phone); ?>">
                </td>
            </tr>
            <!-- Mobile phone -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Mobile phone:</b><br><i>Telefon bimbit:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="text" name="co_researcher_mobile_phone" id="co_researcher_mobile_phone" style="width: 100%;" 
                        value="<?php echo htmlspecialchars($_SESSION['co_researcher_mobile_phone'] ?? $co_researcher_mobile_phone); ?>">
                </td>
            </tr>
            <!-- Email -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Email:</b><br><i>Emel:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="email" name="co_researcher_email" id="co_researcher_email" style="width: 70%;" 
                        value="<?php echo htmlspecialchars($_SESSION['co_researcher_email'] ?? $co_researcher_email); ?>">
                </td>
            </tr>
            <!-- Signature -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Signature:</b><br><i>Tandatangan:</i></td>
                <td><br>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" id="co_researcher_signature" name="co_researcher_signature" required 
                            <?php if (!empty($_SESSION['co_researcher_signature'] ?? $co_researcher_signature)) echo 'checked'; ?>>
                            I have read and understood the terms and conditions of my participation.<br>
                            <i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i>
                        </label>
                    </div>
                </td>
            </tr>
            <!-- Date -->
            <tr>
                <td style="padding: 10px; border: 1px solid #000;"><b>Date:</b><br><i>Tarikh:</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="date" name="co_researcher_date" id="co_researcher_date" style="width: 50%;" 
                        value="<?php echo htmlspecialchars($_SESSION['co_researcher_date'] ?? $co_researcher_date); ?>">
                </td>
            </tr>
        </table>
        <i>(Add if necessary)</i>
        <br>

             <!-- Part E:  Research Risk Classification. -->
            <div class="section">
                <h3>Part E:  Research Risk Classification<br><i>Bahagian E: Klasifikasi Risiko Kajian</i></h3>

                <!-- Participant Profile Table -->
                <h4>PLEASE ANSWER ALL QUESTIONS BELOW.</h4>
                <p>If your answer is <b>‘Yes’</b> to any of the following questions, please include a brief information in the space provided.</p>

                <h4><i>SILA JAWAB KESEMUA SOALAN DI BAWAH.</i></h4>
                <p><i>Sekiranya jawapan anda <b>‘Ya’</b> kepada mana-mana soalan di bawah, sertakan maklumat ringkas di ruang yang disediakan. </i></p>

                <br>
                <h4></hr>PARTICIPANT PROFILE<hr></h4>
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                    <thead>
                        <tr>
                            <th style="padding: 10px; width: 3%; border: 0px solid #000;"></th>
                            <th style="padding: 10px; border: 0px solid #000;">PARTICIPANT PROFILE</th>
                            <th style="padding: 10px; border: 1px solid #000;">Yes</th>
                            <th style="padding: 10px; border: 1px solid #000;">No</th>
                            <th style="padding: 10px; border: 1px solid #000;">Brief Description</th>
                        </tr>
                    </thead>
                    <tbody>
            <!-- Question 1 -->
            <tr>
                <td style="padding: 5px; border: 1px solid #000;">1. </td>
                <td style="padding: 10px; border: 1px solid #000;">Are the participants children (under 18 years old)?
                    <br><i>Adakah peserta kanak-kanak (Umur di bawah 18 tahun)?</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_children_under_18" value="Yes" <?php echo (($_SESSION['is_children_under_18'] ?? $is_children_under_18) == 'Yes') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_children_under_18" value="No" <?php echo (($_SESSION['is_children_under_18'] ?? $is_children_under_18) == 'No') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <textarea name="children_under_18_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['children_under_18_description'] ?? $children_under_18_description); ?></textarea>
                </td>
            </tr>
            <!-- Question 2 -->
            <tr>
                <td style="padding: 5px; border: 1px solid #000;">2. </td>
                <td style="padding: 10px; border: 1px solid #000;">Are the participants from a particular vulnerable group?
                    <br><i>Adakah peserta daripada golongan rentan?</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_vulnerable_group" value="Yes" <?php echo (($_SESSION['is_vulnerable_group'] ?? $is_vulnerable_group) == 'Yes') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_vulnerable_group" value="No" <?php echo (($_SESSION['is_vulnerable_group'] ?? $is_vulnerable_group) == 'No') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <textarea name="vulnerable_group_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['vulnerable_group_description'] ?? $vulnerable_group_description); ?></textarea>
                </td>
            </tr>
            <!-- Question 3 -->
            <tr>
                <td style="padding: 5px; border: 1px solid #000;">3. </td>
                <td style="padding: 10px; border: 1px solid #000;">Are any of these participants/patients in terminal care?
                    <br><i>Adakah peserta/pesakit ini memerlukan rawatan terminal?</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_terminal_care" value="Yes" <?php echo (($_SESSION['is_terminal_care'] ?? $is_terminal_care) == 'Yes') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_terminal_care" value="No" <?php echo (($_SESSION['is_terminal_care'] ?? $is_terminal_care) == 'No') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <textarea name="terminal_care_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['terminal_care_description'] ?? $terminal_care_description); ?></textarea>
                </td>
            </tr>
            <!-- Question 4 -->
            <tr>
                <td style="padding: 5px; border: 1px solid #000;">4. </td>
                <td style="padding: 10px; border: 1px solid #000;">Are any of these participants unable or are incapable of giving consent?
                    <br><i>Adakah peserta tidak boleh atau tidak berupaya memberi izin?</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_unable_to_give_consent" value="Yes" <?php echo (($_SESSION['is_unable_to_give_consent'] ?? $is_unable_to_give_consent) == 'Yes') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_unable_to_give_consent" value="No" <?php echo (($_SESSION['is_unable_to_give_consent'] ?? $is_unable_to_give_consent) == 'No') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <textarea name="unable_to_give_consent_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['unable_to_give_consent_description'] ?? $unable_to_give_consent_description); ?></textarea>
                </td>
            </tr>
            <!-- Question 5 -->
            <tr>
                <td style="padding: 5px; border: 1px solid #000;">5. </td>
                <td style="padding: 10px; border: 1px solid #000;">Are the participants given any form of emolument to participate?
                    <br><i>Adakah peserta diberi sebarang emolumen untuk menyertai kajian?</i></td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_emolument" value="Yes" <?php echo (($_SESSION['is_emolument'] ?? $is_emolument) == 'Yes') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="is_emolument" value="No" <?php echo (($_SESSION['is_emolument'] ?? $is_emolument) == 'No') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <textarea name="emolument_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['emolument_description'] ?? $emolument_description); ?></textarea>
                </td>
            </tr>
                </tbody>
            </table>
            <br>

            <!-- Privacy and Confidentiality Table -->
            <h4></hr>PRIVACY AND CONFIDENTIALITY<hr></h4>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                <thead>
                    <tr>
                        <th style="padding: 5px; width: 3%; border: 0px solid #000;"></th>
                        <th style="padding: 10px; border: 0px solid #000;">PRIVACY AND CONFIDENTIALITY</th>
                        <th style="padding: 10px; border: 1px solid #000;">Yes</th>
                        <th style="padding: 10px; border: 1px solid #000;">No</th>
                        <th style="padding: 10px; border: 1px solid #000;">Brief Description</th>
                    </tr>
                </thead>
                <tbody>
            <!-- Question 6 -->
            <tr>
                <td style="padding: 5px; border: 1px solid #000;">6. </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    Does any of the data collected have the potential to cause discomfort, embarrassment, or psychological harm to the participants?
                    <br><i>Adakah data yang dikumpul berpotensi untuk menyebabkan ketidak selesaan, keaiban atau gangguan psikologi kepada peserta?</i>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="data_discomfort" value="Yes" <?php echo (($_SESSION['data_discomfort'] ?? $data_discomfort) == 'Yes') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="data_discomfort" value="No" <?php echo (($_SESSION['data_discomfort'] ?? $data_discomfort) == 'No') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <textarea name="data_discomfort_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['data_discomfort_description'] ?? $data_discomfort_description); ?></textarea>
                </td>
            </tr>
            <!-- Question 7 -->
            <tr>
                <td style="padding: 5px; border: 1px solid #000;">7. </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    Does your research involve measures undeclared to the participants?
                    <br><i>Adakah penyelidikan anda melibatkan langkah-langkah yang tidak dimaklumkan kepada peserta?</i>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="undeclared_measures" value="Yes" <?php echo (($_SESSION['undeclared_measures'] ?? $undeclared_measures) == 'Yes') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="undeclared_measures" value="No" <?php echo (($_SESSION['undeclared_measures'] ?? $undeclared_measures) == 'No') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <textarea name="undeclared_measures_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['undeclared_measures_description'] ?? $undeclared_measures_description); ?></textarea>
                </td>
            </tr>
            <!-- Question 8 -->
            <tr>
                <td style="padding: 5px; border: 1px solid #000;">8. </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    Will the collected data be made available to other parties not involved in the research?
                    <br><i>Adakah data yang dikumpulkan akan didedahkan kepada pihak lain yang tidak terlibat dalam penyelidikan?</i>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="data_availability" value="Yes" <?php echo (($_SESSION['data_availability'] ?? $data_availability) == 'Yes') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <input type="radio" name="data_availability" value="No" <?php echo (($_SESSION['data_availability'] ?? $data_availability) == 'No') ? 'checked' : ''; ?>>
                </td>
                <td style="padding: 10px; border: 1px solid #000;">
                    <textarea name="data_availability_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['data_availability_description'] ?? $data_availability_description); ?></textarea>
                </td>
            </tr>
                </tbody>
            </table>
            <br>

            <!-- Risk of Harm Table -->
            <h4>RISK OF HARM<hr></h4>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                <thead>
                    <tr>
                        <th style="padding: 10px; width: 3%; border: 0px solid #000;"></th>
                        <th style="padding: 10px; border: 0px solid #000;">RISK OF HARM</th>
                        <th style="padding: 10px; border: 1px solid #000;">Yes</th>
                        <th style="padding: 10px; border: 1px solid #000;">No</th>
                        <th style="padding: 10px; border: 1px solid #000;">Brief Description</th>
                    </tr>
                </thead>
                <tbody>
                <!-- Question 9 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">9. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Will you be collecting biological samples e.g. body fluids?<br><i>Adakah anda akan mengumpul sampel biologi contohnya. cecair badan?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="biological_samples_type" value="Yes" <?php echo (($_SESSION['biological_samples_type'] ?? $biological_samples_type) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="biological_samples_type" value="No" <?php echo (($_SESSION['biological_samples_type'] ?? $biological_samples_type) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="biological_samples_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['biological_samples_description'] ?? $biological_samples_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 10 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">10. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Do you have access to any information that will allow the identification of individual human participants?<br><i>Adakah anda mempunyai akses kepada apa-apa maklumat yang akan membolehkan pengenalpastian peserta secara individu?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="can_identify_participants" value="Yes" <?php echo (($_SESSION['can_identify_participants'] ?? $can_identify_participants) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="can_identify_participants" value="No" <?php echo (($_SESSION['can_identify_participants'] ?? $can_identify_participants) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="identify_participants_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['identify_participants_description'] ?? $identify_participants_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 11 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">11. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Is the collection method invasive and has the potential to cause harm, pain or discomfort?<br><i>Adakah kaedah pengumpulan invasif dan berpotensi menyebabkan kemudaratan, kesakitan atau ketidakselesaan?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="is_invasive_method" value="Yes" <?php echo (($_SESSION['is_invasive_method'] ?? $is_invasive_method) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="is_invasive_method" value="No" <?php echo (($_SESSION['is_invasive_method'] ?? $is_invasive_method) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="invasive_method_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['invasive_method_description'] ?? $invasive_method_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 12 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">12. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Will the participants be subjected to vigorous physical tests or exercise regime?<br><i>Adakah peserta akan melalui ujian fizikal atau senaman berintensiti tinggi?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="involves_vigorous_tests" value="Yes" <?php echo (($_SESSION['involves_vigorous_tests'] ?? $involves_vigorous_tests) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="involves_vigorous_tests" value="No" <?php echo (($_SESSION['involves_vigorous_tests'] ?? $involves_vigorous_tests) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="vigorous_tests_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['vigorous_tests_description'] ?? $vigorous_tests_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 13 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">13. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Are the participants non-athletes or patients with chronic illness?<br><i>Adakah peserta bukan atlet atau pesakit dengan penyakit kronik?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="is_non_athlete_or_chronic" value="Yes" <?php echo (($_SESSION['is_non_athlete_or_chronic'] ?? $is_non_athlete_or_chronic) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="is_non_athlete_or_chronic" value="No" <?php echo (($_SESSION['is_non_athlete_or_chronic'] ?? $is_non_athlete_or_chronic) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="non_athletes_chronic_illness_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['non_athletes_chronic_illness_description'] ?? $non_athletes_chronic_illness_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 14 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">14. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Will they be subjected to maximal exercise intensity?<br><i>Adakah mereka akan melalui senaman berintensiti maksimum?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="involves_maximal_exercise" value="Yes" <?php echo (($_SESSION['involves_maximal_exercise'] ?? $involves_maximal_exercise) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="involves_maximal_exercise" value="No" <?php echo (($_SESSION['involves_maximal_exercise'] ?? $involves_maximal_exercise) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="maximal_exercise_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['maximal_exercise_description'] ?? $maximal_exercise_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 15 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">15. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Is there any form of procedure/medication involved?<br><i>Adakah terdapat sebarang prosedur/ubat yang terlibat?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="involves_procedure_or_medication" value="Yes" <?php echo (($_SESSION['involves_procedure_or_medication'] ?? $involves_procedure_or_medication) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="involves_procedure_or_medication" value="No" <?php echo (($_SESSION['involves_procedure_or_medication'] ?? $involves_procedure_or_medication) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="procedure_medication_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['procedure_medication_description'] ?? $procedure_medication_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 16 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">16. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Is there any drug or device used with an unapproved indication?<br><i>Adakah terdapat ubat atau peranti yang digunakan tanpa indikasi yang diluluskan?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="involves_unapproved_indication" value="Yes" <?php echo (($_SESSION['involves_unapproved_indication'] ?? $involves_unapproved_indication) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="involves_unapproved_indication" value="No" <?php echo (($_SESSION['involves_unapproved_indication'] ?? $involves_unapproved_indication) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="unapproved_indication_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['unapproved_indication_description'] ?? $unapproved_indication_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 17 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">17. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Can the informed consent be obtained from anyone other than the patient/participants?<br><i>Adakah keizinan kajian telah didapati daripada sesiapa selain pesakit/peserta?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="consent_from_others" value="Yes" <?php echo (($_SESSION['consent_from_others'] ?? $consent_from_others) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="consent_from_others" value="No" <?php echo (($_SESSION['consent_from_others'] ?? $consent_from_others) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="consent_other_than_participants_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['consent_other_than_participants_description'] ?? $consent_other_than_participants_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 18 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">18. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Is there any kind of risk to the participants if he/she chose to withdraw?<br><i>Adakah terdapat sebarang kemudaratan kepada peserta jika dia memilih untuk menarik diri?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="risk_if_withdraw" value="Yes" <?php echo (($_SESSION['risk_if_withdraw'] ?? $risk_if_withdraw) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="risk_if_withdraw" value="No" <?php echo (($_SESSION['risk_if_withdraw'] ?? $risk_if_withdraw) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="risk_withdrawal_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['risk_withdrawal_description'] ?? $risk_withdrawal_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 19 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">19. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Will the samples obtained be stored for future research?<br><i>Adakah sampel yang dikumpul akan disimpan untuk penyelidikan di masa hadapan?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="stores_samples" value="Yes" <?php echo (($_SESSION['stores_samples'] ?? $stores_samples) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="stores_samples" value="No" <?php echo (($_SESSION['stores_samples'] ?? $stores_samples) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="store_samples_future_research_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['store_samples_future_research_description'] ?? $store_samples_future_research_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 20 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">20. </td>
                    <td style="padding: 10px; border: 1px solid #000;">Do you propose to analyse the sample outside of the original purpose for which it was collected?<br><i>Adakah anda bercadang untuk menganalisa sampel selain tujuan asal ia dikumpulkan?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="analyses_sample_other_purpose" value="Yes" <?php echo (($_SESSION['analyses_sample_other_purpose'] ?? $analyses_sample_other_purpose) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="analyses_sample_other_purpose" value="No" <?php echo (($_SESSION['analyses_sample_other_purpose'] ?? $analyses_sample_other_purpose) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="analyse_sample_other_purpose_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['analyse_sample_other_purpose_description'] ?? $analyse_sample_other_purpose_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 21 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">21. </td>
                    <td style="padding: 10px; border: 1px solid #000;">If ‘Yes’ to No. 20, have you obtained consent from participants for this purpose?<br><i>Jika 'Ya' pada No. 20, adakah anda mendapat persetujuan daripada peserta untuk tujuan ini?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="consent_for_other_purpose" value="Yes" <?php echo (($_SESSION['consent_for_other_purpose'] ?? $consent_for_other_purpose) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="consent_for_other_purpose" value="No" <?php echo (($_SESSION['consent_for_other_purpose'] ?? $consent_for_other_purpose) == 'No') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <textarea name="consent_for_other_purpose_description" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['consent_for_other_purpose_description'] ?? $consent_for_other_purpose_description); ?></textarea>
                    </td>
                </tr>
                <!-- Question 22 -->
                <tr>
                    <td style="padding: 5px; border: 1px solid #000;">22. </td>
                    <td style="padding: 10px; border: 1px solid #000;">What type of biological samples collected?<br><i>Apakah jenis sampel biologi yang dikumpul?</i></td>
                    <td colspan="3" style="padding: 10px; border: 1px solid #000;">
                        <textarea name="biological_samples_type" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['biological_samples_type'] ?? $biological_samples_type); ?></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
            <br>

                <!-- Other Ethical Issues Table -->
                <h4></hr>OTHER ETHICAL ISSUES<hr></h4>
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                    <thead>
                        <tr>
                            <th style="padding: 10px; width: 3%; border: 0px solid #000;"></th>
                            <th style="padding: 10px; border: 0px solid #000;">OTHER ETHICAL ISSUES</th>
                            <th style="padding: 10px; border: 1px solid #000;">Yes</th>
                            <th style="padding: 10px; border: 1px solid #000;">No</th>
                            <th style="padding: 10px; border: 1px solid #000;">Brief Description</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Question 23 -->
                    <tr>
                        <td style="padding: 5px; border: 1px solid #000;">23.</td>
                        <td style="padding: 10px; border: 1px solid #000;">Are there any other ethical issues not stated in this checklist?<br><i>Adakah terdapat sebarang isu etika lain yang tidak dinyatakan dalam senarai semak ini?</i></td>
                        <td style="padding: 10px; border: 1px solid #000;">
                            <input type="radio" name="other_ethical_issues" value="Yes" <?php echo (($_SESSION['other_ethical_issues'] ?? $other_ethical_issues) == 'Yes') ? 'checked' : ''; ?>>
                        </td>
                        <td style="padding: 10px; border: 1px solid #000;">
                            <input type="radio" name="other_ethical_issues" value="No" <?php echo (($_SESSION['other_ethical_issues'] ?? $other_ethical_issues) == 'No') ? 'checked' : ''; ?>>
                        </td>
                        <td style="padding: 10px; width: 37%; border: 1px solid #000;">
                            <textarea name="other_ethical_issues_description" style="width: 100%; padding-bottom: 30%;"><?php echo htmlspecialchars($_SESSION['other_ethical_issues_description'] ?? $other_ethical_issues_description); ?></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <br>

            <!-- Part F: Applicant Checklist . -->
            <div class="section">
                <h3>Part F: Applicant Checklist<br><i>Bahagian F: Senarai Semak Pemohon</i></h3>

                <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; font-family: Arial, sans-serif; margin-top: 20px;">
                    <tbody>
                        <tr>
                            <td style="padding: 15px; border: 1px solid #000; background-color: #f4f4f4;">
                                <strong>Terms of Submission of Ethics Approval Application</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px; border: 1px solid #000;">
                                <p style="margin: 0; line-height: 1.6;">1. Please ensure that all research team members have signed the application.</p><br>
                                <p style="margin: 0; line-height: 1.6;">2. Please ensure that the application has been signed and endorsed by the Department or Postgraduate Research Sub-Committee.</p><br>
                                <p style="margin: 0; line-height: 1.6;">3. All required documents must be submitted within two (2) months before the data collection.</p><br>
                                <p style="margin: 0; line-height: 1.6;">4. Submission of all forms prescribed by the REC must be in English, with exception to research conducted in other languages (with Senate approval).</p><br>
                                <p style="margin: 0; line-height: 1.6;">5. Any data collection instruments that require completion by respondents/participants must be prepared in the Malay and English languages, and other language(s) understood by the participants.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            <!-- Applicant Checklist Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                <thead>
                    <tr>
                        <th style="padding: 10px; width: 3%; border: 0px solid #000;"></th>
                        <th style="padding: 10px; border: 0px solid #000;">Part A – For All Applicants<br><i>Bahagian A – Untuk Semua Pemohon</i></th>
                        <th style="padding: 10px; border: 1px solid #000;">YES<br><i>YA</i></th>
                        <th style="padding: 10px; border: 1px solid #000;">NO<br><i>TIDAK</i></th>
                    </tr>
                </thead>
                <tbody>
                <!-- Question 1 -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;">1.</td>
                    <td style="padding: 10px; border: 1px solid #000;">Have you presented your proposal at the Department or Postgraduate Research Sub-Committee?<br><i>Adakah anda telah membentangkan proposal anda di Jawatankuasa Kecil Penyelidikan Jabatan atau Pascasiswazah?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="presented_proposal" value="Yes" <?php echo (($_SESSION['presented_proposal'] ?? $presented_proposal) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="presented_proposal" value="No" <?php echo (($_SESSION['presented_proposal'] ?? $presented_proposal) == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <!-- Question 2 -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;">2.</td>
                    <td style="padding: 10px; border: 1px solid #000;">Have you completed the F/BERC 1 form?<br><i>Adakah anda telah melengkapkan Borang F/BERC 1?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="completed_berc1" value="Yes" <?php echo (($_SESSION['completed_berc1'] ?? $completed_berc1) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="completed_berc1" value="No" <?php echo (($_SESSION['completed_berc1'] ?? $completed_berc1) == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <!-- Question 3 -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;">3.</td>
                    <td style="padding: 10px; border: 1px solid #000;">Have you completed the F/BERC 2 or and F/BERC 3 form?<br><i>Adakah anda telah melengkapkan Borang F/BERC 2 atau dan borang F/BERC 3?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="completed_berc2_or_3" value="Yes" <?php echo (($_SESSION['completed_berc2_or_3'] ?? $completed_berc2_or_3) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="completed_berc2_or_3" value="No" <?php echo (($_SESSION['completed_berc2_or_3'] ?? $completed_berc2_or_3) == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <!-- Question 4 -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;">4.</td>
                    <td style="padding: 10px; border: 1px solid #000;">Has your supervisor checked your application forms?<br><i>Adakah penyelia anda telah menyemak borang permohonan anda?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="supervisor_checked" value="Yes" <?php echo (($_SESSION['supervisor_checked'] ?? $supervisor_checked) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="supervisor_checked" value="No" <?php echo (($_SESSION['supervisor_checked'] ?? $supervisor_checked) == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <!-- Question 5 -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;">5.</td>
                    <td style="padding: 10px; border: 1px solid #000;">Has the form been signed by all researchers?<br><i>Adakah borang ditandatangani oleh semua penyelidik?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="signed_by_all_researchers" value="Yes" <?php echo (($_SESSION['signed_by_all_researchers'] ?? $signed_by_all_researchers) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="signed_by_all_researchers" value="No" <?php echo (($_SESSION['signed_by_all_researchers'] ?? $signed_by_all_researchers) == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <!-- Question 6 -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;">6.</td>
                    <td style="padding: 10px; border: 1px solid #000;">Has your application been endorsed by the Department or Postgraduate Research Sub-Committee?<br><i>Sudahkah permohonan anda mendapat pengesahan Jawatankuasa Kecil Penyelidikan Jabatan atau Pascasiswazah?</i></td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="endorsed_by_committee" value="Yes" <?php echo (($_SESSION['endorsed_by_committee'] ?? $endorsed_by_committee) == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td style="padding: 10px; border: 1px solid #000;">
                        <input type="radio" name="endorsed_by_committee" value="No" <?php echo (($_SESSION['endorsed_by_committee'] ?? $endorsed_by_committee) == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                </tbody>
                </table>

                <br>
                <!-- Additional Comments -->
                <label for="additional_comments"><strong>Additional comments (if any):<br>Komen Tambahan (Jika Ada):</strong></label>
                <textarea id="additional_comments" name="additional_comments" rows="4" style="width: 100%;"><?php echo htmlspecialchars($_SESSION['additional_comments'] ?? $additional_comments); ?></textarea>
                <br><br>

            <!-- Signatures -->
            <table>
                <tbody>
                    <tr>
                <!-- Applicant's Signature -->
                <tr>
                    <td>
                        <!-- Signature Box -->
                        <p><strong>Applicant's Signature:<br><i>Tandatangan Peserta:</i></strong><hr></p>
                        <!-- Agree to Terms Checkbox -->
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" id="Applicants_Signature_F" name="Applicants_Signature_F" required 
                                <?php if (!empty($_SESSION['Applicants_Signature_F'] ?? $Applicants_Signature_F)) echo 'checked'; ?>>
                                I have read and understood the terms and conditions of my participation.
                            </label>
                            <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                        </div>

                        <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="Applicants_Date_F" id="Applicants_Date_F" style="width: 40%;" required
                            value="<?php echo htmlspecialchars($_SESSION['Applicants_Date_F'] ?? $Applicants_Date_F); ?>">
                    </td>
                </tr>

                <!-- Supervisor's Signature -->
                <tr>
                    <td>
                        <!-- Signature Box -->
                        <p><strong>Supervisor's Signature:<br><i>Tandatangan Penyelia:</i></strong><hr></p>
                        <!-- Agree to Terms Checkbox -->
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" id="Supervisors_Signature" name="Supervisors_Signature" required 
                                <?php if (!empty($_SESSION['Supervisors_Signature'] ?? $Supervisors_Signature)) echo 'checked'; ?>>
                                I have read and understood the terms and conditions of my participation.
                            </label>
                            <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                        </div>

                        <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="Supervisors_Date" id="Supervisors_Date" style="width: 40%;" 
                            value="<?php echo htmlspecialchars($_SESSION['Supervisors_Date'] ?? $Supervisors_Date); ?>">
                    </td>
                </tr>
                </tbody>
            </table>
            <br>

            <!-- Part G: Verification from Department or Postgraduate Research Sub-Committee -->
            <div class="section">
                <h3>Part G: Verification from Department or Postgraduate Research Sub-Committee<br><i>Bahagian G: Pengesahan Jawatankuasa Kecil Penyelidikan Jabatan atau Pascasiswazah</i></h3>
                <p>We have deliberated on the application and propose as below:</p>
                <p><i>Kami telah meneliti permohonan ini dan mencadangkan seperti di bawah:</i></p>


            <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-family: Arial, sans-serif;">
                <tbody>
                    <!-- Minimal risk -->
                    <tr>
                        <td style="padding: 10px; border: 1px solid #000;">
                            <label for="MinimalRisk">
                                <input type="radio" id="Risk" name="Risk" value="MinimalRisk" 
                                <?php echo (($_SESSION['Risk'] ?? $Risk) == 'MinimalRisk') ? 'checked' : ''; ?>>
                                Minimal risk research. Recommend for approval without presentation.
                            </label>
                            <label><i>Penyelidikan melibatkan risiko minima. Dicadangkan untuk mendapat kelulusan tanpa pembentangan.</i></label>
                        </td>
                    </tr>
                    <!-- More than minimal risk -->
                    <tr>
                        <td style="padding: 10px; border: 1px solid #000;">
                            <label for="MoreMinimalRisk">
                                <input type="radio" id="Risk" name="Risk" value="MoreMinimalRisk" 
                                <?php echo (($_SESSION['Risk'] ?? $Risk) == 'MoreMinimalRisk') ? 'checked' : ''; ?>>
                                More than minimal risk research. Recommend to forward to UiTM REC.
                            </label>
                            <label><i>Penyelidikan melibatkan risiko melebihi minima. Dicadangkan untuk dihantar kepada UiTM REC.</i></label>
                        </td>
                    </tr>
                </tbody>
            </table>

                <!-- Comments -->
                <p>Comment if any: <br><i>Ulasan jika ada:</i></p>
                <textarea id="additional_comments" rows="4" style="width: 100%; border: 1px solid #000; padding: 10px;"><?php echo htmlspecialchars(isset($_SESSION['additional_comments']) ? $_SESSION['additional_comments'] : $additional_comments); ?></textarea>
                <br><br>

                <!-- Signatures for Coordinator and Official Stamp -->
                <table>
                    <tbody>
                    <!-- Coordinator Signature -->
                    <tr>
                        <td>
                            <label for="signatureCoordinator"><b>Signature Coordinator of Committee:</b><br><i>Tandatangan Koordinator Jawatankuasa:</i></label>
                            <div class="checkbox-group">
                                <label>
                                    <input type="checkbox" id="Coordinator_Signature_G" name="Coordinator_Signature_G" required 
                                    <?php if (isset($_SESSION['Coordinator_Signature_G']) && $_SESSION['Coordinator_Signature_G'] == 'on' || !empty($Coordinator_Signature_G)) echo 'checked'; ?>>
                                    I have read and understood the terms and conditions of my participation.
                                </label>
                                <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                            </div>
                        </td>
                    </tr>

                    <!-- Official Stamp -->
                    <tr>
                        <td>
                            <label for="officialstamp"><b>Official Stamp:</b><br><i>Cop Rasmi:</i></label>
                            <div class="checkbox-group">
                                <label>
                                    <input type="checkbox" id="Official_stamp_G" name="Official_stamp_G" required 
                                    <?php if (isset($_SESSION['Official_stamp_G']) && $_SESSION['Official_stamp_G'] == 'on' || !empty($Official_stamp_G)) echo 'checked'; ?>>
                                    I have read and understood the terms and conditions of my participation.
                                </label>
                                <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                            </div>
                        </td>
                    </tr>

                    <!-- Date -->
                    <tr>
                        <td>
                            <label for="datesignCoordinator"><b>Date:</b><br><i>Tarikh:</i></label>
                            <input type="date" name="Coordinator_Date" id="Coordinator_Date" style="width: 50%;" 
                                value="<?php echo htmlspecialchars(isset($_SESSION['Coordinator_Date']) ? $_SESSION['Coordinator_Date'] : $Coordinator_Date); ?>">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <br>

            <div class="button-container">
                <!-- Save as Draft button -->
                <button type="submit" class="submit-button" id="saveAsDraft" name="save_draft">Save as Draft</button>
                <!-- Submit button -->
                <button type="submit" class="next-button" id="submitForm" name="next">Next</button>
            </div>
            </form>
    </div>

    <script>
        // Get elements for form submission
        const form = document.getElementById('myForm');
        const saveAsDraftButton = document.getElementById('saveAsDraft');
        const submitFormButton = document.getElementById('submitForm');

        // Save as Draft button click logic
        saveAsDraftButton.addEventListener('click', function(event) {
            // Disable validation for Save as Draft button
            form.noValidate = true;
        });

        // Submit button click logic
        submitFormButton.addEventListener('click', function(event) {
            // Enable validation for Submit button
            form.noValidate = false;
        });
    </script>

</body>
</html>
