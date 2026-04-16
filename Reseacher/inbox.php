<?php
session_start();

// Include the database connection
include '../config.php'; // Include the connection from db_connection.php

// Get the current user's ID
$user_id = $_SESSION['user_id'];

// Fetch submitted forms
$sql_berc1 = "SELECT * FROM berc1 WHERE user_id = ?";
$stmt_berc1 = $conn->prepare($sql_berc1);
$stmt_berc1->bind_param("s", $user_id);
$stmt_berc1->execute();
$result_berc1 = $stmt_berc1->get_result();

$sql_berc2 = "SELECT * FROM berc2 WHERE user_id = ?";
$stmt_berc2 = $conn->prepare($sql_berc2);
$stmt_berc2->bind_param("s", $user_id);
$stmt_berc2->execute();
$result_berc2 = $stmt_berc2->get_result();

// Fetch BERC3 and BERC5 similarly
$sql_berc3 = "SELECT * FROM berc3 WHERE user_id = ?";
$stmt_berc3 = $conn->prepare($sql_berc3);
$stmt_berc3->bind_param("s", $user_id);
$stmt_berc3->execute();
$result_berc3 = $stmt_berc3->get_result();

$sql_berc5 = "SELECT * FROM berc5 WHERE user_id = ?";
$stmt_berc5 = $conn->prepare($sql_berc5);
$stmt_berc5->bind_param("s", $user_id);
$stmt_berc5->execute();
$result_berc5 = $stmt_berc5->get_result();

$sql_berc4 = "SELECT * FROM berc4 WHERE user_id = ?";
$stmt_berc4 = $conn->prepare($sql_berc4);
$stmt_berc4->bind_param("s", $user_id);
$stmt_berc4->execute();
$result_berc4 = $stmt_berc4->get_result();

