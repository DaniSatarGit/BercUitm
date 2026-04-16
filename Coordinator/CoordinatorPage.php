<?php
session_start();

// Ensure the user is logged in and is a reviewer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Coordinator') {
    header('Location: ../index.php'); // Redirect to login if not authenticated
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(to bottom right, #f7f8fc, #dee4f0);
            color: #333;
        }
        .main-header {
            background-color: #fff;
            border-bottom: 2px solid #dee2e6;
        }
        .main-header .logo {
            height: 50px;
        }
        .main-header h1 {
            font-weight: 600;
            color: #555;
        }
        .btn-danger {
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        .main-content {
            padding: 2rem 0;
        }
        .custom-card {
            background: #ffffff;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .custom-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .custom-card .card-title {
            font-weight: 600;
            color: #333;
        }
        .custom-card .btn-primary {
            background: linear-gradient(90deg, #007bff, #0056d4);
            border: none;
            border-radius: 20px;
            padding: 0.5rem 1.5rem;
        }
        .custom-card .btn-primary:hover {
            background: linear-gradient(90deg, #0056d4, #0041a8);
        }
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="main-header d-flex justify-content-between align-items-center px-4 py-3 shadow-sm">
        <div class="header-left">
            <img src="image/Uitm.png" alt="UiTM Logo" class="logo">
        </div>
        <div class="header-center">
            <h1 class="h5">Hello <?= htmlspecialchars($_SESSION['name']); ?></h1>
        </div>
        <div class="header-right">
            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
        </div>
    </header>

    <!-- Main Content Section -->
    <section class="main-content container mt-5">
        <div class="row justify-content-center">
            <!-- Application Card -->
            <div class="col-md-5 mb-4">
                <div class="card custom-card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Application Portal</h5>
                        <p class="card-text">Submit and manage your applications efficiently.</p>
                        <a href="application.php" class="btn btn-primary mt-3">Go to Application</a>
                    </div>
                </div>
            </div>

            <!-- Exemption Card -->
            <div class="col-md-5 mb-4">
                <div class="card custom-card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Exemption Portal</h5>
                        <p class="card-text">Apply for exemptions and track your requests.</p>
                        <a href="exemption.php" class="btn btn-primary mt-3">Go to Exemption</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
