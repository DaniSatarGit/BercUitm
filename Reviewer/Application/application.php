<?php
session_start();

// Ensure the user is logged in and is a reviewer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Reviewer') {
    header('Location: ../../index.php');
    exit();
}

include '../../config.php';

$reviewer_id = $_SESSION['user_id'];

// Fetch assigned applications
$sql = "SELECT ca.id, ca.research_title, ca.researcher_name, ca.part_a_supervisor_name, ca.department_address, ca.status
        FROM coordinator_application ca
        JOIN reviewer_application ra ON ca.id = ra.application_id
        WHERE ra.reviewer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $reviewer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Applications</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background: #54006e;
            color: white;
        }
        tr:hover {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Assigned Applications</h1>
        <a href="../ReviewerPage.php">Home</a>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Research Title</th>
                        <th>Researcher Name</th>
                        <th>Supervisor Name</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>View</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['research_title']) ?></td>
                            <td><?= htmlspecialchars($row['researcher_name']) ?></td>
                            <td><?= htmlspecialchars($row['part_a_supervisor_name']) ?></td>
                            <td><?= htmlspecialchars($row['department_address']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><a href="view_application.php?id=<?= htmlspecialchars($row['id']) ?>" class="view-btn">View</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No applications assigned to you.</p>
        <?php endif; ?>
    </div>
</body>
</html>
