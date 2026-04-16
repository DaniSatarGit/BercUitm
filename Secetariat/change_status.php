<?php
include("../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $researchTitle = $conn->real_escape_string($_POST['research_title']);
    $status = $conn->real_escape_string($_POST['status']);
    $type = $_POST['type'] ?? '';

    // Determine the approved and coordinator tables based on the type
    if ($type === 'berc') {
        $approvedTable = 'approved_application';
        $coordinatorTable = 'coordinator_application';
    } elseif ($type === 'exemption') {
        $approvedTable = 'approved_exemption';
        $coordinatorTable = 'coordinator_exemption';
    } else {
        echo 'error: Invalid type specified. Type should be "berc" for applications or "exemption" for exemptions.';
        exit;
    }

    // Update the status in the approved table
    $updateQuery = "UPDATE $approvedTable SET status = ? WHERE research_title = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ss', $status, $researchTitle);

    if ($stmt->execute()) {
        // If the status is "Proceed to Coordinator", insert into the appropriate coordinator table
        if ($status === 'Proceed to Coordinator') {
            $selectQuery = "SELECT research_title, researcher_name, part_a_supervisor_name, department_address, submission_date FROM $approvedTable WHERE research_title = ?";
            $selectStmt = $conn->prepare($selectQuery);
            $selectStmt->bind_param('s', $researchTitle);
            $selectStmt->execute();
            $result = $selectStmt->get_result();

            if ($result && $row = $result->fetch_assoc()) {
                // Insert into the correct coordinator table
                $insertQuery = "INSERT INTO $coordinatorTable (research_title, researcher_name, part_a_supervisor_name, department_address, submission_date)
                                VALUES (?, ?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param(
                    'ssss',
                    $row['research_title'],
                    $row['researcher_name'],
                    $row['part_a_supervisor_name'],
                    $row['department_address'],
                    $row['submission_date']
                );

                if ($insertStmt->execute()) {
                    echo 'success';
                } else {
                    echo 'error: Failed to insert into coordinator table. ' . $insertStmt->error;
                }

                $insertStmt->close();
            } else {
                echo 'error: Failed to retrieve application data. ' . $selectStmt->error;
            }

            $selectStmt->close();
        } else {
            echo 'success';
        }
    } else {
        echo 'error: Failed to update status. ' . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    echo 'Invalid request method.';
}
?>
