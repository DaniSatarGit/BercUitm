<?php
// Load Composer's autoloader when PHPMailer is available.
$autoload_paths = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/vendor/autoload.php',
];

foreach ($autoload_paths as $autoload_path) {
    if (file_exists($autoload_path)) {
        require_once $autoload_path;
        break;
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mysqli = require __DIR__ . '/../databaseConnect.php';

$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Check if user exists in all tables
    $tables = ['researcher', 'reviewer', 'secretariat', 'coordinator'];
    $userFound = false;

    if (empty($errors)) {
        foreach ($tables as $table) {
            $sql = "SELECT staffID FROM $table WHERE email = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $userFound = true;
                $token = bin2hex(random_bytes(16));
                $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

                // Store the token in the respective table
                $update_sql = "UPDATE $table SET reset_token = ?, token_expiry = ? WHERE email = ?";
                $update_stmt = $mysqli->prepare($update_sql);
                $update_stmt->bind_param("sss", $token, $expiry, $email);

                if (!$update_stmt->execute()) {
                    $errors[] = "Failed to save the reset token.";
                    break;
                }

                $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
                $base_path = rtrim(dirname($_SERVER['PHP_SELF'] ?? '/forgotPass/request_reset.php'), '/\\');
                $reset_link = $scheme . '://' . $host . $base_path . '/reset_password.php?token=' . urlencode($token);

                if (class_exists(PHPMailer::class)) {
                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'your_email@gmail.com';
                        $mail->Password = 'your_password';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->setFrom('your_email@gmail.com', 'Mailer');
                        $mail->addAddress($email);
                        $mail->isHTML(true);
                        $mail->Subject = 'Password Reset';
                        $mail->Body = "Click this link to reset your password: <a href='$reset_link'>$reset_link</a>";
                        $mail->send();
                        $success_message = "Reset link sent to your email.";
                    } catch (Exception $e) {
                        $errors[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    $headers = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                    $headers .= "From: no-reply@localhost\r\n";

                    $subject = 'Password Reset';
                    $message = "Click this link to reset your password: <a href='$reset_link'>$reset_link</a>";

                    if (mail($email, $subject, $message, $headers)) {
                        $success_message = "Reset link sent to your email.";
                    } else {
                        $errors[] = "Reset token was created, but the email could not be sent from this server.";
                    }
                }

                if (!empty($success_message) || !empty($errors)) {
                    break;
                }
            }
        }
    }

    if (!$userFound && empty($errors)) {
        $errors[] = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="text-center">Request Password Reset</h2>
    <form action="request_reset.php" method="POST">
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Request Reset</button>
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
