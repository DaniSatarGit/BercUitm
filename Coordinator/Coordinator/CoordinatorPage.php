<?php
// Start the session
session_start();
include("../config.php");

// Set default type if not set
$_GET['type'] = $_GET['type'] ?? 'berc'; // Default to 'berc' when logging in

// Initialize the query components
$whereClauses = [];
$orderBy = "submission_date DESC"; 
$limit = 10; 
$page = (int) ($_GET['page'] ?? 1);
$offset = ($page - 1) * $limit;

// Determine table and columns based on the type
$table = 'berc1'; 
$columns = 'b.research_title, b.researcher_name, b.department_address, b.submission_date, 
            IF(a.research_title IS NOT NULL, "Approved", "Pending") AS status';
$joinCondition = 'b.research_title = a.research_title'; 

if ($_GET['type'] === 'exemption') {
    $table = 'berc4ex'; 
    $columns = 'b.title AS research_title, b.researcher_name, b.dept_address AS department_address, 
                b.submission_date, 
                IF(b.app_id IS NOT NULL, "Approved", "Pending") AS status'; 
    $joinCondition = 'b.title = a.research_title'; 
}

// Handle filter
if (isset($_GET['filter_registration'])) {
    $filter_registration = $conn->real_escape_string($_GET['filter_registration']);
    if ($filter_registration === 'registered') {
        $whereClauses[] = "a.research_title IS NOT NULL";
    } elseif ($filter_registration === 'not_registered') {
        $whereClauses[] = "a.research_title IS NULL";
    }
}

$whereSql = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';
$query = "
    SELECT $columns
    FROM $table b
    LEFT JOIN approved a ON $joinCondition
    $whereSql
    ORDER BY $orderBy
    LIMIT $limit OFFSET $offset";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Count total records for pagination
$totalQuery = "SELECT COUNT(*) as total FROM $table b LEFT JOIN approved a ON $joinCondition $whereSql";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch the list of reviewers
$reviewersQuery = "SELECT staffID, name FROM reviewer";
$reviewersResult = mysqli_query($conn, $reviewersQuery);
$reviewers = [];
if ($reviewersResult) {
    while ($reviewer = mysqli_fetch_assoc($reviewersResult)) {
        $reviewers[] = $reviewer;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .sidebar {
            background-color: #731358;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar a {
            color: white;
        }
        .sidebar a.active {
            background-color: #9C4183;
            color: white;
        }
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <br><br>
                <h2>Menu</h2>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= isset($_GET['type']) && $_GET['type'] === 'berc' ? 'active' : ''; ?>" href="?type=berc">BERC Application</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isset($_GET['type']) && $_GET['type'] === 'exemption' ? 'active' : ''; ?>" href="?type=exemption">Exemption Application</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <nav class="navbar navbar-light bg-light fixed-top">
                    <div class="container-fluid">
                        <img src="image/Uitm.png" alt="Logo" style="max-width: 70px;">
                        <span class="navbar-text"><?= isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest'; ?></span>
                        <button class="btn btn-warning" onclick="openModal()">Logout</button>
                    </div>
                </nav>

                <div class="main-content" style="margin-top: 70px;">
                    <!-- Messages -->
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo "<div class='alert alert-success' id='statusMessage'>" . $_SESSION['message'] . "</div>";
                        unset($_SESSION['message']);
                    }
                    if (isset($_SESSION['error'])) {
                        echo "<div class='alert alert-danger' id='errorMessage'>" . $_SESSION['error'] . "</div>";
                        unset($_SESSION['error']);
                    }
                    ?>

                    <script>
                        // Hide the message after 5 seconds
                        setTimeout(() => {
                            const successMessage = document.getElementById('statusMessage');
                            const errorMessage = document.getElementById('errorMessage');
                            if (successMessage) successMessage.style.display = 'none';
                            if (errorMessage) errorMessage.style.display = 'none';
                        }, 5000);

                        function updateStatus(event, researchTitle) {
                            event.preventDefault();
                            const formData = new FormData(event.target);
                            fetch('change_status.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.text())
                            .then(data => console.log(data))
                            .catch(error => console.error('Error:', error));
                        }
                    </script>

                    <!-- Search and Filter -->
                    <div class="search-bar container">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <form class="d-flex" method="GET" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input class="form-control me-2" type="search" name="search" placeholder="Search by name or project title" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </form>
                            </div>
                            <div class="col-auto">
                                <form class="d-flex" method="GET" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <select class="form-select" name="filter_registration">
                                        <option value="">All Status</option>
                                        <option value="registered" <?= (isset($_GET['filter_registration']) && $_GET['filter_registration'] === 'registered') ? 'selected' : ''; ?>>Approved</option>
                                        <option value="not_registered" <?= (isset($_GET['filter_registration']) && $_GET['filter_registration'] === 'not_registered') ? 'selected' : ''; ?>>Pending</option>
                                    </select>
                                    <button class="btn btn-primary ms-2" type="submit">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-container container">
                        <div class="table-title"><strong>Project Applications</strong></div>
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Research Title</th>
                                    <th>Researcher Name</th>
                                    <th>Department Address</th>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                    <th>Assign Reviewer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                        <td>" . $no++ . "</td>
                                        <td>" . htmlspecialchars($row['research_title']) . "</td>
                                        <td>" . htmlspecialchars($row['researcher_name']) . "</td>
                                        <td>" . htmlspecialchars($row['department_address']) . "</td>
                                        <td>" . htmlspecialchars($row['submission_date']) . "</td>
                                        <td>" . htmlspecialchars($row['status']) . "</td>
                                        <td>
                                            <form method='POST' action='assign_reviewer.php'>
                                                <input type='hidden' name='research_title' value='" . htmlspecialchars($row['research_title']) . "'>
                                                <select name='reviewer_id' required>
                                                    <option value=''>Select Reviewer</option>";
                                                    foreach ($reviewers as $reviewer) {
                                                        echo "<option value='" . htmlspecialchars($reviewer['staffID']) . "'>" . htmlspecialchars($reviewer['name']) . "</option>";
                                                    }
                                    echo "  </select>
                                                <button type='submit' class='btn btn-success'>Assign</button>
                                            </form>
                                        </td>
                                        <td><a href='view.php?research_title=" . urlencode($row['research_title']) . "' class='btn btn-info'>View</a></td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?= "?page=" . ($page - 1) . "&type=" . htmlspecialchars($_GET['type']); ?>">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : ''; ?>">
                                    <a class="page-link" href="<?= "?page=$i&type=" . htmlspecialchars($_GET['type']); ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?= "?page=" . ($page + 1) . "&type=" . htmlspecialchars($_GET['type']); ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to logout?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="logout.php" class="btn btn-primary">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                function openModal() {
                    var myModal = new bootstrap.Modal(document.getElementById('logoutModal'));
                    myModal.show();
                }
            </script>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
