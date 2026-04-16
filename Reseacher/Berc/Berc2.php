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
$query = "SELECT * FROM berc2_draft WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$draft = $result->fetch_assoc();

// If the form is submitted to save a draft, use submitted values from $_POST, otherwise use the draft values
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['save_draft']) || isset($_POST['next']))) {
    $_SESSION['projectTitle_berc2'] = $_POST['projectTitle_berc2'] ?? '';
    $_SESSION['projectDescription_berc2'] = $_POST['projectDescription_berc2'] ?? '';  
    $_SESSION['projectPurpose_berc2'] = $_POST['projectPurpose_berc2'] ?? '';  
    $_SESSION['projectProcedure_berc2'] = $_POST['projectProcedure_berc2'] ?? '';  
    $_SESSION['projectParticipation_berc2'] = $_POST['projectParticipation_berc2'] ?? '';  
    $_SESSION['projectBenefit_berc2'] = $_POST['projectBenefit_berc2'] ?? '';  
    $_SESSION['projectRisk_berc2'] = $_POST['projectRisk_berc2'] ?? ''; 
    $_SESSION['projectConfidential_berc2'] = $_POST['projectConfidential_berc2'] ?? '';  
    $_SESSION['participantName_berc2'] = $_POST['participantName_berc2'] ?? ''; 
    $_SESSION['participantSignature_berc2'] = $_POST['participantSignature_berc2'] ?? '';  
    $_SESSION['participantIC_berc2'] = $_POST['participantIC_berc2'] ?? ''; 
    $_SESSION['participantDate_berc2'] = $_POST['participantDate_berc2'] ?? '';  
    $_SESSION['witnessName_berc2'] = $_POST['witnessName_berc2'] ?? '';  
    $_SESSION['witnessSignature_berc2'] = $_POST['witnessSignature_berc2'] ?? '';  
    $_SESSION['witnessIC_berc2'] = $_POST['witnessIC_berc2'] ?? '';  
    $_SESSION['witnessDate_berc2'] = $_POST['witnessDate_berc2'] ?? '';  
    $_SESSION['consentTakerName_berc2'] = $_POST['consentTakerName_berc2'] ?? '';  
    $_SESSION['consentTakerSignature_berc2'] = $_POST['consentTakerSignature_berc2'] ?? '';  
    $_SESSION['consentTakerIC_berc2'] = $_POST['consentTakerIC_berc2'] ?? '';  
    $_SESSION['consentTakerDate_berc2'] = $_POST['consentTakerDate_berc2'] ?? '';  

    // Insert or update draft in the database
    if ($draft) {
        // Update existing draft
        $query = "UPDATE berc2_draft SET
            projectTitle_berc2 = '{$_SESSION['projectTitle_berc2']}',
            projectDescription_berc2 = '{$_SESSION['projectDescription_berc2']}',
            projectPurpose_berc2 = '{$_SESSION['projectPurpose_berc2']}',
            projectProcedure_berc2 = '{$_SESSION['projectProcedure_berc2']}',
            projectParticipation_berc2 = '{$_SESSION['projectParticipation_berc2']}',
            projectBenefit_berc2 = '{$_SESSION['projectBenefit_berc2']}',
            projectRisk_berc2 = '{$_SESSION['projectRisk_berc2']}',
            projectConfidential_berc2 = '{$_SESSION['projectConfidential_berc2']}',
            participantName_berc2 = '{$_SESSION['participantName_berc2']}',
            participantSignature_berc2 = '{$_SESSION['participantSignature_berc2']}',
            participantIC_berc2 = '{$_SESSION['participantIC_berc2']}',
            participantDate_berc2 = '{$_SESSION['participantDate_berc2']}',
            witnessName_berc2 = '{$_SESSION['witnessName_berc2']}',
            witnessSignature_berc2 = '{$_SESSION['witnessSignature_berc2']}',
            witnessIC_berc2 = '{$_SESSION['witnessIC_berc2']}',
            witnessDate_berc2 = '{$_SESSION['witnessDate_berc2']}',
            consentTakerName_berc2 = '{$_SESSION['consentTakerName_berc2']}',
            consentTakerSignature_berc2 = '{$_SESSION['consentTakerSignature_berc2']}',
            consentTakerIC_berc2 = '{$_SESSION['consentTakerIC_berc2']}',
            consentTakerDate_berc2 = '{$_SESSION['consentTakerDate_berc2']}'
            WHERE user_id = '$user_id'";
    } else {
        // Insert new draft
        $query = "INSERT INTO berc2_draft (user_id, projectTitle_berc2, projectDescription_berc2, projectPurpose_berc2, projectProcedure_berc2, 
            projectParticipation_berc2, projectBenefit_berc2, projectRisk_berc2, projectConfidential_berc2,
            participantName_berc2, participantSignature_berc2, participantIC_berc2, participantDate_berc2,
            witnessName_berc2, witnessSignature_berc2, witnessIC_berc2, witnessDate_berc2,
            consentTakerName_berc2, consentTakerSignature_berc2, consentTakerIC_berc2, consentTakerDate_berc2)
            VALUES ('$user_id', '{$_SESSION['projectTitle_berc2']}', '{$_SESSION['projectDescription_berc2']}', '{$_SESSION['projectPurpose_berc2']}', '{$_SESSION['projectProcedure_berc2']}', '{$_SESSION['projectParticipation_berc2']}','{$_SESSION['projectBenefit_berc2']}', '{$_SESSION['projectRisk_berc2']}', '{$_SESSION['projectConfidential_berc2']}', '{$_SESSION['participantName_berc2']}', '{$_SESSION['participantSignature_berc2']}', '{$_SESSION['participantIC_berc2']}', '{$_SESSION['participantDate_berc2']}', '{$_SESSION['witnessName_berc2']}', '{$_SESSION['witnessSignature_berc2']}', '{$_SESSION['witnessIC_berc2']}', '{$_SESSION['witnessDate_berc2']}', '{$_SESSION['consentTakerName_berc2']}', '{$_SESSION['consentTakerSignature_berc2']}', '{$_SESSION['consentTakerIC_berc2']}', '{$_SESSION['consentTakerDate_berc2']}')";
    }

    if (mysqli_query($conn, $query)) {
        echo '<div id="successMessage" class="success-message">Draft saved successfully!</div>';
        echo '<script>
                const successMessage = document.getElementById("successMessage");
                successMessage.style.opacity = 1;
                setTimeout(() => {
                    successMessage.style.opacity = 0;
                }, 1000);
              </script>';
    } else {
        echo '<div id="errorMessage" class="error-message">Error: ' . htmlspecialchars(mysqli_error($conn)) . '</div>';
    } 

            // Jika butang "Next" ditekan, alihkan ke halaman seterusnya
            if (isset($_POST['next'])) {
                header("Location: Berc3.php");
            }
} else {
    // Populate the form with the draft values if no submission
    $_SESSION['projectTitle_berc2'] = $draft['projectTitle_berc2'] ?? '';
    $_SESSION['projectDescription_berc2'] = $draft['projectDescription_berc2'] ?? '';
    $_SESSION['projectPurpose_berc2'] = $draft['projectPurpose_berc2'] ?? '';  
    $_SESSION['projectProcedure_berc2'] = $draft['projectProcedure_berc2'] ?? '';  
    $_SESSION['projectParticipation_berc2'] = $draft['projectParticipation_berc2'] ?? '';  
    $_SESSION['projectBenefit_berc2'] = $draft['projectBenefit_berc2'] ?? '';  
    $_SESSION['projectRisk_berc2'] = $draft['projectRisk_berc2'] ?? ''; 
    $_SESSION['projectConfidential_berc2'] = $draft['projectConfidential_berc2'] ?? ''; 
    $_SESSION['participantName_berc2'] = $draft['participantName_berc2'] ?? '';  
    $_SESSION['participantSignature_berc2'] = $draft['participantSignature_berc2'] ?? ''; 
    $_SESSION['participantIC_berc2'] = $draft['participantIC_berc2'] ?? '';  
    $_SESSION['participantDate_berc2'] = $draft['participantDate_berc2'] ?? '';  
    $_SESSION['witnessName_berc2'] = $draft['witnessName_berc2'] ?? '';  
    $_SESSION['witnessSignature_berc2'] = $draft['witnessSignature_berc2'] ?? ''; 
    $_SESSION['witnessIC_berc2'] = $draft['witnessIC_berc2'] ?? '';  
    $_SESSION['witnessDate_berc2'] = $draft['witnessDate_berc2'] ?? '';  
    $_SESSION['consentTakerName_berc2'] = $draft['consentTakerName_berc2'] ?? ''; 
    $_SESSION['consentTakerSignature_berc2'] = $draft['consentTakerSignature_berc2'] ?? '';  
    $_SESSION['consentTakerIC_berc2'] = $draft['consentTakerIC_berc2'] ?? '';  
    $_SESSION['consentTakerDate_berc2'] = $draft['consentTakerDate_berc2'] ?? '';  
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethics Approval Application Form</title>
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
            outline: 1px solid #6c757d;
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

        /* Responsive styles for smaller screens */
        @media (max-width: 768px) {
            nav ul li a {
                font-size: 11px; /* Decrease font size */
                padding: 10px 0; /* Adjust padding */
            }

            nav ul li {
            margin: 0 14px; /* Adjust margin for spacing */
            position: relative; /* For the underline effect */
            }
        }

        /* Responsive styles for smaller screens */
        @media (max-width: 425px) {
            nav ul li a {
                font-size: 9px; /* Decrease font size */
                padding: 10px 0; /* Adjust padding */
            }

            nav ul li {
            margin: 0 10px; /* Adjust margin for spacing */
            position: relative; /* For the underline effect */
            }
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

        /* Section Styling */
        .section {
            margin-bottom: 30px;
        }

        .section h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #0056b3;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
        }

        /* Label Styling */
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: normal;
            color: #333;
        }

        /* Input and Textarea Styling */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 10px;
            margin-top: 5px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s ease-in-out;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        /* Radio Button Styling */
        .radio-group {
            display: flex;
            align-items: center;
        }

        .radio-group label {
            margin-left: 5px;
            margin-right: 20px;
            font-weight: normal;
        }

        .radio-group input[type="radio"] {
            margin-right: 5px;
        }

        /* Checkbox Styling */
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .checkbox-group label {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 5px;
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


        /* Form Enhancements */
        form {
            padding: 20px 0;
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
                <li><a class="active">BERC2</a></li>
                <li><a href="Berc3.php">BERC3</a></li>
                <li><a href="Berc5.php">BERC5</a></li>
               
            </ul>
        </nav>
    <div class="container">
        <div class="header">
            <img src="image/Uitm.png" alt="University Logo">
            <h3>Universiti Teknologi MARA</h3>
            <h5>13500 Permatang Pauh</h5>
            <h6>Tel: 04-382 2888 | Faks: 04-382 2776</h6>
            <h4>Participant Information Sheet</h4>
            <p><i>Borang Maklumat Peserta</i></p>
        </div>

        <p>This application is for the purpose of obtaining approval to conduct research. Please attach a copy of Research Proposal.</p>
        <p>Permohonan ini dikemukakan untuk tujuan kelulusan menjalankan penyelidikan. Sila lampirkan salinan kertas cadangan penyelidikan.</p>
        

          <!-- Assent Form -->
        <form id="myForm" method="post">
            <!--Information Sheet -->
            <div class="section">
                <label for="projectName_berc2"><b>Research Title:</b><br><i>Tajuk Penyelidikan:</i></label>
                <input type="text" id="projectTitle_berc2" name="projectTitle_berc2" placeholder="State" required value="<?php echo htmlspecialchars($_SESSION['projectTitle_berc2']); ?>"></input>
                <br>
                <br>

                <label for="projectDescription_berc2"><b>Introduction of Research:</b><br><i>Pengenalan Penyelidikan:</i></label>
                <textarea id="projectDescription_berc2" name="projectDescription_berc2" rows="6" placeholder="Max of 300 words using non-expert language/terms" required><?php echo htmlspecialchars($_SESSION['projectDescription_berc2']); ?></textarea>
                <br>
                <br>

                <label for="projectPurpose_berc2"><b>Purpose of Research:</b><br><i>Tujuan Penyelidikan:</i></label>
                <textarea id="projectPurpose_berc2" name="projectPurpose_berc2" rows="6" placeholder="Max of 150 words using non-expert language/terms" required><?php echo htmlspecialchars($_SESSION['projectPurpose_berc2']); ?></textarea>
                <br>
                <br>

                <label for="projectProcedure_berc2"><b>Research Procedure:</b><br><i>Prosedur Penyelidikan:</i></label>
                <textarea id="projectProcedure_berc2" name="projectProcedure_berc2" rows="6" placeholder="Using non-expert language/terms" required><?php echo htmlspecialchars($_SESSION['projectProcedure_berc2']); ?></textarea>
                <br>
                <br>

                <label for="projectParticipation_berc2"><b>Participation in Research:</b><br><i>Penyertaan dalam Penyelidikan:</i></label>
                <textarea id="projectParticipation_berc2" name="projectParticipation_berc2" rows="6"><?php echo htmlspecialchars($_SESSION['projectParticipation_berc2']); ?></textarea>
                <br>
                <br>

                <label for="projectBenefit_berc2"><b>Benefit of Research:</b><br><i>Manfaat Penyelidikan:</i></label>
                <textarea id="projectBenefit_berc2" name="projectBenefit_berc2" placeholder="State the benefit to participants"required><?php echo htmlspecialchars($_SESSION['projectBenefit_berc2']); ?></textarea>
                <br>
                <br>

                <label for="projectRisk_berc2"><b>Research Risk:</b><br><i>Risiko Penyelidikan:</i></label>
                <textarea id="projectRisk_berc2" name="projectRisk_berc2" placeholder="State the risks involved"required><?php echo htmlspecialchars($_SESSION['projectRisk_berc2']); ?></textarea>
                <br>
                <br>

                <label for="projectConfidential_berc2"><b>Confidentiality:</b><br><i>Kerahsiaan:</i></label>
                <textarea id="projectConfidential_berc2" name="projectConfidential_berc2" placeholder="Include the confidentiality clause provided below"required><?php echo htmlspecialchars($_SESSION['projectConfidential_berc2']); ?></textarea>
                <br>
                <br>

             <!-- Consent Form -->
        <table>
            <tbody>
                <tr>
                    <td style="background-color: #e2e6ea; text-align: center;">
                        <strong>Consent Form<br><i>Borang Izin</i></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <!-- Statement 1 -->
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">1. I understand the nature and scope of the research being undertaken.</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Saya memahami ciri-ciri dan skop penyelidikan ini.</i></p>
                        <br>

                        <!-- Statement 2 -->
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">2. I have read and understood all the terms and conditions of my participation in the research.</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></p>
                        <br>

                        <!-- Statement 3 -->
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">3. All my questions relating to this research and my participation there in have been answered to my satisfaction.</p> 
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Saya berpuas hati dengan jawapan pada kemusykilan saya tentang penyelidikan ini.</i></p>
                        <br>

                        <!-- Statement 4 -->
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">4. I voluntarily agree to take part in this research, to follow the study procedures and to provide all necessary</p>
                        <p style="margin: 0; line-height: 1.8; text-indent: 15px;">information to the investigators as requested.</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Saya secara sukarela bersetuju menyertai penyelidikan ini dan mengikuti segala atur cara dan memberi maklumat yang</i></p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>diperlukan kepada penyelidik seperti yang dikehendaki.</i></p>
                        <br>

                        <!-- Statement 5 -->
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">5. I may at any time choose to withdraw from this research without giving any reason.</p>
                         <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Saya boleh menarik diri daripada penyelidikan ini pada bila-bila masa tanpa memberi sebab.</i></p>
                         <br>

                        <!-- Statement 6 -->
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">6. I have received a copy of the Participant Information Sheet and Consent Form.</p>
                        <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Saya telah pun menerima satu salinan Borang Maklumat Peserta dan Borang Izin.</i></p>
                        <br>

                        <!-- Statement 7 -->
                        <p style="margin: 0; line-height: 1.8; text-indent: 0px;">7. Except for damages resulting from negligent or malicious conduct of the researcher(s), I hereby release and discharge</p>
                        <p style="margin: 0; line-height: 1.8; text-indent: 15px;">UiTM and all participating researchers from all liability associated with, arising out of, or related to my participation.</p>
                        <p style="margin: 0; line-height: 1.8; text-indent: 15px;">I agree to hold them harmless from any harm or loss that may be incurred by me due to my participation in the research.</p>
                            <p style="margin: 0; line-height: 1.5; text-indent: 15px;"><i>Selain daripada kecederaan yang disebabkan oleh kelalaian dan kecuaian penyelidik, saya dengan ini melepaskan dan 
                            <p style="margin: 0; line-height: 1.5; text-indent: 15px;">menggugurkan UiTM dan semua penyelidik dari semua liabiliti berhubung dengan, wujud dari atau berkaitan dengan 
                            <p style="margin: 0; line-height: 1.5; text-indent: 15px;">penyertaan saya. Saya bersetuju untuk menjadikan mereka tidak bertanggunggjawab terhadap apa-apa kemudaratan
                            <p style="margin: 0; line-height: 1.5; text-indent: 15px;">atau kerugian yang mungkin akan saya tanggung disebabkan oleh penyertaan saya.</i></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Signatures -->
        <table>
            <tbody>
                <tr>
                <!-- Participant -->
                    <td>
                        <!-- Name -->
                        <label for="participantName_berc2"><b>Name of Participant/Legally Authorized Representative (LAR):</b><br><i>Nama Peserta/ Wakil Sah yang Berkuatkuasa:</i></label>
                        <input type="text" id="participantName_berc2" name="participantName_berc2" value="<?php echo htmlspecialchars($_SESSION['participantName_berc2']); ?>" required>
                        
                        <!-- Signature Box -->
                        <p><strong>Signature:<br><i>Tandatangan:</i></strong></p>
                    <!-- Agree to Terms Checkbox -->
                    <div class="checkbox-group">
                        <label><input type="checkbox" id="participantSignature_berc2" name="participantSignature_berc2" <?php echo (isset($_SESSION['participantSignature_berc2']) && $_SESSION['participantSignature_berc2'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.
                        <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                    </div>

                        <!-- No IC -->
                        <label for="participantIC_berc2"><b>I.C No:</b><br><i>No. Kad Pengenalan:</i></label>
                        <input type="text" id="participantIC_berc2" name="participantIC_berc2" value="<?php echo htmlspecialchars($_SESSION['participantIC_berc2']); ?>" required></label>

                         <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="participantDate_berc2" id="participantDate_berc2" style="width: 40%;" value="<?php echo htmlspecialchars($_SESSION['participantDate_berc2']); ?>">
                    </td>

                <!-- Witness -->
                    <td>
                        <!-- Name -->
                        <label for="witnessName_berc2"><b>Name of Witness:</b><br><i>Nama Saksi:</i></label>
                        <input type="text" id="witnessName_berc2" name="witnessName_berc2" value="<?php echo htmlspecialchars($_SESSION['witnessName_berc2']); ?>" required>

                        <!-- Signature Box -->
                        <p><strong>Signature:<br><i>Tandatangan:</i></strong></p>
                        <!-- Agree to Terms Checkbox -->
                    <div class="checkbox-group">
                        <label><input type="checkbox" id="witnessSignature_berc2" name="witnessSignature_berc2" <?php echo (isset($_SESSION['witnessSignature_berc2']) && $_SESSION['witnessSignature_berc2'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.
                        <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                    </div>

                        <!-- No IC -->
                        <label for="witnessIC_berc2"><b>I.C No:</b><br><i>No. Kad Pengenalan:</i></label>
                        <input type="text" id="witnessIC_berc2" name="witnessIC_berc2" value="<?php echo htmlspecialchars($_SESSION['witnessIC_berc2']); ?>" required></label>

                        <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="witnessDate_berc2" id="witnessDate_berc2" style="width: 40%;" value="<?php echo htmlspecialchars($_SESSION['witnessDate_berc2']); ?>">
                    </td>
                
                <!-- Consent Taker -->
                <tr>
                    <td>
                        <!-- Name -->
                        <label for="consentTakerName_berc2"><b>Name of Consent Taker:</b><br><i>Nama Penyelidik/Pengambil Izin:</i></label>
                        <input type="text" id="consentTakerName_berc2" name="consentTakerName_berc2" value="<?php echo htmlspecialchars($_SESSION['consentTakerName_berc2']); ?>" required>

                        <!-- Signature Box -->
                        <p><strong>Signature:<br><i>Tandatangan:</i></strong></p>
                        <!-- Agree to Terms Checkbox -->
                    <div class="checkbox-group">
                        <label><input type="checkbox" id="consentTakerSignature_berc2" name="consentTakerSignature_berc2" <?php echo (isset($_SESSION['consentTakerSignature_berc2']) && $_SESSION['consentTakerSignature_berc2'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.
                        <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                    </div>

                        <!-- No IC -->
                        <label for="consentTakerIC_berc2"><b>I.C No:</b><br><i>No. Kad Pengenalan:</i></label>
                        <input type="text" id="consentTakerIC_berc2" name="consentTakerIC_berc2" value="<?php echo htmlspecialchars($_SESSION['consentTakerIC_berc2']); ?>" required></label>

                        <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="consentTakerDate_berc2" id="consentTakerDate_berc2" style="width: 40%;" value="<?php echo htmlspecialchars($_SESSION['consentTakerDate_berc2']); ?>">
                    </td>
                </tr>
            </tbody>
        </table><br>
        <div class="button-container">
            <!-- Back button -->
            <button class="back-button" type="button" name="back" onclick="location.href='Berc1.php'">Back</button>
            <!-- Save as Draft button -->
            <button type="submit" class="submit-button" id="saveAsDraft" name="save_draft">Save as Draft</button>
            <!-- Submit button -->
            <button type="submit" class="next-button" id="submitForm" name="next">Next</button>
        </div>
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
