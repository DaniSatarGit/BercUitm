<?php
$mysqli = require __DIR__ . '/../databaseConnect.php';

$errors = [];
$success_message = '';
$tables = ['researcher', 'reviewer', 'secretariat', 'coordinator'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';
    $token = $_POST['token'] ?? '';

    // Validate new password
    if ($new_password === $confirm_new_password) {
        $token_found = false;

        foreach ($tables as $table) {
            $sql = "SELECT email FROM $table WHERE reset_token = ? AND token_expiry > NOW()";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $token_found = true;
                $email = $result->fetch_assoc()['email'];
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                $update_sql = "UPDATE $table SET password_hash = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?";
                $update_stmt = $mysqli->prepare($update_sql);
                $update_stmt->bind_param("ss", $new_password_hash, $email);

                if ($update_stmt->execute()) {
                    $success_message = "Password successfully reset!";
                } else {
                    $errors[] = "Failed to update the password.";
                }
                break;
            }
        }

        if (!$token_found && empty($errors)) {
            $errors[] = "Invalid or expired token.";
        }
    } else {
        $errors[] = "Passwords do not match.";
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="text-center">Reset Password</h2>
    <form action="reset_password.php" method="POST">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <div class="form-group">
            <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="confirm_new_password" placeholder="Confirm New Password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
    </form>

    <?php if ($success_message !== ''): ?>
        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>

    <?php
    // Display errors
    if (!empty($errors)) {
        echo '<div class="alert alert-danger mt-3">';
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '</div>';
    }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
