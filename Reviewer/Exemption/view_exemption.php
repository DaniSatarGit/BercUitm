<?php
include '../../config.php'; // Database configuration file

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the Exemption ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid exemption ID.");
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
    <title>View Exemption</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Global styles */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Header styles */
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
            margin-top: 50px;
            max-width: 1200px;
            display: flex;
            justify-content: space-between; /* To align the columns side by side */
        }

        /* Left column for PDF viewer */
        .pdf-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            margin-right: 20px; /* To add some space between the columns */
        }

        /* Right column for comments */
        .comments-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card {
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* PDF viewer section */
        .pdf-section iframe {
            width: 100%; /* Set width to 100% to fill the container */
            height: 80vh; /* Set height to 80% of the viewport height to make it large */
            border: none;
            border-radius: 5px;
        }

        /* Comment card section */
        .comment-section {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Button group styles */
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

    </style>
    <script>
        // Function to load the PDF into the iframe
        function loadPDF(url) {
            document.getElementById('pdf-frame').src = url;
        }
    </script>
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Exemption Details</h1>
        <a href="exemption.php">Back to Applications</a>
    </header>

    <!-- Main Content Container -->
    <div class="container">
        <!-- Left Column: PDF Viewer -->
        <div class="pdf-column">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">View PDF</h5>
                    <div class="btn-group mt-3">
                        <!-- Load BERC4 PDF -->
                        <a href="javascript:void(0)" onclick="loadPDF('Exemption_pdf/berc4_pdf.php?id=<?= htmlspecialchars($id) ?>')">BERC4 PDF</a>
                        <!-- Load BERC5 PDF -->
                        <a href="javascript:void(0)" onclick="loadPDF('Exemption_pdf/berc5_pdf.php?id=<?= htmlspecialchars($id) ?>')">BERC5 PDF</a>
                    </div>
                    <!-- PDF Display Section -->
                    <div class="pdf-section mt-4">
                        <iframe id="pdf-frame" src="Exemption_pdf/berc4_pdf.php?id=<?= $id ?>" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Comments Section -->
        <div class="comments-column">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Comments</h5>
                    <div class="comment-section">
                        <?php 
                            // Including the Berc9N.php file for comments
                            include 'berc9EN.php'; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
