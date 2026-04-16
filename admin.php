<?php
session_start(); // Start the session

// Include the database connection
include 'config.php'; // Include the connection from db_connection.php

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to index.php
    header("Location: index.php");
    exit();
}

// Set the name variable, default to 'Guest' if not set
$name = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';

// Fetch data for each role
$coordinators = $conn->query("SELECT * FROM coordinator");
$researchers = $conn->query("SELECT * FROM researcher");
$reviewers = $conn->query("SELECT * FROM reviewer");
$secretariat = $conn->query("SELECT * FROM secretariat");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            color: #333;
            background-color: #f8f9fa;
        }

        .background {
            background-image: url('image/bg3.png');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding-bottom: 20px;
        }

        .header {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
        }

        .header img {
            max-width: 100px;
            height: auto;
            margin-left: 10px;
        }

        .greeting {
            font-size: 1.5em;
            font-weight: 500;
            color: #003a70;
        }

        .logout-button {
            background-color: #003a70;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #00509e;
        }

        .container {
            margin-top: 100px;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #003a70;
            margin-bottom: 30px;
            text-align: center;
        }

        h3 {
            color: #00509e;
            margin-top: 40px;
        }

        .table th {
            background-color: #003a70;
            color: white;
            text-align: center;
        }

        .table td {
            color: #003a70;
            text-align: center;
        }

        .btn-primary {
            background-color: #fbb034;
            border-color: #fbb034;
        }

        .btn-warning, .btn-secondary, .btn-danger {
            margin-right: 10px;
        }

        .btn-warning:hover {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .modal-content {
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .modal-header, .modal-footer {
            border: none;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body class="background">
    <div class="header">
        <img src="image/Uitm.png" alt="UiTM Logo">
        <div class="greeting">
            <?php echo $name; ?>
        </div>
        <button class="logout-button" onclick="openModal()">Logout</button>
    </div>

    <div class="container">
        <h2>User Management Dashboard</h2>

        <!-- Coordinator Section -->
        <h3>Coordinators</h3>
        <a href="admin/superadmin_add_coordinator.php" class="btn btn-primary mb-3">Add New Coordinator</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $coordinators->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['staffID']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="admin/superadmin_edit_user.php?type=coordinator&id=<?php echo $row['staffID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin/superadmin_reset_password.php?type=coordinator&id=<?php echo $row['staffID']; ?>" class="btn btn-secondary btn-sm">Change Password</a>
                            <a href="admin/superadmin_delete_user.php?type=coordinator&id=<?php echo $row['staffID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this coordinator?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Secretariat Section -->
        <h3>Secretariat</h3>
        <a href="admin/superadmin_add_secretariat.php" class="btn btn-primary mb-3">Add New Secretariat</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $secretariat->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['staffID']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="admin/superadmin_edit_user.php?type=secretariat&id=<?php echo $row['staffID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin/superadmin_reset_password.php?type=secretariat&id=<?php echo $row['staffID']; ?>" class="btn btn-secondary btn-sm">Change Password</a>
                            <a href="admin/superadmin_delete_user.php?type=secretariat&id=<?php echo $row['staffID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this secretariat?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Researcher Section -->
        <h3>Researchers</h3>
        <a href="admin/superadmin_add_researcher.php" class="btn btn-primary mb-3">Add New Researcher</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $researchers->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['staffID']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="admin/superadmin_edit_user.php?type=researcher&id=<?php echo $row['staffID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin/superadmin_reset_password.php?type=researcher&id=<?php echo $row['staffID']; ?>" class="btn btn-secondary btn-sm">Change Password</a>
                            <a href="admin/superadmin_delete_user.php?type=researcher&id=<?php echo $row['staffID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this researcher?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Reviewer Section -->
        <h3>Reviewers</h3>
        <a href="admin/superadmin_add_reviewer.php" class="btn btn-primary mb-3">Add New Reviewer</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $reviewers->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['staffID']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="admin/superadmin_edit_user.php?type=reviewer&id=<?php echo $row['staffID']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin/superadmin_reset_password.php?type=reviewer&id=<?php echo $row['staffID']; ?>" class="btn btn-secondary btn-sm">Change Password</a>
                            <a href="admin/superadmin_delete_user.php?type=reviewer&id=<?php echo $row['staffID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this reviewer?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for logout confirmation -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal() {
            const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        }
    </script>
</body>
</html>
