<?php
// Start the session
session_start();

$user_id = $_SESSION['user_id'];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Home.php");
    exit();
}

// Set the name variable, default to 'Guest' if not set
$name = isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : '';

// Include the database connection
include '../config.php'; // Include the connection from db_connection.php

// Count submissions in BERC forms
$sql_count_berc1 = "SELECT COUNT(*) AS count FROM berc1 WHERE user_id = ?";
$stmt_berc1 = $conn->prepare($sql_count_berc1);
$stmt_berc1->bind_param("s", $user_id);
$stmt_berc1->execute();
$result_berc1 = $stmt_berc1->get_result();
$count_berc1 = $result_berc1->fetch_assoc()['count'];

$sql_count_berc2 = "SELECT COUNT(*) AS count FROM berc2 WHERE user_id = ?";
$stmt_berc2 = $conn->prepare($sql_count_berc2);
$stmt_berc2->bind_param("s", $user_id);
$stmt_berc2->execute();
$result_berc2 = $stmt_berc2->get_result();
$count_berc2 = $result_berc2->fetch_assoc()['count'];

// Fetch BERC3 and BERC5 counts similarly
$sql_count_berc3 = "SELECT COUNT(*) AS count FROM berc3 WHERE user_id = ?";
$stmt_berc3 = $conn->prepare($sql_count_berc3);
$stmt_berc3->bind_param("s", $user_id);
$stmt_berc3->execute();
$result_berc3 = $stmt_berc3->get_result();
$count_berc3 = $result_berc3->fetch_assoc()['count'];

$sql_count_berc5 = "SELECT COUNT(*) AS count FROM berc5 WHERE user_id = ?";
$stmt_berc5 = $conn->prepare($sql_count_berc5);
$stmt_berc5->bind_param("s", $user_id);
$stmt_berc5->execute();
$result_berc5 = $stmt_berc5->get_result();
$count_berc5 = $result_berc5->fetch_assoc()['count'];

$sql_count_berc4 = "SELECT COUNT(*) AS count FROM berc4 WHERE user_id = ?";
$stmt_berc4 = $conn->prepare($sql_count_berc4);
$stmt_berc4->bind_param("s", $user_id);
$stmt_berc4->execute();
$result_berc4 = $stmt_berc4->get_result();
$count_berc4 = $result_berc4->fetch_assoc()['count'];

$sql_count_berc5ex = "SELECT COUNT(*) AS count FROM berc5ex WHERE user_id = ?";
$stmt_berc5ex = $conn->prepare($sql_count_berc5ex);
$stmt_berc5ex->bind_param("s", $user_id);
$stmt_berc5ex->execute();
$result_berc5ex = $stmt_berc5ex->get_result();
$count_berc5ex = $result_berc5ex->fetch_assoc()['count'];

