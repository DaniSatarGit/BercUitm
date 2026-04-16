<?php
// Include the database configuration file
include '../config.php';

if (isset($_POST['id']) && isset($_POST['reviewerId'])) {
    $id = $_POST['id'];
    $reviewerId = $_POST['reviewerId'];

    // Fetch the application details from coordinator_application
    $sql = "SELECT research_title, researcher_name, part_a_supervisor_name, department_address, status 
            FROM coordinator_application WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $application = $result->fetch_assoc();

        // Check if the application already has an assigned reviewer
        $checkReviewerSql = "SELECT id FROM reviewer_application WHERE application_id = ?";
        $checkReviewerStmt = $conn->prepare($checkReviewerSql);
        $checkReviewerStmt->bind_param('i', $id);
        $checkReviewerStmt->execute();
        $checkResult = $checkReviewerStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // If reviewer is already assigned, update the reviewer
            $updateSql = "UPDATE reviewer_application 
                          SET reviewer_id = ?, assigned_at = CURRENT_TIMESTAMP
                          WHERE application_id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('ii', $reviewerId, $id);

            if ($updateStmt->execute()) {
                echo 'Reviewer updated successfully';
            } else {
                echo 'Error updating reviewer';
            }
        } else {
            // If no reviewer is assigned, insert a new reviewer assignment
            $insertSql = "INSERT INTO reviewer_application (application_id, reviewer_id, research_title, researcher_name, part_a_supervisor_name, department_address, status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param('iisssss', $id, $reviewerId, $application['research_title'], $application['researcher_name'], $application['part_a_supervisor_name'], $application['department_address'], $application['status']);

            if ($insertStmt->execute()) {
                echo 'Reviewer assigned successfully';
            } else {
                echo 'Error assigning reviewer';
            }
        }
    } else {
        echo 'Application not found';
    }
}
?>
