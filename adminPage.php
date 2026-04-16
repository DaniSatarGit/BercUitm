<?php
session_start();
include 'databaseConnect.php'; // Include your database connection file

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch admin user from the database
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $mysqli->prepare($query); // Use $mysqli instead of $conn
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $admin['password_hash'])) {
            // Set session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['user_role'] = 'admin';
            $_SESSION['username'] = $username; // Store username in session
            // Redirect to the admin page
            header('Location: admin.php');
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
}

// Show login form regardless of session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - UiTM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: url('path_to_your_background_image.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: Arial, sans-serif;
            color: #003DA5; /* UiTM blue color */
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 10%;
        }
        h2 {
            margin-bottom: 20px;
            color: #003DA5; /* UiTM blue */
        }
        .btn-primary {
            background-color: #003DA5; /* UiTM blue */
            border: none;
        }
        .btn-primary:hover {
            background-color: #002a7a; /* Darker blue on hover */
        }
        .form-control {
            border: 1px solid #003DA5; /* UiTM blue for input borders */
        }
        .form-control:focus {
            border-color: #003DA5; /* UiTM blue on focus */
            box-shadow: 0 0 5px rgba(0, 61, 165, 0.5); /* Blue glow on focus */
        }
        .alert-danger {
            background-color: rgba(255, 0, 0, 0.2); /* Light red for error messages */
            color: #721c24; /* Dark red text */
        }

        /* Responsive design for different devices */
        @media (max-width: 576px) {
            .login-container {
                width: 90%;
                padding: 1.5rem;
            }
        }
        @media (min-width: 768px) {
            .login-container {
                width: 400px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center">Admin Login</h2>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <strong>Error:</strong> <?= $error; ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
