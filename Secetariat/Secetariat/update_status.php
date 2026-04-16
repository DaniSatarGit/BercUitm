<?php
session_start();
include("../config.php");

$application_id = $_POST['application_id'];
$type = $_POST['type'];
$status = $_POST['status'];
$updated_by = $_SESSION['name'] ?? 'Unknown';

if ($type === 'berc') {
    $table = 'approved_application';
} elseif ($type === 'exemption') {
    $table = 'approved_exemption';
} else {
    die("Invalid application type.");
}

$query = "
    UPDATE $table
    SET status = ?, updated_by = ?, updated_at = NOW()
    WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $status, $updated_by, $application_id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Status updated successfully!";
} else {
    $_SESSION['error'] = "Failed to update status: " . $conn->error;
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
