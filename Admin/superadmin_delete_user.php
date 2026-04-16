<?php

// Include the database connection
include '../config.php'; // Include the connection from db_connection.php

// Get user type and ID from the query parameters
$type = $_GET['type'];
$id = $_GET['id'];

// Prepare a statement for deletion based on the user type
if ($type === 'coordinator') {
    $stmt = $conn->prepare("DELETE FROM coordinator WHERE staffID = ?");
} elseif ($type === 'researcher') {
    $stmt = $conn->prepare("DELETE FROM researcher WHERE staffID = ?");
} elseif ($type === 'reviewer') {
    $stmt = $conn->prepare("DELETE FROM reviewer WHERE staffID = ?");
} elseif ($type === 'secretariat') {
    $stmt = $conn->prepare("DELETE FROM secretariat WHERE staffID = ?");
} else {
    die("Invalid user type.");
}

// Bind the ID parameter and execute the statement
$stmt->bind_param("s", $id);
if ($stmt->execute()) {
    // Success message
    echo "<script>alert('User deleted successfully.'); window.location.href='../admin.php';</script>";
} else {
    // Error message
    echo "<script>alert('Error deleting user: " . $conn->error . "'); window.location.href='../admin.php';</script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
