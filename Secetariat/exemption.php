<?php
// Include the database configuration file
include '../config.php';

// Check database connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Handle AJAX request for updating the status
if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = (int) $_POST['id'];
    $status = $_POST['status'];

    // Update the status column in the berc4 table
    $updateStatusQuery = "UPDATE berc4 SET status = ? WHERE id = ?";
    $updateStatusStmt = $conn->prepare($updateStatusQuery);
    if (!$updateStatusStmt) {
        echo json_encode(["error" => "Error in preparing update query: " . $conn->error]);
        exit;
    }
    $updateStatusStmt->bind_param("si", $status, $id);
    if (!$updateStatusStmt->execute()) {
        echo json_encode(["error" => "Error in updating status: " . $updateStatusStmt->error]);
        exit;
    }

    // Fetch the application data from the 'berc4' table
    $fetchQuery = "SELECT id, research_title, researcher_name, supervisor_name, dept_address FROM berc4 WHERE id = ?";
    $fetchStmt = $conn->prepare($fetchQuery);
    if (!$fetchStmt) {
        echo json_encode(["error" => "Error in preparing fetch query: " . $conn->error]);
        exit;
    }
    $fetchStmt->bind_param("i", $id);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        if ($status === 'Approved') {
            // Delete from 'coordinator_exemption' if exists
            $deleteCoordinatorQuery = "DELETE FROM coordinator_exemption WHERE id = ?";
            $deleteCoordinatorStmt = $conn->prepare($deleteCoordinatorQuery);
            $deleteCoordinatorStmt->bind_param("i", $id);
            $deleteCoordinatorStmt->execute();

            // Insert into 'approved_exemption' table
            $insertQuery = "INSERT INTO approved_exemption (id, research_title, researcher_name, supervisor_name, dept_address, submission_date, status)
                            VALUES (?, ?, ?, ?, ?, NOW(), 'approved')
                            ON DUPLICATE KEY UPDATE research_title = VALUES(research_title), researcher_name = VALUES(researcher_name), 
                            supervisor_name = VALUES(supervisor_name), dept_address = VALUES(dept_address), submission_date = NOW(), status = 'approved'";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("issss", $row['id'], $row['research_title'], $row['researcher_name'], $row['supervisor_name'], $row['dept_address']);
            $insertStmt->execute();

            echo json_encode(["message" => "Successfully updated to Approved."]);
        } elseif ($status === 'Proceed to Coordinator') {
            // Delete from 'approved_exemption' if exists
            $deleteApprovedQuery = "DELETE FROM approved_exemption WHERE id = ?";
            $deleteApprovedStmt = $conn->prepare($deleteApprovedQuery);
            $deleteApprovedStmt->bind_param("i", $id);
            $deleteApprovedStmt->execute();

            // Insert into 'coordinator_exemption' table
            $insertQuery = "INSERT INTO coordinator_exemption (id, research_title, researcher_name, supervisor_name, dept_address, submission_date, status, forwarded_date)
                            VALUES (?, ?, ?, ?, ?, NOW(), 'Pending', NOW())
                            ON DUPLICATE KEY UPDATE 
                                research_title = VALUES(research_title), 
                                researcher_name = VALUES(researcher_name), 
                                supervisor_name = VALUES(supervisor_name), 
                                dept_address = VALUES(dept_address), 
                                submission_date = NOW(), 
                                status = 'Pending', 
                                forwarded_date = NOW()";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("issss", $row['id'], $row['research_title'], $row['researcher_name'], $row['supervisor_name'], $row['dept_address']);

            // Execute the statement to insert the data
            if (!$insertStmt->execute()) {
                echo json_encode(["error" => "Error in inserting into coordinator_exemption table: " . $insertStmt->error]);
                exit;
            }

            echo json_encode(["message" => "Successfully updated to Proceed to Coordinator."]);
        } elseif ($status === 'Rejected') {
            // Delete from other tables if necessary
            $deleteCoordinatorQuery = "DELETE FROM coordinator_exemption WHERE id = ?";
            $deleteCoordinatorStmt = $conn->prepare($deleteCoordinatorQuery);
            $deleteCoordinatorStmt->bind_param("i", $id);
            $deleteCoordinatorStmt->execute();

            $deleteApprovedQuery = "DELETE FROM approved_exemption WHERE id = ?";
            $deleteApprovedStmt = $conn->prepare($deleteApprovedQuery);
            $deleteApprovedStmt->bind_param("i", $id);
            $deleteApprovedStmt->execute();

            // Insert into rejected_exemption table
            $insertQuery = "INSERT INTO rejected_exemption (id, research_title, researcher_name, supervisor_name, dept_address, submission_date, status, forwarded_date)
                            VALUES (?, ?, ?, ?, ?, NOW(), 'Rejected', NOW())
                            ON DUPLICATE KEY UPDATE research_title = VALUES(research_title), researcher_name = VALUES(researcher_name), 
                            supervisor_name = VALUES(supervisor_name), dept_address = VALUES(dept_address), 
                            submission_date = NOW(), status = 'Rejected', forwarded_date = NOW()";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("issss", $row['id'], $row['research_title'], $row['researcher_name'], $row['supervisor_name'], $row['dept_address']);
            $insertStmt->execute();

            echo json_encode(["message" => "Successfully updated to Rejected."]);
        }

    } else {
        echo json_encode(["error" => "Failed to fetch application data."]);
    }
    exit;
}

