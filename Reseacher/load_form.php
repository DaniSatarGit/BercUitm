<?php
// Include the database connection
include '../config.php'; // Include the connection from db_connection.php

$formType = $_GET['formType'];
$id = $_GET['id'];

$sql = ""; // Initialize the $sql variable

// Assign the appropriate SQL based on the form type
if ($formType == 'berc1') {
    $sql = "SELECT * FROM berc1 WHERE id = ?";
} elseif ($formType == 'berc2') {
    $sql = "SELECT * FROM berc2 WHERE id = ?";
} elseif ($formType == 'berc3') {
    $sql = "SELECT * FROM berc3 WHERE id = ?";
} elseif ($formType == 'berc5') {
    $sql = "SELECT * FROM berc5 WHERE id = ?";
} else {
    die("Invalid form type.");
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h5>{$formType} Submission Details</h5>";
    foreach ($row as $key => $value) {
        echo "<p><strong>" . ucfirst(str_replace("_", " ", $key)) . ":</strong> " . htmlspecialchars($value) . "</p>";
    }
} else {
    echo "No form found.";
}

$conn->close();
?>
