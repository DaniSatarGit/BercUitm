<?php
// Start the session
session_start();
include("../config.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Get the type (application or exemption) and research title from the URL
    $type = $_GET['type'] ?? 'application';
    $research_title = $_GET['research_title'] ?? '';

    if (empty($research_title)) {
        throw new Exception("Invalid request: Research title is required.");
    }

    // Initialize variables
    $details = [];
    $pdfLinks = [];

    // Fetch details based on the type
    if ($type === 'application') {
        $query = "
            SELECT b.research_title, b.researcher_name, b.part_a_supervisor_name AS supervisor_name,
                   b.department_address, b.submission_date, a.status
            FROM berc1 b
            LEFT JOIN approved_application a ON b.research_title = a.research_title
            WHERE b.research_title = ?";
        $pdfLinks = [
            'Berc1' => "uploads/Berc1_{$research_title}.pdf",
            'Berc2' => "uploads/Berc2_{$research_title}.pdf",
            'Berc3' => "uploads/Berc3_{$research_title}.pdf",
            'Berc5' => "uploads/Berc5_{$research_title}.pdf",
        ];
    } elseif ($type === 'exemption') {
        $query = "
            SELECT b.research_title, b.researcher_name, b.supervisor_name,
                   b.dept_address AS department_address, b.submission_date, a.status
            FROM berc4 b
            LEFT JOIN approved_exemption a ON b.research_title = a.research_title
            WHERE b.research_title = ?";
        $pdfLinks = [
            'Berc4' => "uploads/Berc4_{$research_title}.pdf",
            'Berc5e' => "uploads/Berc5e_{$research_title}.pdf",
        ];
    } else {
        throw new Exception("Invalid type specified.");
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $research_title);
    $stmt->execute();
    $result = $stmt->get_result();

    $details = $result->fetch_assoc();

    if (!$details) {
        throw new Exception("No details found for the specified research title.");
    }

    // Handle form submission to update the status
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
        $newStatus = $_POST['status'];
        $updateQuery = "";

        // Determine the table based on the type
        if ($type === 'application') {
            $updateQuery = "UPDATE approved_application SET status = ? WHERE research_title = ?";
        } elseif ($type === 'exemption') {
            $updateQuery = "UPDATE approved_exemption SET status = ? WHERE research_title = ?";
        }

        if ($updateQuery) {
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ss", $newStatus, $research_title);
            $updateStmt->execute();
            $updateStmt->close();

            // Redirect to avoid form resubmission on page refresh
            header("Location: view_details.php?type={$type}&research_title=" . urlencode($research_title));
            exit();
        }
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Details - <?= htmlspecialchars($details['research_title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .pdf-section iframe {
            width: 100%;
            height: 600px;
            border: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Details for <?= htmlspecialchars($details['research_title']) ?></h2>
        <table class="table table-bordered">
            <tr><th>Research Title</th><td><?= htmlspecialchars($details['research_title']) ?></td></tr>
            <tr><th>Researcher Name</th><td><?= htmlspecialchars($details['researcher_name']) ?></td></tr>
            <tr><th>Supervisor Name</th><td><?= htmlspecialchars($details['supervisor_name']) ?></td></tr>
            <tr><th>Department Address</th><td><?= htmlspecialchars($details['department_address']) ?></td></tr>
            <tr><th>Submission Date</th><td><?= htmlspecialchars($details['submission_date']) ?></td></tr>
            <tr><th>Status</th>
                <td>
                    <form id="statusForm" method="post" action="">
                        <select name="status" class="form-select" required>
                            <option value="approved" <?= $details['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="pending" <?= $details['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="rejected" <?= $details['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Save</button>
                    </form>
                </td>
            </tr>
        </table>


        <!-- Two-column layout for PDF viewer and comments form -->
        <div class="row">
            <!-- Left column for PDF viewer -->
            <div class="col-md-7 d-flex flex-column">
                <div class="card flex-grow-1" style="height: 800px;">
                    <div class="card-body text-center">
                        <h5 class="card-title">View PDF</h5>
                        <div class="btn-group mt-3">
                            <?php if ($type === 'exemption'): ?>
                                <a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="showPDF('<?= htmlspecialchars($pdfLinks['Berc4']) ?>')">BERC4</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="showPDF('<?= htmlspecialchars($pdfLinks['Berc5e']) ?>')">BERC5e</a>
                            <?php else: ?>
                                <a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="showPDF('<?= htmlspecialchars($pdfLinks['Berc1']) ?>')">BERC1</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="showPDF('<?= htmlspecialchars($pdfLinks['Berc2']) ?>')">BERC2</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="showPDF('<?= htmlspecialchars($pdfLinks['Berc3']) ?>')">BERC3</a>
                                <a href="javascript:void(0);" class="btn btn-success btn-lg" onclick="showPDF('<?= htmlspecialchars($pdfLinks['Berc5']) ?>')">BERC5</a>
                            <?php endif; ?>
                        </div>
                        <div class="pdf-section mt-4">
                            <iframe id="pdfViewer" src="<?= $type === 'exemption' ? htmlspecialchars($pdfLinks['Berc4']) : htmlspecialchars($pdfLinks['Berc1']) ?>" frameborder="0" style="width: 100%; height: 700px;"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column for comments -->
            <div class="col-md-5 d-flex flex-column">
                <div class="card flex-grow-1" style="height: 800px;">
                    <div class="card-body">
                        <h5 class="card-title text-center">Comments</h5>
                        <div class="comment-section">
                            <?php
                                if ($type === 'exemption') {
                                    include('Berc9E.php');
                                } else {
                                    include('Berc9N.php');
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="dashboard.php?type=<?= htmlspecialchars($type) ?>" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script>
        function showPDF(pdfUrl) {
            document.getElementById('pdfViewer').src = pdfUrl;
        }
    </script>
</body>
</html>

<?php
if (isset($stmt)) $stmt->close();
if (isset($conn)) $conn->close();
?>
