<?php
// Include the database configuration file
include '../config.php';

// Initialize variables for search and filter
$search = '';
$filterStatus = '';
$filterSupervisor = '';

// Handle search and filter input
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
if (isset($_GET['filterStatus'])) {
    $filterStatus = $_GET['filterStatus'];
}
if (isset($_GET['filterSupervisor'])) {
    $filterSupervisor = $_GET['filterSupervisor'];
}

// Build the base SQL query to fetch applications along with their assigned reviewer (if any)
$sql = "SELECT ca.id, ca.research_title, ca.researcher_name, ca.part_a_supervisor_name, ca.department_address, ca.status, 
               ra.reviewer_id, r.name AS reviewer_name
        FROM coordinator_application ca
        LEFT JOIN reviewer_application ra ON ca.id = ra.application_id
        LEFT JOIN reviewer r ON ra.reviewer_id = r.id
        WHERE 1=1";

// Add conditions dynamically
$params = [];
$types = '';

if (!empty($search)) {
    $sql .= " AND (ca.research_title LIKE ? OR ca.researcher_name LIKE ? OR ca.department_address LIKE ?)";
    $searchTerm = '%' . $search . '%';
    array_push($params, $searchTerm, $searchTerm, $searchTerm);
    $types .= 'sss';
}

if (!empty($filterStatus)) {
    $sql .= " AND ca.status = ?";
    $params[] = $filterStatus;
    $types .= 's';
}

if (!empty($filterSupervisor)) {
    $sql .= " AND ca.part_a_supervisor_name LIKE ?";
    $params[] = '%' . $filterSupervisor . '%';
    $types .= 's';
}

// Prepare the statement
$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Fetch all reviewers to populate the dropdown
$reviewersSql = "SELECT id, name FROM reviewer";
$reviewersResult = $conn->query($reviewersSql);
$reviewers = [];
while ($reviewer = $reviewersResult->fetch_assoc()) {
    $reviewers[] = $reviewer;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Assingg Reviewer Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f7f9fc;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Section */
        header {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: white;
            padding: 20px 30px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            font-size: 2rem;
            font-weight: 600;
        }

        header a {
            background-color: #ffcc00;
            color: #6a11cb;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        header a:hover {
            background-color: #ffd633;
        }

        /* Filter Section */
        .filter-section {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-section input,
        .filter-section select,
        .filter-section button {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .filter-section button {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            color: white;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .filter-section button:hover {
            transform: translateY(-2px);
            background: linear-gradient(90deg, #5e0db6, #1f63e8);
        }

        /* Table Section */
        .table-section {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #6a11cb;
            color: white;
            font-size: 1rem;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f4f6fc;
            cursor: pointer;
        }

        .status-select,
        .assign-reviewer-select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
        }

        .update-btn {
            background: linear-gradient(90deg, #ff5f6d, #ffc371);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .update-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .no-results {
            text-align: center;
            padding: 20px;
            font-size: 1.2rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Applicant Reviewer Management</h1>
            <a href="CoordinatorPage.php">Home</a>
        </header>

        <section class="filter-section">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by keyword..." value="<?= htmlspecialchars($search) ?>">
                <select name="filterStatus">
                    <option value="">Filter by Status</option>
                    <option value="Approved" <?= $filterStatus === 'Approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="Proceed to Coordinator" <?= $filterStatus === 'Proceed to Coordinator' ? 'selected' : '' ?>>Proceed to Coordinator</option>
                    <option value="Pending" <?= $filterStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                </select>
                <button type="submit"><i class="fas fa-filter"></i> Apply Filters</button>
            </form>
        </section>

        <section class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Research Title</th>
                        <th>Researcher Name</th>
                        <th>Supervisor Name</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Assigned Reviewer</th>
                        <th>Assign Reviewer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['research_title']) ?></td>
                                <td><?= htmlspecialchars($row['researcher_name']) ?></td>
                                <td><?= htmlspecialchars($row['part_a_supervisor_name']) ?></td>
                                <td><?= htmlspecialchars($row['department_address']) ?></td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                                <td><?= htmlspecialchars($row['reviewer_name'] ?? 'Not Assigned') ?></td>
                                <td>
                                    <select class="assign-reviewer-select" data-id="<?= $row['id']; ?>">
                                        <option value="">Select Reviewer</option>
                                        <?php foreach ($reviewers as $reviewer): ?>
                                            <option value="<?= $reviewer['id']; ?>" <?= $row['reviewer_id'] == $reviewer['id'] ? 'selected' : '' ?>><?= htmlspecialchars($reviewer['name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <button class="update-btn" data-id="<?= $row['id']; ?>">Assign Reviewer</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="no-results">No applications found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $('.update-btn').on('click', function() {
                const id = $(this).data('id');
                const reviewerId = $(this).closest('tr').find('.assign-reviewer-select').val();

                if (!reviewerId) {
                    alert('Please select a reviewer');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'assign_reviewer_application.php',
                    data: { id: id, reviewerId: reviewerId },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>