$sql_berc6 = "SELECT * FROM berc5ex WHERE user_id = ?";
$stmt_berc6 = $conn->prepare($sql_berc6);
$stmt_berc6->bind_param("s", $user_id);
$stmt_berc6->execute();
$result_berc6 = $stmt_berc6->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Researcher Inbox & History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .message-list-item {
            cursor: pointer;
        }
        .message-list-item:hover {
            background-color: #f0f0f0;
        }
        .unread-message {
            font-weight: bold;
        }
        .message-content {
            border-left: 3px solid #007bff;
        }
        .no-message-selected {
            text-align: center;
            margin-top: 50px;
            color: #999;
        }
        .message-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .back-button-container {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <!-- Sidebar for Messages List -->
        <div class="col-md-4">
            <h4>Inbox</h4>

            <div class="list-group">
                <!-- Display BERC1 submissions -->
                <?php while ($row = $result_berc1->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action message-list-item" onclick="loadMessage('berc1', <?php echo $row['id']; ?>)">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">BERC1 Submission</h6>
                            <small class="text-muted">Form ID: <?php echo $row['id']; ?></small>
                        </div>
                        <p class="mb-1">Your BERC1 form has been successfully submitted.</p>
                    </a>
                <?php endwhile; ?>

                <!-- Display BERC2 submissions -->
                <?php while ($row = $result_berc2->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action message-list-item" onclick="loadMessage('berc2', <?php echo $row['id']; ?>)">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">BERC2 Submission</h6>
                            <small class="text-muted">Form ID: <?php echo $row['id']; ?></small>
                        </div>
                        <p class="mb-1">Your BERC2 form has been successfully submitted.</p>
                    </a>
                <?php endwhile; ?>

                <!-- Display BERC3 submissions -->
                <?php while ($row = $result_berc3->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action message-list-item" onclick="loadMessage('berc3', <?php echo $row['id']; ?>)">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">BERC3 Submission</h6>
                            <small class="text-muted">Form ID: <?php echo $row['id']; ?></small>
                        </div>
                        <p class="mb-1">Your BERC3 form has been successfully submitted.</p>
                    </a>
                <?php endwhile; ?>

                <!-- Display BERC5 submissions -->
                <?php while ($row = $result_berc5->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action message-list-item" onclick="loadMessage('berc5', <?php echo $row['id']; ?>)">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">BERC5 Submission</h6>
                            <small class="text-muted">Form ID: <?php echo $row['id']; ?></small>
                        </div>
                        <p class="mb-1">Your BERC5 form has been successfully submitted.</p>
                    </a>
                <?php endwhile; ?>

                <!-- Display BERC4 submissions -->
                <?php while ($row = $result_berc4->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action message-list-item" onclick="loadMessage('berc4', <?php echo $row['id']; ?>)">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">BERC4 (Exemption) Submission</h6>
                            <small class="text-muted">Form ID: <?php echo $row['id']; ?></small>
                        </div>
                        <p class="mb-1">Your BERC4 (Exemption) form has been successfully submitted.</p>
                    </a>
                <?php endwhile; ?>

                <!-- Display BERC5EX submissions -->
                <?php while ($row = $result_berc6->fetch_assoc()): ?>
                    <a href="#" class="list-group-item list-group-item-action message-list-item" onclick="loadMessage('berc5ex', <?php echo $row['id']; ?>)">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">BERC5 (Exemption) Submission</h6>
                            <small class="text-muted">Form ID: <?php echo $row['id']; ?></small>
                        </div>
                        <p class="mb-1">Your BERC5 (Exemption) form has been successfully submitted.</p>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
        <!-- Main Content for Viewing Messages or History -->
        <div class="col-md-8">
            <div id="message-content" class="message-content p-3 bg-white">
                <div class="no-message-selected">
                    <h5>No message selected</h5>
                    <p>Select a message from your inbox or history to view its content</p>
                </div>
            </div>
            <div class="back-button-container">
                <a href="ReseacherPage.php" class="btn btn-primary">Back to Main Page</a>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript function to load a simple message
    function loadMessage(formType, formId) {
        let messageContent = document.getElementById('message-content');
        messageContent.innerHTML = ''; // Clear previous content

        let message = '';
        if (formType === 'berc1') {
            message = `<h5>BERC1 Submission</h5>
                        <p>Your BERC1 form with Form ID: ${formId} has been successfully submitted and is being processed.</p>`;
            message += `<div class="message-actions">
                            <a href='Berc/Berc1_pdf.php?form_id=${formId}' class='btn btn-success'>Download PDF</a>
                            <button class="btn btn-secondary" onclick="closeMessage()">Close</button>
                        </div>`;
        } else if (formType === 'berc2') {
            message = `<h5>BERC2 Submission</h5>
                        <p>Your BERC2 form with Form ID: ${formId} has been successfully submitted and is being processed.</p>`;
            message += `<div class="message-actions">
                            <a href='Berc/Berc2_pdf.php?form_id=${formId}' class='btn btn-success'>Download PDF</a>
                            <button class="btn btn-secondary" onclick="closeMessage()">Close</button>
                        </div>`;
        } else if (formType === 'berc3') {
            message = `<h5>BERC3 Submission</h5>
                        <p>Your BERC3 form with Form ID: ${formId} has been successfully submitted and is being processed.</p>`;
            message += `<div class="message-actions">
                            <a href='Berc/Berc3_pdf.php?form_id=${formId}' class='btn btn-success'>Download PDF</a>
                            <button class="btn btn-secondary" onclick="closeMessage()">Close</button>
                        </div>`;
        } else if (formType === 'berc4') {
            message = `<h5>BERC4 (Exemption) Submission</h5>
                    <p>Your BERC4 form with Form ID: ${formId} has been successfully submitted and is being processed.</p>`;
            message += `<div class="message-actions">
                            <a href='Exemption/Berc4_pdf.php?form_id=${formId}' class='btn btn-success'>Download PDF</a>
                            <button class="btn btn-secondary" onclick="closeMessage()">Close</button>
                        </div>`;
        } else if (formType === 'berc5') {
            message = `<h5>BERC5 Submission</h5>
                        <p>Your BERC5 form with Form ID: ${formId} has been successfully submitted and is being processed.</p>`;
            message += `<div class="message-actions">
                            <a href='Berc/Berc5_pdf.php?form_id=${formId}' class='btn btn-success'>Download PDF</a>
                            <button class="btn btn-secondary" onclick="closeMessage()">Close</button>
                        </div>`;
        } else if (formType === 'berc5ex') {
            message = `<h5>BERC5 (Exemption) Submission</h5>
                        <p>Your BERC5 (Exemption) form with Form ID: ${formId} has been successfully submitted and is being processed.</p>`;
            message += `<div class="message-actions">
                            <a href='Exemption/Berc5_pdf.php?form_id=${formId}' class='btn btn-success'>Download PDF</a>
                            <button class="btn btn-secondary" onclick="closeMessage()">Close</button>
                        </div>`;
        }

        messageContent.innerHTML = message;
    }

    // JavaScript function to close the message content
    function closeMessage() {
        let messageContent = document.getElementById('message-content');
        messageContent.innerHTML = `<div class="no-message-selected">
                                        <h5>No message selected</h5>
                                        <p>Select a message from your inbox or history to view its content</p>
                                    </div>`;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
