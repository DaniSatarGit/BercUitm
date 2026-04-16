<?php

// Include the database connection
include '../config.php'; // Include the connection from db_connection.php

$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';
$allowedTables = ['researcher', 'coordinator', 'reviewer', 'secretariat'];

if (!in_array($type, $allowedTables, true) || $id === '') {
    echo "Invalid user.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $table = $type;

    $checkStmt = $conn->prepare("SELECT staffID FROM $table WHERE staffID = ?");
    $checkStmt->bind_param("s", $id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $user = $result->fetch_assoc();
    $checkStmt->close();

    if ($user) {
        $stmt = $conn->prepare("UPDATE $table SET password_hash = ? WHERE staffID = ?");
        $stmt->bind_param("ss", $password, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Password changed successfully!'); window.location.href='../admin.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "User not found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Reset Password</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-warning">Change Password</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
