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

// Fetch details from `berc4`
$query4 = "SELECT * FROM berc4 WHERE id = ?";
$stmt4 = $conn->prepare($query4);
$stmt4->bind_param("i", $id);
$stmt4->execute();
$result4 = $stmt4->get_result();
$details4 = $result4->fetch_assoc();


$query5 = "SELECT * FROM berc5ex WHERE id = ?";
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
        <h1>Exemption Details</h1>
        <a href="exemption.php">Back to Exemption Dashboard</a>
    </header>
    <div class="container">
        <div class="sidebar">
            <h2>PDF Sections</h2>
            <ul>
                <li><a href="javascript:void(0)" onclick="loadPDF('Exemption_pdf/berc4_pdf.php?id=<?= $id ?>')">BERC4 PDF</a></li>
                <li><a href="javascript:void(0)" onclick="loadPDF('Exemption_pdf/berc5_pdf.php?id=<?= $id ?>')">BERC5 PDF</a></li>
            </ul>
        </div>
        <div class="content">
            <h2>PDF Viewer</h2>
            <iframe id="pdf-frame" src="Exemption_pdf/berc4_pdf.php?id=<?= $id ?>"></iframe>
        </div>
    </div>
</body>
</html>
