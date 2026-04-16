<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Successful</title>
    <style>
        /* Base Styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }

        .success-container {
            max-width: 400px;
            width: 90%;
            padding: 20px;
            background-color: #ffffff;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .success-icon {
            margin-bottom: 15px;
            animation: bounceIn 0.6s ease-in-out;
        }

        .success-icon svg {
            width: 110px;
            height: 110px;
            fill: #5cb85c; /* Green color for the tick icon */
        }

        h1 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 1em;
            color: #666;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 0.9em;
            color: #fff;
            background-color: #5cb85c; /* Soft green color */
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }

        a:hover {
            background-color: #4cae4c; /* Slightly darker green on hover */
        }

        /* Animation */
        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>

<div class="success-container">
    <div class="success-icon">
        <!-- Green Tick Icon using SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M20.285 6.709l-11.285 11.29-5.285-5.292 1.415-1.416 3.869 3.877 9.871-9.878 1.415 1.419z"/>
        </svg>
    </div>
    <h1>Submission Successful</h1>
    <p>Your submission was completed successfully. Thank you for your input.</p>
    <a href="../ReseacherPage.php">Return to Home</a>
</div>

</body>
<script>
        // Redirect to ../ReseacherPage.php after 3 seconds
        setTimeout(() => {
            window.location.href = '../ReseacherPage.php';
        }, 4000);
    </script>
</html>