// Fetch data from the 'berc4' table
$sql = "SELECT id, research_title, researcher_name, supervisor_name, dept_address, status FROM berc4";
$result = $conn->query($sql);
if (!$result) {
    die(json_encode(["error" => "Error fetching data: " . $conn->error]));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemption Management</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        body {
            background-color: #FAFAFA;
            color: #333;
            padding: 20px;
        }

        /* Header Section */
        .sub-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #660066;
            color: #fff;
            padding: 15px 20px;
            border-radius: 5px;
        }
        .sub-header h1 {
            font-size: 1.5rem;
            font-weight: 500;
        }
        .back-btn {
            background-color: #FFC107;
            color: #660066;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background-color: #FFD54F;
        }

        /* Filter Section */
        .filter-section {
            margin: 20px 0;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .filter-section input,
        .filter-section select {
            padding: 10px;
            font-size: 0.9rem;
            width: calc(50% - 10px);
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .filter-section button {
            padding: 10px 15px;
            background-color: #660066;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .filter-section button:hover {
            background-color: #7A267A;
        }

        /* Table Section */
        .table-section {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Ensures borders are seamless */
            background-color: #fff;
            border: 1px solid #ddd; /* Table outer border */
            border-radius: 5px; /* Optional for rounded corners */
            overflow: hidden;
        }
        th, td {
            padding: 12px 10px;
            font-size: 0.9rem;
            text-align: left;
            border: 1px solid #ddd; /* Adds borders for table cells */
        }
        thead {
            background-color: #660066;
            color: #fff;
        }
        tbody tr:hover {
            background-color: #f9f9f9;
        }
        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Action Buttons */
        .status-select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            width: 100%;
        }
        .update-btn {
            background-color: #FFC107;
            color: #660066;
            padding: 8px 10px;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .update-btn:hover {
            background-color: #FFD54F;
        }

        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            .filter-section input,
            .filter-section select {
                width: 100%;
            }
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead {
                display: none;
            }
            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                overflow: hidden;
                background-color: #fff;
            }
            td {
                display: flex;
                justify-content: space-between;
                padding: 10px;
                border-bottom: 1px solid #f0f0f0;
            }
            td:last-child {
                border-bottom: none;
            }
            td:before {
                content: attr(data-label);
                font-weight: bold;
                color: #660066;
            }
        }
    </style>
</head>
<body>
    <header class="sub-header">
        <h1>Exemption Management</h1>
        <a href="secetariat.php" class="back-btn">Home</a>
    </header>
    <section class="filter-section">
        <input type="text" id="searchInput" placeholder="Search by Title or Researcher">
        <select id="statusFilter">
            <option value="">All Statuses</option>
            <option value="Approved">Approved</option>
            <option value="Proceed to Coordinator">Proceed to Coordinator</option>
            <option value="Rejected">Rejected</option>
        </select>
        <button id="filterButton">Filter</button>
    </section>
    <section class="table-section">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Research Title</th>
                    <th>Researcher Name</th>
                    <th>Supervisor Name</th>
                    <th>Department Address</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="applicationsTable">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td data-label="ID"><?= htmlspecialchars($row['id']) ?></td>
                            <td data-label="Research Title"><?= htmlspecialchars($row['research_title']) ?></td>
                            <td data-label="Researcher Name"><?= htmlspecialchars($row['researcher_name']) ?></td>
                            <td data-label="Supervisor Name"><?= htmlspecialchars($row['supervisor_name']) ?></td>
                            <td data-label="Department Address"><?= htmlspecialchars($row['dept_address']) ?></td>
                            <td data-label="Status"><?= htmlspecialchars($row['status']) ?></td>
                            <td><a href="view_exemption.php?id=<?= htmlspecialchars($row['id']) ?>" class="view-btn">View</a></td>
                            <td data-label="Action">
                                <select class="status-select" data-id="<?= $row['id']; ?>">
                                    <option value="Approved" <?= $row['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                    <option value="Proceed to Coordinator" <?= $row['status'] === 'Proceed to Coordinator' ? 'selected' : '' ?>>Proceed to Coordinator</option>
                                    <option value="Rejected" <?= $row['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                                <button class="update-btn" data-id="<?= $row['id']; ?>">Update</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">No applications found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
    <script>
        $(document).ready(function () {
            $('#filterButton').on('click', function () {
                const searchValue = $('#searchInput').val().toLowerCase();
                const statusValue = $('#statusFilter').val();
                $('#applicationsTable tr').each(function () {
                    const title = $(this).find('td[data-label="Research Title"]').text().toLowerCase();
                    const researcher = $(this).find('td[data-label="Researcher Name"]').text().toLowerCase();
                    const status = $(this).find('td[data-label="Status"]').text();
                    if (
                        (searchValue === '' || title.includes(searchValue) || researcher.includes(searchValue)) &&
                        (statusValue === '' || status === statusValue)
                    ) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('.update-btn').on('click', function () {
                const id = $(this).data('id');
                const status = $(this).closest('tr').find('.status-select').val();
                $.ajax({
                    type: 'POST',
                    url: 'exemption.php',
                    data: { id: id, status: status },
                    success: function (response) {
                        try {
                            const jsonResponse = JSON.parse(response);
                            if (jsonResponse.error) {
                                alert("Error: " + jsonResponse.error);
                            } else {
                                alert("Success: " + jsonResponse.message);
                                $(`.status-select[data-id=${id}]`).closest('tr').find('td[data-label="Status"]').text(status);
                            }
                        } catch (e) {
                            alert("Unexpected response: " + response);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("An error occurred: " + error);
                    }
                });
            });
        });
    </script>
</body>
</html>
