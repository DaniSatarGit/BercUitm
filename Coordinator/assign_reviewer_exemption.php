<?php
// Include the database configuration file
include '../config.php';

if (isset($_POST['id']) && isset($_POST['reviewerId'])) {
    $id = $_POST['id'];
    $reviewerId = $_POST['reviewerId'];

    // Fetch the exemption details from coordinator_exemption
    $sql = "SELECT research_title, researcher_name, supervisor_name, dept_address, status 
            FROM coordinator_exemption WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $exemption = $result->fetch_assoc();

        // Check if the exemption already has an assigned reviewer
        $checkReviewerSql = "SELECT id FROM reviewer_exemption WHERE exemption_id = ?";
        $checkReviewerStmt = $conn->prepare($checkReviewerSql);
        $checkReviewerStmt->bind_param('i', $id);
        $checkReviewerStmt->execute();
        $checkResult = $checkReviewerStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // If reviewer is already assigned, update the reviewer
            $updateSql = "UPDATE reviewer_exemption 
                          SET reviewer_id = ?, assigned_at = CURRENT_TIMESTAMP
                          WHERE exemption_id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param('ii', $reviewerId, $id);

            if ($updateStmt->execute()) {
                echo 'Reviewer updated successfully';
            } else {
                echo 'Error updating reviewer';
            }
        } else {
            // If no reviewer is assigned, insert a new reviewer assignment
            $insertSql = "INSERT INTO reviewer_exemption (exemption_id, reviewer_id, research_title, researcher_name, supervisor_name, dept_address, status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param('iisssss', $id, $reviewerId, $exemption['research_title'], $exemption['researcher_name'], $exemption['supervisor_name'], $exemption['dept_address'], $exemption['status']);

            if ($insertStmt->execute()) {
                echo 'Reviewer assigned successfully';
            } else {
                echo 'Error assigning reviewer';
            }
        }
    } else {
        echo 'exemption not found';
    }
}
?>
