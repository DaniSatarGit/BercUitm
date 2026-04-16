<?php

// Include the database connection
include '../config.php'; // Include the connection from db_connection.php

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape the form data to prevent SQL injection
    $staffID = $conn->real_escape_string($_POST['staffID']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert query to add a new secretariat
    $insertQuery = "INSERT INTO secretariat (staffID, name, email, password_hash) VALUES ('$staffID', '$name', '$email', '$password')";
    
    // Execute the query and check if successful
    if ($conn->query($insertQuery) === TRUE) {
        // Success message and redirection back to the dashboard
        echo "<script>alert('Secretariat registered successfully!'); window.location.href='../admin.php';</script>";
    } else {
        // Error message
        echo "Error: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
