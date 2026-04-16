<?php
include '../../config.php'; // Database configuration file

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
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
        iframe {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 5px;
        }
        .btn-group a {
            margin: 5px;
            text-decoration: none;
            color: #fff;
            background-color: #660066;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
        }
        .btn-group a:hover {
            background-color: #880088;
        }

        /* Full-page layout */
        .container {
            display: flex;
            height: 100vh; /* Full height of the viewport */
            padding: 10px;
            gap: 15px;
        }

        /* Left column for PDF viewer */
        .pdf-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Right column for comments */
        .comments-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-body {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .pdf-section, .comment-section {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
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
        <!-- Left column for PDF viewer -->
        <div class="pdf-column">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">View PDF</h5>
                    <div class="btn-group mt-3">
                        <a href="javascript:void(0)" onclick="loadPDF('Application_pdf/berc1_pdf.php?id=<?= htmlspecialchars($id) ?>')">BERC1 PDF</a>
                        <a href="javascript:void(0)" onclick="loadPDF('Application_pdf/berc2_pdf.php?id=<?= htmlspecialchars($id) ?>')">BERC2 PDF</a>
                        <a href="javascript:void(0)" onclick="loadPDF('Application_pdf/berc3_pdf.php?id=<?= htmlspecialchars($id) ?>')">BERC3 PDF</a>
                        <a href="javascript:void(0)" onclick="loadPDF('Application_pdf/berc5_pdf.php?id=<?= htmlspecialchars($id) ?>')">BERC5 PDF</a>
                    </div>
                    <div class="pdf-section mt-4">
                        <iframe id="pdf-frame" src="Application_pdf/berc1_pdf.php?id=<?= $id ?>" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right column for comments -->
        <div class="comments-column">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Comments</h5>
                    <div class="comment-section">
                        <?php 
                            // Include the content of Berc9N.php here
                            include 'berc9N.php'; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
