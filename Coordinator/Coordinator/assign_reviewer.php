<?php
session_start();

// Include the database connection
include '../../config.php'; // Include the connection from db_connection.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $research_title = mysqli_real_escape_string($conn, $_POST['research_title']);
    $reviewer_id = mysqli_real_escape_string($conn, $_POST['reviewer_id']);

    // Insert assignment into the database
    $sql = "INSERT INTO assigned_reviews (research_title, reviewer_id) VALUES ('$research_title', '$reviewer_id')";
    if (mysqli_query($conn, $sql)) {
        // Fetch reviewer's email
        $reviewerEmailQuery = "SELECT email FROM reviewer WHERE staffID = '$reviewer_id'";
        $reviewerEmailResult = mysqli_query($conn, $reviewerEmailQuery);
        $reviewerEmail = mysqli_fetch_assoc($reviewerEmailResult)['email'];

        // Send notification email
        $to = $reviewerEmail;
        $subject = 'New Research Assignment';
        $message = "You have been assigned to review the research project: $research_title.";
        $headers = 'From: noreply@yourdomain.com';

        mail($to, $subject, $message, $headers);

        $_SESSION['message'] = "Reviewer assigned successfully and notified.";
    } else {
        $_SESSION['error'] = "Error assigning reviewer: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
header("Location: CoordinatorPage.php");
exit();
