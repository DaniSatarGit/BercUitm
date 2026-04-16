<?php
// Database connection settings
$mysqli = require __DIR__ . '/databaseConnect.php';

$errors = [];  // Array to hold validation errors
$staff_id = trim($_POST["staffID"] ?? '');
$name = trim($_POST["name"] ?? '');
$email = trim($_POST["email"] ?? '');

// Check if form is submitted using POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate Staff ID
    if ($staff_id === '') {
        $errors[] = "Staff ID is required.";
    }

    // Validate Full Name
    if ($name === '') {
        $errors[] = "Full name is required.";
    }

    // Validate Email and format
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }

    // Password validation
    $password = $_POST["password"] ?? '';
    $password_confirm = $_POST["password_confirm"] ?? '';

    if (empty($password)) {
        $errors[] = "Password is required.";
    } else {
        // Password length and complexity validation
        if (strlen($password) < 8 || strlen($password) > 16) {
            $errors[] = "Password must be between 8 and 16 characters.";
        }
        if (!preg_match("/[a-z]/", $password)) {
            $errors[] = "Password must contain at least one lowercase letter.";
        }
        if (!preg_match("/[A-Z]/", $password)) {
            $errors[] = "Password must contain at least one uppercase letter.";
        }
        if (!preg_match("/[0-9]/", $password)) {
            $errors[] = "Password must contain at least one number.";
        }
        if (!preg_match("/[\W_]/", $password)) {
            $errors[] = "Password must contain at least one special character.";
        }

        // Check if password matches the confirmation
        if ($password !== $password_confirm) {
            $errors[] = "Passwords do not match.";
        }
    }

    // If no errors, proceed with database insertion
    if (count($errors) === 0) {
        // Hash the password for security
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert only for Researcher role
        $sql = "INSERT INTO researcher (staffID, name, email, password_hash) VALUES (?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $mysqli->prepare($sql);

        // Check if the statement was prepared successfully
        if (!$stmt) {
            die("SQL error: " . $mysqli->error);
        }

        // Bind parameters to the SQL query
        $stmt->bind_param("ssss",  
                          $staff_id, 
                          $name, 
                          $email, 
                          $password_hash);

        // Execute the query and check for success
        if ($stmt->execute()) {
            // Redirect to a success page after sign-up
            header("Location: signUpsucces.php");  
            exit;
        } else {
            if ($stmt->errno === 1062) {
                $errors[] = "Staff ID or email already exists. Please use a different one.";
            } else {
                // Collect any SQL execution error
                $errors[] = "SQL error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - UiTM</title>
    <link rel="icon" href="image/IconRMU (1).ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS styling remains unchanged */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('image/bg3.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .layout {
            display: flex;
            width: 85%;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .sidebar {
            width: 40%;
            background: linear-gradient(135deg, #54006e, #0d2f81); /* UiTM purple to blue gradient */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 15px;
        }

        .sidebar img {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
        }

        .container {
            width: 60%;
            padding: 25px 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            box-sizing: border-box;
        }

        h1 {
            font-size: 20px;
            color: #54006e;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .error-message {
            background: #fdeaea;
            border: 1px solid #f3b7b7;
            border-radius: 6px;
            color: #a12626;
            font-size: 13px;
            margin-bottom: 15px;
            padding: 10px 12px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 13px;
            color: #555;
            font-weight: 600;
        }

        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            border-color: #54006e;
            outline: none;
            box-shadow: 0 0 3px rgba(84, 0, 110, 0.3);
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 35px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 8px;
            top: 39px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #54006e;
            font-size: 16px;
        }

        button {
            background: #54006e;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px;
            width: 100%;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #3a0055;
        }

        .back-button {
            background-color: #0d2f81;
            color: #fff;
            padding: 10px;
            border-radius: 6px;
            font-size: 15px;
            width: 100%;
            font-weight: bold;
            margin-top: 10px;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0b255e;
        }

        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
                max-width: 100%;
                width: 90%;
            }
            .sidebar, .container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <div class="sidebar">
            <div>
                <img src="image/Uitm.png" alt="UiTM Logo">
                <h2>Welcome to UiTM</h2>
                <p>Create your account to get started.</p>
            </div>
        </div>
        
        <div class="container">
            <h1>Sign Up</h1>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo htmlspecialchars($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="post" novalidate>
                <div class="form-group">
                    <label for="staffID">Staff ID:</label>
                    <input type="text" id="staffID" name="staffID" required placeholder="Enter your staff ID" value="<?php echo htmlspecialchars($staff_id); ?>">
                </div>

                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name" value="<?php echo htmlspecialchars($name); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <!-- Hidden Researcher role field -->
                <input type="hidden" name="roles" value="Researcher">

                <div class="form-group password-container">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                    <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
                </div>

                <div class="form-group password-container">
                    <label for="password_confirm">Repeat Password:</label>
                    <input type="password" id="password_confirm" name="password_confirm" required placeholder="Confirm your password">
                    <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('password_confirm', this)"></i>
                </div>

                <button type="submit">Sign Up</button>

                <button type="button" class="back-button" onclick="window.location.href='index.php'">Back</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(id, icon) {
            const passwordField = document.getElementById(id);
            const isPasswordVisible = passwordField.type === 'text';

            passwordField.type = isPasswordVisible ? 'password' : 'text';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>
