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

$table = $type;
$user = null;

$stmt = $conn->prepare("SELECT * FROM $table WHERE staffID = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "User not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $stmt = $conn->prepare("UPDATE $table SET name = ?, email = ? WHERE staffID = ?");
    $stmt->bind_param("sss", $name, $email, $id);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href='../admin.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit User</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Update User</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
