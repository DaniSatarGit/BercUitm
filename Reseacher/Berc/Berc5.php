<?php
session_start(); // Start session if not already started

// Include the database connection
include '../../config.php'; // Include the connection from db_connection.php

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing draft if available
$query = "SELECT * FROM berc5_draft WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$draft = $result->fetch_assoc();

// Semak jika form dihantar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['save_draft']) || isset($_POST['next']))) {
    // Ambil nilai dari form dan simpan dalam $_SESSION
    $_SESSION['fberc1_berc5'] = $_POST['fberc1_berc5'] ?? '';
    $_SESSION['fberc2_berc5'] = $_POST['fberc2_berc5'] ?? '';
    $_SESSION['fberc3_berc5'] = $_POST['fberc3_berc5'] ?? '';
    $_SESSION['fberc4_berc5'] = $_POST['fberc4_berc5'] ?? '';
    $_SESSION['fberc5_berc5'] = $_POST['fberc5_berc5'] ?? '';
    $_SESSION['form_signed_berc5'] = $_POST['form_signed_berc5'] ?? '';
    $_SESSION['approved_by_faculty_berc5'] = $_POST['approved_by_faculty_berc5'] ?? '';
    $_SESSION['supervisor_checked_berc5'] = $_POST['supervisor_checked_berc5'] ?? '';
    $_SESSION['additional_comments_berc5'] = $_POST['additional_comments_berc5'] ?? '';
    $_SESSION['decision_berc5'] = $_POST['decision_berc5'] ?? '';
    $_SESSION['applicant_signature_berc5'] = $_POST['applicant_signature_berc5'] ?? '';
    $_SESSION['applicant_date_berc5'] = $_POST['applicant_date_berc5'] ?? '';
    $_SESSION['supervisor_signature_berc5'] = $_POST['supervisor_signature_berc5'] ?? '';
    $_SESSION['supervisor_date_berc5'] = $_POST['supervisor_date_berc5'] ?? '';


    if (isset($_POST['save_draft']) || isset($_POST['next'])) {
        // Simpan sebagai draf
        if ($draft) {
            // Kemas kini draf yang sedia ada
            $query = "UPDATE berc5_draft SET fberc1_berc5 = ?, fberc2_berc5 = ?, fberc3_berc5 = ?, fberc4_berc5 = ?, fberc5_berc5 = ?, form_signed_berc5 = ?, approved_by_faculty_berc5 = ?, supervisor_checked_berc5 = ?, additional_comments_berc5 = ?, decision_berc5 = ?, applicant_signature_berc5 = ?, applicant_date_berc5 = ?, supervisor_signature_berc5 = ?, supervisor_date_berc5 = ?, submission_date_berc5 = NOW() WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssssssssssss", $_SESSION['fberc1_berc5'], $_SESSION['fberc2_berc5'], $_SESSION['fberc3_berc5'], $_SESSION['fberc4_berc5'], $_SESSION['fberc5_berc5'], $_SESSION['form_signed_berc5'], $_SESSION['approved_by_faculty_berc5'], $_SESSION['supervisor_checked_berc5'], $_SESSION['additional_comments_berc5'], $_SESSION['decision_berc5'], $_SESSION['applicant_signature_berc5'], $_SESSION['applicant_date_berc5'], $_SESSION['supervisor_signature_berc5'], $_SESSION['supervisor_date_berc5'], $user_id);
        } else {
            // Masukkan draf baru
            $query = "INSERT INTO berc5_draft (user_id, fberc1_berc5, fberc2_berc5, fberc3_berc5, fberc4_berc5, fberc5_berc5, form_signed_berc5, approved_by_faculty_berc5, supervisor_checked_berc5, additional_comments_berc5, decision_berc5, applicant_signature_berc5, applicant_date_berc5, supervisor_signature_berc5, supervisor_date_berc5, submission_date_berc5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssssssssssssss", $user_id, $_SESSION['fberc1_berc5'], $_SESSION['fberc2_berc5'], $_SESSION['fberc3_berc5'], $_SESSION['fberc4_berc5'], $_SESSION['fberc5_berc5'], $_SESSION['form_signed_berc5'], $_SESSION['approved_by_faculty_berc5'], $_SESSION['supervisor_checked_berc5'], $_SESSION['additional_comments_berc5'], $_SESSION['decision_berc5'], $_SESSION['applicant_signature_berc5'], $_SESSION['applicant_date_berc5'], $_SESSION['supervisor_signature_berc5'], $_SESSION['supervisor_date_berc5']);
        }
        if ($stmt->execute()) {
            echo '<div id="successMessage" class="success-message">Draf Saved Successfully!</div>';
            echo '<script>
                    const successMessage = document.getElementById("successMessage");
                    successMessage.style.opacity = 1;
                    setTimeout(() => {
                        successMessage.style.opacity = 0;
                    }, 1000);
                  </script>';
        } else {
            echo '<div id="errorMessage" class="error-message">Error: ' . htmlspecialchars($stmt->error) . '</div>';
        }
        
    } if (isset($_POST['next'])) {
        // Redirect to berc5db.php for form submission
        header("Location: Berc5DB.php");
    }
} else {
    // Populate the form with the draft values if no submission
    $_SESSION['fberc1_berc5'] = $draft['fberc1_berc5'] ?? '';
    $_SESSION['fberc2_berc5'] = $draft['fberc2_berc5'] ?? '';
    $_SESSION['fberc3_berc5'] = $draft['fberc3_berc5'] ?? '';
    $_SESSION['fberc4_berc5'] = $draft['fberc4_berc5'] ?? '';
    $_SESSION['fberc5_berc5'] = $draft['fberc5_berc5'] ?? '';
    $_SESSION['form_signed_berc5'] = $draft['form_signed_berc5'] ?? '';
    $_SESSION['approved_by_faculty_berc5'] = $draft['approved_by_faculty_berc5'] ?? '';
    $_SESSION['supervisor_checked_berc5'] = $draft['supervisor_checked_berc5'] ?? '';
    $_SESSION['additional_comments_berc5'] = $draft['additional_comments_berc5'] ?? '';
    $_SESSION['decision_berc5'] = $draft['decision_berc5'] ?? '';
    $_SESSION['applicant_signature_berc5'] = $draft['applicant_signature_berc5'] ?? '';
    $_SESSION['applicant_date_berc5'] = $draft['applicant_date_berc5'] ?? '';
    $_SESSION['supervisor_signature_berc5'] = $draft['supervisor_signature_berc5'] ?? '';
    $_SESSION['supervisor_date_berc5'] = $draft['supervisor_date_berc5'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Checklist</title>
    <style>
        /* Success Message Styling */
        .success-message {
            position: fixed;
            top: 2.9%;
            right: 84.3%;
            padding: 15px 20px;
            background-color: #28a745; /* Green background for success */
            color: #fff;
            font-size: 16px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            z-index: 1000;
        }

        /* Error Message Styling */
        .error-message {
            position: fixed;
            top: 2.9%;
            right: 84.3%;
            padding: 15px 20px;
            background-color: #dc3545; /* Red background for error */
            color: #fff;
            font-size: 16px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 1;
            z-index: 1000;
        }

        /* Base Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #343a40;
        }

        /* Container Styling */
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 40px;
            padding-top: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        nav {
            background-color: whitesmoke;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px; /* Adjust the value for more or less rounding */
            top: 0; 
            z-index: 1000; 
            outline: 1px solid #0056b3;
        }

        nav ul {
            list-style-type: none; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 20px; /* Adjust margin for spacing */
            position: relative; /* For the underline effect */
        }

        nav ul li a {
            color: #444; /* Link text color */
            text-decoration: none; 
            padding: 10px 0; /* Adjust padding for spacing */
            transition: color 0.3s ease; /* Smooth color transition */
        }

        nav ul li a:hover {
            color: #0056b3; /* Change text color on hover */
        }

        /* Underline effect */
        nav ul li a::after {
            content: ''; /* Creates an empty element for the underline */
            display: block; /* Allows the element to take up space */
            height: 2px; /* Thickness of the underline */
            background-color: #0056b3; /* Color of the underline */
            transform: scaleX(0); /* Start with no underline */
            transition: transform 0.3s ease; /* Smooth transition for the scaling */
            width: 100%; /* Full width of the link */
            margin: 0 auto; /* Center the underline */
        }

        nav ul li a:hover::after,
        nav ul li a.active::after {
            transform: scaleX(1); /* Scale up the underline on hover or active */
        }

        /* Header Styling */
        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header img {
            width: 120px;
            height: auto;
        }

        .header h3 {
            font-size: 28px;
            font-weight: bold;
            color: #004085;
        }

        .header h5, .header h6 {
            color: #6c757d;
        }

        .header h4 {
            font-size: 24px;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
            color: #495057;
        }

        .header p {
            font-style: italic;
            color: #6c757d;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 15px;
            border: 1px solid #dee2e6;
        }

        table th {
            background-color: #007bff;
            color: #ffffff;
            font-size: 16px;
            align-items: center;
        }

        table td {
            background-color: #f8f9fa;
            font-size: 14px;
        }

        /* Checkbox Styling */
        input[type="checkbox"] {
            transform: scale(1.2);
            margin-right: 15px;
            align-items: center;
            flex-wrap: wrap;
        } 

        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
        }

         .checkbox-group label {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }

        /* Radio Button Styling */
        .radio-group {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        .radio-group label {
            font-size: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .radio-group input {
            margin-right: 10px;
        }

        /* Input and Textarea Styling */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        /* Date Styling */
        input[type="date"] {
            padding: 7px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff; /* Blue background */
            border: none;
            border-radius: 8px;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1); /* Makes the calendar icon white */
        }

        input[type="date"]:hover {
            background-color: #0056b3; /* Darker blue when hovered */
        }

        input[type="date"]:focus {
            outline: none;
            background-color: #28a745; /* Green when focused */
        }

        .button-container {
            display: flex; /* Use flexbox to align buttons side by side */
            gap: 10px; /* Space between buttons */
        }

        .submit-button {
            background-color: #0056b3; /* Set the background color */
            color: white; /* Text color */
            border: none; /* Remove border */
            padding: 10px 20px; /* Padding for spacing */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Change cursor on hover */
            font-size: 16px; /* Font size */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .submit-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .back-button {
            background-color: #6c757d; /* Gray background color for the back button */
            color: white; /* Text color */
            border: none; /* Remove border */
            padding: 10px 20px; /* Padding for spacing */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Change cursor on hover */
            font-size: 16px; /* Font size */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .back-button:hover {
            background-color: #5a6268; /* Darker shade on hover */
        }

        .next-button {
            background-color: #28a745; /* Green background color for the next button */
            color: white; /* Text color */
            border: none; /* Remove border */
            padding: 10px 20px; /* Padding for spacing */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Change cursor on hover */
            font-size: 16px; /* Font size */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        .next-button:hover {
            background-color: #218838; /* Darker shade on hover */
        }

        /* Message box overlay */
        .message-box {
            display: none;
            position: fixed;
            z-index: 999; /* Ensure it stays on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        }

        /* Message box content */
        .message-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            margin-top: 220px;
            margin-left: 600px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .confirm-button, .cancel-button {
            background-color: #4CAF50; /* Same style as back button */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }

        .confirm-button:hover, .cancel-button:hover {
            background-color: #45a049;
        }


    /* Responsive for smaller screens */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        nav ul li a {
        font-size: 11px; 
        padding: 10px 0; 
        }

        nav ul li {
        margin: 0 14px; 
        position: relative; 
        }

        .header h3 {
            font-size: 20px;
        }

        .header h4 {
            font-size: 16px;
        }

        .section th {
            font-size: 10px;
        }

        .section h3 {
            font-size: 16px;
        }

        .section i {
            font-size: 9px;
        }

        .section td {
            font-size: 11px;
        }

        .section b {
            font-size: 12px;
        }

        label, input[type="text"], textarea {
            font-size: 10px;
            padding: 8px;
        }

        input[type="submit"] {
            font-size: 12px;
            padding: 10px 20px;
        }
    }

    @media (max-width: 425px) {
        .container {
            padding: 10px;
        }

        nav ul li a {
            font-size: 9px; 
            padding: 10px 0; 
        }

        nav ul li {
            margin: 0 10px; 
            position: relative; 
        }

        .header h3 {
            font-size: 18px;
        }

        .header h4 {
            font-size: 14px;
        }

        .section h3 {
            font-size: 16px;
        }

        .section i {
            font-size: 8px;
        }

        .section td {
            font-size: 10px;
        }

        .section b {
            font-size: 12px;
        }

        label, input[type="text"], textarea {
            font-size: 10px;
            padding: 8px;
        }

        input[type="submit"] {
            font-size: 10px;
            padding: 8px 16px;
        }
    }
    </style>
</head>
<body>
        <nav>
            <ul>
                <li><a href="../ReseacherPage.php" style="font-weight: bold;">HOME</a></li>
                <li><a href="Berc1.php">BERC1</a></li>
                <li><a href="Berc2.php">BERC2</a></li>
                <li><a href="Berc3.php">BERC3</a></li>
                <li><a class="active">BERC5</a></li>
               
            </ul>
        </nav>
    <div class="container">
        <div class="header">
            <img src="image/Uitm.png" alt="University Logo">
            <h3>Universiti Teknologi MARA</h3>
            <h5>13500 Permatang Pauh</h5>
            <h6>Tel: 04-382 2888 | Faks: 04-382 2776</h6>
            <h4>Applicant Checklist</h4>
            <p><i>Senarai Semak Pemohon</i></p>
        </div>

        <form id="myForm" method="post">
        <!-- Terms of Submission -->
         <div class="section">
        <table>
            <tbody>
                <tr>
                    <td style="background-color: #e2e6ea;">
                        <strong>Terms of Submission of Faculty/Branch Research Ethics Approval Application</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>1. Ensure that all research team members have signed the application.</p>
                        <p>2. Ensure the application is signed and endorsed by the Faculty/Campus Research Committee.</p>
                        <p>3. Submit all required documents two (2) working weeks before the scheduled BERC meeting.</p>
                        <p>4. Forms must be submitted in English (unless approved for other languages).</p>
                        <p>5. Data collection instruments must be available in Malay, English, or other languange(s) understood by <p style="text-indent: 14px;">participant.</p> 
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Part A -->
        <table>
            <thead>
                <tr>
                    <th>Part A – For All Applicants<br><i>Bahagian A - Untuk Semua Pemohon</i></th>
                    <th>YES<br><i>Ya</i></th>
                    <th>NO<br><i>Tidak</i></th>
                </tr>
            </thead>
            <tbody>
                <!-- Questions  -->
                <tr>
                    <td> 
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">1. Have you completed the F/BERC 1 form?</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Adakah anda telah melengkapkan borang F/BERC 1?</i></p>
                    </td>
                    <td>
                        <input type="radio" name="fberc1_berc5" value="Yes" style="margin-left: 15px;" <?php echo (isset($_SESSION['fberc1_berc5']) && $_SESSION['fberc1_berc5'] == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" name="fberc1_berc5" value="No" style="margin-left: 20px;" <?php echo (isset($_SESSION['fberc1_berc5']) && $_SESSION['fberc1_berc5'] == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">2. Have you completed the F/BERC 2 form?</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Adakah anda telah melengkapkan borang F/BERC 2?</i></p>
                    </td>
                    <td>
                        <input type="radio" name="fberc2_berc5" value="Yes" style="margin-left: 15px;" <?php echo (isset($_SESSION['fberc2_berc5']) && $_SESSION['fberc2_berc5'] == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" name="fberc2_berc5" value="No" style="margin-left: 20px;" <?php echo (isset($_SESSION['fberc2_berc5']) && $_SESSION['fberc2_berc5'] == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">3. Have you completed the F/BERC 3 form?</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Adakah anda telah melengkapkan borang F/BERC 3?</i></p>
                    </td>
                    <td>
                        <input type="radio" name="fberc3_berc5" value="Yes" style="margin-left: 15px;" <?php echo (isset($_SESSION['fberc3_berc5']) && $_SESSION['fberc3_berc5'] == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" name="fberc3_berc5" value="No" style="margin-left: 20px;" <?php echo (isset($_SESSION['fberc3_berc5']) && $_SESSION['fberc3_berc5'] == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">4. Have you completed the F/BERC 4 form?<b> (For Exemption from Ethic Review*)</b></p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;">Please attach a copy of Research Proposal.</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Adakah anda telah melengkapkan borang F/BERC 4?</i></p>
                        <p style="margin: 0; line-height: 1.3; text-indent: 15px;"><b><i>Untuk pengeculian daripada Semakan Etika*</i></b></p>
                    </td>
                    <td>
                        <input type="radio" name="fberc4_berc5" value="Yes" style="margin-left: 15px;" <?php echo (isset($_SESSION['fberc4_berc5']) && $_SESSION['fberc4_berc5'] == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" name="fberc4_berc5" value="No" style="margin-left: 20px;" <?php echo (isset($_SESSION['fberc4_berc5']) && $_SESSION['fberc4_berc5'] == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">5. Have you completed the F/BERC 5 form?</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Adakah anda telah melengkapkan borang F/BERC 5?</i>
                        </td>
                    <td>
                        <input type="radio" name="fberc5_berc5" value="Yes" style="margin-left: 15px;" <?php echo (isset($_SESSION['fberc5_berc5']) && $_SESSION['fberc5_berc5'] == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" name="fberc5_berc5" value="No" style="margin-left: 15px;" <?php echo (isset($_SESSION['fberc5_berc5']) && $_SESSION['fberc5_berc5'] == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">6. Has the form been signed by all researchers?
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Adakah borang ditandatangani oleh semua penyelidik?</i></p>
                    </td>
                    <td>
                         <input type="radio" name="form_signed_berc5" value="Yes" style="margin-left: 15px;" <?php echo (isset($_SESSION['form_signed_berc5']) && $_SESSION['form_signed_berc5'] == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" name="form_signed_berc5" value="No" style="margin-left: 20px;" <?php echo (isset($_SESSION['form_signed_berc5']) && $_SESSION['form_signed_berc5'] == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">7. Has your application been approved and endorsement by your Faculty/</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;">State Research Committee?</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Sudahkah permohonan anda mendapat kelulusan dan pengesahan Jawatankuasa</i></p>
                        <p style="margin: 0; line-height: 1.3; text-indent: 15px;"><i>Penyelidikan Fakulti/Negeri?</i></p>
                    </td>
                    <td>
                        <input type="radio" name="approved_by_faculty_berc5" value="Yes" style="margin-left: 15px;" <?php echo (isset($_SESSION['approved_by_faculty_berc5']) && $_SESSION['approved_by_faculty_berc5'] == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" name="approved_by_faculty_berc5" value="No" style="margin-left: 20px;" <?php echo (isset($_SESSION['approved_by_faculty_berc5']) && $_SESSION['approved_by_faculty_berc5'] == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">8. Has your supervisor checked for grammatical errors in REC 2 and REC 4 forms?</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Adakah penyelia anda telah menyemak untuk kesalahan tatabahasa dalam borang</i></p>
                        <p style="margin: 0; line-height: 1.3; text-indent: 15px;">REC 2 dan borang REC 4?</i></p>
                    </td>
                    <td>
                        <input type="radio" name="supervisor_checked_berc5" value="Yes" style="margin-left: 15px;" <?php echo (isset($_SESSION['supervisor_checked_berc5']) && $_SESSION['supervisor_checked_berc5'] == 'Yes') ? 'checked' : ''; ?>>
                    </td>
                    <td>
                        <input type="radio" name="supervisor_checked_berc5" value="No" style="margin-left: 20px;" <?php echo (isset($_SESSION['supervisor_checked_berc5']) && $_SESSION['supervisor_checked_berc5'] == 'No') ? 'checked' : ''; ?>>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Part B -->
        <table>
            <thead>
                <tr>
                    <th>Part B – Upload Forms<br><i>Bahagian B - Muat Naik Borang</i></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Please upload scanned forms (BERC 1, BERC 2, BERC 3, BERC 5 / BERC 4) to the following link:<br>
                        <i>Sila muat naik salinan borang asal permohonan (BERC 1, BERC 2, BERC 3, BERC 5 / BERC 4) yang lengkap ditandatangan beserta cop ke pautan berikut:</i><br>
                        <p style="text-align: center;"><a href="https://forms.gle/aMZLG7zuwEZpL6KP8" target="_blank">Upload Here</a></p>
                        <p>You are advised to submit your application at least TWO (2) working weeks before the meeting (please check the meeting schedule at the website:
                            <br><i>Anda dinasihatkan untuk menyerahkan borang permohonan sekurang-kurangnya DUA (2) minggu hari bekerja sebelum tarikh mesyuarat (Sila semak tarikh mesyuarat di laman sesawang:</p>
                        <p style="text-align: center"><a href="https://penang.uitm.edu.my/index.php/component/sppagebuilder/?view=page&id=41" target="_blank">https://penang.uitm.edu.my/index.php/component/sppagebuilder/?view=page&id=41</a></p> 
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Radio Buttons for Decision -->
        <br>
        <td>Decisions for the applications will be informed within ONE (1) working weeks after the meeting. 
            <br><i>Keputusan permohonan akan dimaklumkan SATU (1) minggu hari bekerja selepas mesyuarat.</i>
            <p>Decisions:<br><i>Keputusan:</i></p>
        </td>
        <div class="radio-group">
            <label><input type="radio" name="decision_berc5" value="approved" <?php echo (isset($_SESSION['decision_berc5']) && $_SESSION['decision_berc5'] == 'approved') ? 'checked' : ''; ?>> Approve.<br>  Lulus.</label>
            <label><input type="radio" name="decision_berc5" value="not-approved" <?php echo (isset($_SESSION['decision_berc5']) && $_SESSION['decision_berc5']== 'not-approved') ? 'checked' : ''; ?>> Not approved due to unresolved ethical issues. Recommend to resubmit. <br>
                Tidak lulus disebabkan isu etika. Dicadangkan untuk memohon semula. </i></label>
        </div>
        <br>

        <!-- Additional Comments -->
        <label for="additional-comments"><strong>Additional Comments (if any):<br>Komen Tambahan (Jika Ada):</strong></label>
         <textarea style="width: 97%" id="additional_comments_berc5" name="additional_comments_berc5" rows="4"><?php echo htmlspecialchars($_SESSION['additional_comments_berc5'] ?? ''); ?></textarea>


        <!-- Signatures Box-->
        <table>
            <tbody>
                <tr>
                    <td>
                        <p><strong>Applicant's Signature:<br><i>Tandatangan Pemohon:</i></strong></p>
                        <!-- Agree to Terms Checkbox -->
                    <div class="checkbox-group">
                        <label><input type="checkbox" id="applicant_signature_berc5" name="applicant_signature_berc5" <?php echo (isset($_SESSION['applicant_signature_berc5']) && $_SESSION['applicant_signature_berc5'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.</label>
                        <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                    </div>

                     <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="applicant_date_berc5" id="applicant_date_berc5" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['applicant_date_berc5']) ?? ''; ?>">
                    </td>

                     <!-- Signature Box -->
                    <td>
                        <p><strong>Supervisor's Signature:<br><i>Tandatangan Penyelia:</i></strong></p>
                        <!-- Agree to Terms Checkbox -->
                    <div class="checkbox-group">
                        <label><input type="checkbox" id="supervisor_signature_berc5" name="supervisor_signature_berc5" <?php echo (isset($_SESSION['supervisor_signature_berc5']) && $_SESSION['supervisor_signature_berc5'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.</label>
                        <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                    </div>

                     <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="supervisor_date_berc5" id="supervisor_date_berc5" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['supervisor_date_berc5'] ?? ''); ?>">
                    </td>
                </tr>
            </tbody>
        </table><br>
        <div class="button-container">
            <!-- Back button -->
            <button class="back-button" type="button" name="back" onclick="location.href='berc3.php'">Back</button>
            <!-- Save as Draft button -->
            <button type="submit" class="submit-button" id="saveAsDraft" name="save_draft">Save as Draft</button>
            <!-- Submit button -->
            <button type="submit" class="next-button" id="submitForm" name="next">Submit</button>
        </div>
        </form>
    </div>
    <script>
        // Get elements for form submission
        const form = document.getElementById('myForm');
        const saveAsDraftButton = document.getElementById('saveAsDraft');
        const submitFormButton = document.getElementById('submitForm');

        // Save as Draft button click logic
        saveAsDraftButton.addEventListener('click', function(event) {
            // Disable validation for Save as Draft button
            form.noValidate = true;
        });

        // Submit button click logic
        submitFormButton.addEventListener('click', function(event) {
            // Enable validation for Submit button
            form.noValidate = false;
        });
    </script>
</body>
</html>
