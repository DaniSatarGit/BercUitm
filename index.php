<?php
session_start();
$is_invalid = false; // Initialize $is_invalid variable

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/databaseConnect.php";

    // Clean and match the role
    $submitted_role = trim($_POST["roles"]);
    $sql = "";

    // Determine the SQL query based on the selected role
    switch (strtolower($submitted_role)) {
        case "researcher":
            $sql = "SELECT * FROM researcher WHERE staffID = ? LIMIT 1";
            break;
        case "reviewer":
            $sql = "SELECT * FROM reviewer WHERE staffID = ? LIMIT 1";
            break;
        case "secretariat":
            $sql = "SELECT * FROM secretariat WHERE staffID = ? LIMIT 1";
            break;
        case "coordinator":
            $sql = "SELECT * FROM coordinator WHERE staffID = ? LIMIT 1";
            break;
        default:
            $is_invalid = "Invalid role selected.";
            break;
    }

    // Prepare and execute the SQL query to get the user
    if ($sql) {
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            die("SQL error: " . $mysqli->error);
        }

        $stmt->bind_param("s", $_POST["staffID"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check if the user exists and the password is correct
        if ($user && password_verify($_POST["password"], $user["password_hash"])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['staffID'] = $user['staffID'];
            $_SESSION['role'] = $submitted_role;

            // Set a session timeout (optional: 30 minutes)
            $_SESSION['last_activity'] = time();
            $_SESSION['expire_time'] = 1800; // 30 minutes

            // Redirect based on role
            switch ($submitted_role) {
                case "Researcher":
                    header("Location: Reseacher/ReseacherPage.php");
                    exit;
                case "Reviewer":
                    header("Location: Reviewer/ReviewerPage.php");
                    exit;
                case "Secretariat":
                    header("Location: Secetariat/secetariat.php");
                    exit;
                case "Coordinator":
                    header("Location: Coordinator/CoordinatorPage.php");
                    exit;
            }
        } else {
            // Invalid credentials
            $is_invalid = "Invalid Staff ID or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UiTM</title>
    <link rel="icon" href="image/IconRMU (1).ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

        /* Flexbox layout */
        .layout {
            display: flex;
            width: 90%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        /* UiTM-styled sidebar */
        .sidebar {
            width: 40%;
            background: linear-gradient(135deg, #54006e, #0d2f81); /* UiTM purple to blue gradient */
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .sidebar img {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        /* Main container for form */
        .container {
            width: 60%;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            box-sizing: border-box;
        }

        h1 {
            font-size: 24px;
            color: #54006e; /* UiTM primary purple color */
            font-weight: bold;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #555;
            font-weight: 600;
        }

        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            border-color: #54006e;
            outline: none;
            box-shadow: 0 0 5px rgba(84, 0, 110, 0.3);
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 44px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #54006e;
            font-size: 18px;
        }

        button {
            background: #54006e; /* UiTM purple */
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #3a0055; /* Darker UiTM purple for hover */
        }

        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .additional-links {
            margin-top: 20px;
        }

        .additional-links a {
            color: #0d2f81; /* UiTM blue */
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            margin-top: 8px;
        }

        .additional-links a:hover {
            text-decoration: underline;
        }

        /* Smaller button for "Sign up" */
        .signup-button {
            background: #0d2f81;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px; /* Smaller padding */
            font-size: 14px; /* Smaller font size */
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .signup-button:hover {
            background-color: #0a2366; /* Darker UiTM blue for hover */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
                align-items: center;
            }
            .sidebar, .container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <!-- Sidebar with UiTM colors and logo -->
        <div class="sidebar">
            <div>
                <img src="image/Uitm.png" alt="UiTM Logo">
                <h2>Welcome to RMU UiTM</h2>
                <p>Driving Innovation, Empowering Research.</p>
            </div>
        </div>
        
        <!-- Main content area for login form -->
        <div class="container">
            <h1>Login</h1>
            <?php if ($is_invalid): ?>
                <p class="error-message"><?php echo htmlspecialchars($is_invalid); ?></p>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="staffID">Staff ID/Student ID:</label>
                    <input type="text" name="staffID" id="staffID" value="<?php echo htmlspecialchars($_POST["staffID"] ?? "") ?>" required placeholder="Enter your staff ID">
                </div>
                <div class="form-group password-container">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required placeholder="Enter your password">
                    <i class="fas fa-eye-slash toggle-password" onclick="togglePassword('password', this)"></i>
                </div>
                <div class="form-group">
                    <label for="roles">Select Role:</label>
                    <select class="form-control" id="roles" name="roles" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="Researcher">Researcher</option>
                        <option value="Reviewer">Reviewer</option>
                        <option value="Secretariat">Secretariat</option>
                        <option value="Coordinator">Coordinator</option>
                    </select>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="additional-links">
                <form action="./SignUp.php" method="get" style="display: inline;">
                    <button type="submit" class="signup-button">
                        Sign up as Researcher
                    </button>
                </form>
                <a href="forgotpassword.php">Forgot your password?</a><br>
                <a href="adminPage.php">Admin</a>
            </div>
        </div>
    </div>
    <script>
        function togglePassword(id, icon) {
            const passwordField = document.getElementById(id);
            const isPasswordVisible = passwordField.type === 'text';
            passwordField.type = isPasswordVisible ? 'password' : 'text';
            icon.classList.toggle('fa-eye', !isPasswordVisible);
            icon.classList.toggle('fa-eye-slash', isPasswordVisible);
        }
    </script>
</body>
</html>