// Total count of submitted forms
$total_submissions = $count_berc1 + $count_berc2 + $count_berc3 + $count_berc5 + $count_berc4 + $count_berc5ex;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Researcher Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #333;
        }

        .background {
            background-image: url('image/bg3.png');
            background-size: cover; /* Maintain aspect ratio without stretching */
            background-position: center; /* Center the image */
            background-repeat: no-repeat;
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        
        .header {
            background-color: #ffffff;
            text-align: center;
            padding: 9px;
            margin-bottom: 100px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .header img {
            max-width: 110px;
            height: auto;
            margin-left: 10px;
        }
        .greeting {
            text-align: center;
            margin-top: 10px;
            font-size: 1.5em;
        }
        .logout-button {
            margin-right: 20px;
            padding: 10px 20px;
            background-color: #5a67d8;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #4c51bf;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-wrap: wrap;
            
        }

        .container a {
            text-decoration: none; 
            color: inherit;
        }

        .box {
            width: 300px;
            height: 150px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: transform 0.3s ease;
            text-align: center;
            margin-bottom: 140px;
            outline: 2px solid #000; /* Add outline */
            position: relative;
        }

        .box:hover {
            transform: scale(1.1);
        }

        .box p {
            margin: 0;
            font-size: 1.5em;
            font-weight: bold;
            text-transform: uppercase;
            color: #333;
        }

        .box.uniform, .box.kelab, .box.history {
            background-color: #f7f7f7; /* Optional: Add a neutral background color */
        }

        .notification {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545; /* Red background for visibility */
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        .modal-content h2 {
            margin-top: 0;
        }
        .modal-buttons {
            margin-top: 20px;
        }
        .modal-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .modal-buttons .confirm-button {
            background-color: #5a67d8;
            color: white;
        }
        .modal-buttons .confirm-button:hover {
            background-color: #4c51bf;
        }
        .modal-buttons .cancel-button {
            background-color: #ddd;
        }
        .modal-buttons .cancel-button:hover {
            background-color: #bbb;
        }

        @media only screen and (max-width: 768px) {
            .header {
                flex-direction: column;
                padding: 5px;
            }
            .header img {
                display: none;
            }
            .greeting {
                font-size: 0.8em;
            }
            .logout-button {
                font-size: 12px;
                margin-top: 10px;
            }
            .container {
                flex-wrap: wrap;
            }
            .box {
                width: 150px;
                height: 150px;
                margin: 0px 10px 10px 10px; /* Reduced top margin to 0px to move it further up */
                font-size: 12px;
                position: relative;
                top: -10px; /* Added relative positioning to move it further up */
            }
            .modal-content {
                width: 60%;
            }
        }

        @media only screen and (max-width: 425px) {
            .header {
                flex-direction: column;
                padding: 5px;
            }
            .header img {
                display: none;
            }
            .greeting {
                font-size: 0.8em;
                margin-top: 5px;
            }
            .logout-button {
                font-size: 12px;
                margin-top: 10px;
            }
            .container {
                flex-wrap: wrap;
            }
            .box {
                width: 140px;
                height: 140px;
                margin: 0px 10px 10px 10px; /* Reduced top margin to 0px */
                font-size: 11px;
                position: relative;
                top: -10px; /* Moves the box further up */
            }
            .modal-content {
                width: 70%;
            }
        }

        @media only screen and (max-width: 375px) {
            .header {
                flex-direction: column;
                padding: 5px;
            }
            .header img {
                display: none;
            }
            .greeting {
                font-size: 0.8em;
                margin-top: 5px;
            }
            .logout-button {
                font-size: 12px;
                margin-top: 8px;
                padding: 8px 16px;
            }
            .container {
                flex-wrap: wrap;
            }
            .box {
                width: 130px;
                height: 130px;
                margin: 0px 8px 8px 8px; /* Reduced top margin to 0px */
                font-size: 10px;
                position: relative;
                top: -10px; /* Moves the box further up */
            }
            .modal-content {
                width: 80%;
            }
        }
    </style>
</head>
<body class="background">
    <div class="header">
        <img src="image/Uitm.png" alt="Logo">
        <div class="greeting">
            <?php echo "Hello, " . $name; ?>
        </div>
        <button class="logout-button" onclick="openModal()">Logout</button>
    </div>

    <div class="container">
        <a href="Berc/Berc1.php" class="box uniform">
            <p>BERC Application</p>
        </a>
        <a href="Exemption/Berc4.php" class="box kelab">
            <p>Exemption Application</p>
        </a>
        <a href="inbox.php" class="box history">
            <p>Inbox</p>
            <span class="notification"><?php echo $total_submissions; ?></span>
        </a>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h2>Are you sure you want to log out?</h2>
            <div class="modal-buttons">
                <button class="confirm-button" onclick="logout()">Yes</button>
                <button class="cancel-button" onclick="closeModal()">No</button>
            </div>
        </div>
    </div>

    <script>
        // Open the logout modal
        function openModal() {
            document.getElementById('logoutModal').style.display = 'block';
            document.querySelector('.container').style.filter = 'blur(5px)';
        }

        // Close the logout modal
        function closeModal() {
            document.getElementById('logoutModal').style.display = 'none';
            document.querySelector('.container').style.filter = 'none';
        }

        // Perform logout action
        function logout() {
            window.location.href = 'logout.php'; // Redirect to logout script
        }
    </script>
</body>
</html>
