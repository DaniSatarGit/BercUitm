<?php
session_start();

// Include the database connection
include '../../config.php'; // Include the connection from db_connection.php

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Dapatkan data dari Halaman 1
$research_title = $_SESSION['research_title'];
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
$submission_date = $_SESSION['submission_date'];

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

// Masukkan data dari Halaman 1 ke dalam jadual berc4
$query1 = "INSERT INTO berc4 (user_id, research_title, researcher_name, supervisor_name, dept_address, contact_info, study_level, research_just, research_obj, research_method, research_signif, research_risks, ethical_exempt_just, app_name, app_id, app_position, app_affiliation, app_office, app_mobile, app_email, app_date, app_signature, cb_signature, cb_stamp, sv_name, sv_id, sv_position, sv_affiliation, sv_office, sv_mobile, sv_email, sv_signature, sv_date, cores_name, cores_id, cores_position, cores_affiliation, cores_office, cores_mobile, cores_email, cores_signature, cores_date, submission_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("sssssssssssssssssssssssssssssssssssssssssss", $user_id, $research_title, $researcher_name, $supervisor_name, $dept_address, $contact_info, $study_level, $research_just, $research_obj, $research_method, $research_signif, $research_risks, $ethical_exempt_just, $app_name, $app_id, $app_position, $app_affiliation, $app_office, $app_mobile, $app_email, $app_date, $app_signature, $cb_signature, $cb_stamp, $sv_name, $sv_id, $sv_position, $sv_affiliation, $sv_office, $sv_mobile, $sv_email, $sv_signature, $sv_date, $cores_name, $cores_id, $cores_position, $cores_affiliation, $cores_office, $cores_mobile, $cores_email, $cores_signature, $cores_date, $submission_date);

if ($stmt1->execute()) {
    echo "Data dari Halaman 1 berjaya disimpan!<br>";
} else {
    echo "Ralat: " . $stmt1->error . "<br>";
}

// Masukkan data dari Halaman 2 ke dalam jadual berc5ex
$query2 = "INSERT INTO berc5ex (user_id, fberc1_berc5, fberc2_berc5, fberc3_berc5, fberc4_berc5, fberc5_berc5, form_signed_berc5, approved_by_faculty_berc5, supervisor_checked_berc5, additional_comments_berc5, decision_berc5, applicant_signature_berc5, applicant_date_berc5, supervisor_signature_berc5, supervisor_date_berc5, submission_date_berc5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("sssssssssssssss", $user_id, $fberc1_berc5, $fberc2_berc5, $fberc3_berc5, $fberc4_berc5, $fberc5_berc5, $form_signed_berc5, $approved_by_faculty_berc5, $supervisor_checked_berc5, $additional_comments_berc5, $decision_berc5, $applicant_signature_berc5, $applicant_date_berc5, $supervisor_signature_berc5, $supervisor_date_berc5);

if ($stmt2->execute()) {
    echo "Data dari Halaman 2 berjaya disimpan!<br>";
} else {
    echo "Ralat: " . $stmt2->error . "<br>";
}

// Padam semua data draf setelah borang dihantar
$delete_draft1_sql = "DELETE FROM berc4_draft WHERE user_id = ?";
$delete_draft2_sql = "DELETE FROM berc5_draftt WHERE user_id = ?";

$stmt_delete1 = $conn->prepare($delete_draft1_sql);
$stmt_delete1->bind_param("s", $user_id);
$stmt_delete1->execute();

if ($stmt_delete1->affected_rows > 0) {
    echo "Data draf Halaman 1 berjaya dipadamkan!<br>";
} else {
    echo "Tiada data draf untuk dipadamkan dari Halaman 1 atau ralat berlaku.<br>";
}

$stmt_delete2 = $conn->prepare($delete_draft2_sql);
$stmt_delete2->bind_param("s", $user_id);
$stmt_delete2->execute();

if ($stmt_delete2->affected_rows > 0) {
    echo "Data draf Halaman 2 berjaya dipadamkan!<br>";
} else {
    echo "Tiada data draf untuk dipadamkan dari Halaman 2 atau ralat berlaku.<br>";
}

// Alihkan ke halaman pengesahan
header("Location: submit.php");

// Tutup sambungan
$conn->close();
?>
