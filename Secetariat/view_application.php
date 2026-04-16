<?php
include '../config.php'; // Database configuration file

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the application ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid application ID.");
}

// Fetch details from `berc1`
$query1 = "SELECT * FROM berc1 WHERE id = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $id);
$stmt1->execute();
$result1 = $stmt1->get_result();
$details1 = $result1->fetch_assoc();

// Fetch details from other tables
$query2 = "SELECT * FROM berc2 WHERE id = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$details2 = $result2->fetch_assoc();

$query3 = "SELECT * FROM berc3 WHERE id = ?";
$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("i", $id);
$stmt3->execute();
$result3 = $stmt3->get_result();
$details3 = $result3->fetch_assoc();

$query5 = "SELECT * FROM berc5 WHERE id = ?";
$stmt5 = $conn->prepare($query5);
$stmt5->bind_param("i", $id);
$stmt5->execute();
$result5 = $stmt5->get_result();
$details5 = $result5->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        header a {
            text-decoration: none;
            color: #fff;
            background-color: #660066;
            padding: 10px 15px;
            border-radius: 5px;
        }
        header a:hover {
            background-color: #880088;
        }
        .container {
            display: flex;
            gap: 20px;
        }
        .sidebar {
            width: 25%;
            border-right: 1px solid #ddd;
            padding: 10px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 10px 0;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #660066;
            font-weight: bold;
        }
        .sidebar ul li a:hover {
            text-decoration: underline;
        }
        .content {
            width: 75%;
        }
        iframe {
            width: 100%;
            height: 600px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
    <script>
        function loadPDF(url) {
            document.getElementById('pdf-frame').src = url;
        }
    </script>
</head>
<body>
    <header>
        <h1>Application Details</h1>
        <a href="application.php">Back to Applications</a>
    </header>
    <div class="container">
        <div class="sidebar">
            <h2>PDF Sections</h2>
            <ul>
                <li><a href="javascript:void(0)" onclick="loadPDF('Application_pdf/berc1_pdf.php?id=<?= $id ?>')">BERC1 PDF</a></li>
                <li><a href="javascript:void(0)" onclick="loadPDF('Application_pdf/berc2_pdf.php?id=<?= $id ?>')">BERC2 PDF</a></li>
                <li><a href="javascript:void(0)" onclick="loadPDF('Application_pdf/berc3_pdf.php?id=<?= $id ?>')">BERC3 PDF</a></li>
                <li><a href="javascript:void(0)" onclick="loadPDF('Application_pdf/berc5_pdf.php?id=<?= $id ?>')">BERC5 PDF</a></li>
            </ul>
        </div>
        <div class="content">
            <h2>PDF Viewer</h2>
            <iframe id="pdf-frame" src="Application_pdf/berc1_pdf.php?id=<?= $id ?>"></iframe>
        </div>
    </div>
</body>
</html>
