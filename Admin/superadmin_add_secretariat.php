<?php

// Include the database connection
include '../config.php'; // Include the connection from db_connection.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffID = $conn->real_escape_string($_POST['staffID']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert secretariat details into database
    $insertQuery = "INSERT INTO secretariat (staffID, name, email, password_hash) VALUES ('$staffID', '$name', '$email', '$password')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "<script>alert('Secretariat added successfully!'); window.location.href='../admin.php';</script>";
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Secretariat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .form-control {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Add New Secretariat</h3>
                    <form action="superadmin_add_secretariat.php" method="POST">
                        <div class="mb-3">
                            <label for="staffID" class="form-label">Staff ID</label>
                            <input type="text" class="form-control" id="staffID" name="staffID" placeholder="Enter Staff ID" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Add Secretariat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
