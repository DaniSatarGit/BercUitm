<?php
include '../databaseConnect.php'; // Include your database connection file

// First admin user details
$username = 'admin'; // Set the desired username
$password = '130902004'; // Set the desired password

// Hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// SQL to create the admin table if it doesn't exist
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute table creation
if ($mysqli->query($sqlCreateTable) === TRUE) {
    // Prepare and bind the insert statement
    $stmt = $mysqli->prepare("INSERT INTO admin (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password_hash);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Admin user created successfully.";
    } else {
        echo "Error creating admin user: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error creating table: " . $mysqli->error;
}

$mysqli->close();
?>
