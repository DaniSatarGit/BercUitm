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
$query = "SELECT * FROM berc3_draft WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$draft = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['save_draft']) || isset($_POST['next']))) {

        // Assign form values to variables
        $_SESSION['projectName_berc3'] = $_POST['projectName_berc3'] ?? '';
        $_SESSION['projectDescription_berc3'] = $_POST['projectDescription_berc3'] ?? '';
        $_SESSION['projectPurpose_berc3'] = $_POST['projectPurpose_berc3'] ?? '';
        $_SESSION['projectRole_berc3'] = $_POST['projectRole_berc3'] ?? '';
        $_SESSION['projectRisk_berc3'] = $_POST['projectRisk_berc3'] ?? '';
        $_SESSION['projectParticipation_berc3'] = $_POST['projectParticipation_berc3'] ?? '';
        $_SESSION['researcherName_berc3'] = $_POST['researcherName_berc3'] ?? '';
        $_SESSION['researcherContact_berc3'] = $_POST['researcherContact_berc3'] ?? '';
        $_SESSION['confidentiality_berc3'] = $_POST['confidentiality_berc3'] ?? '';

        $_SESSION['explained_project_berc3'] = $_POST['explained_project_berc3'] ?? '';
        $_SESSION['understand_project_berc3'] = $_POST['understand_project_berc3'] ?? '';
        $_SESSION['questions_about_project_berc3'] = $_POST['questions_about_project_berc3'] ?? '';
        $_SESSION['question_answer_berc3'] = $_POST['question_answer_berc3'] ?? '';
        $_SESSION['stop_participation_berc3'] = $_POST['stop_participation_berc3'] ?? '';
        $_SESSION['ok_to_participate_berc3'] = $_POST['ok_to_participate_berc3'] ?? '';
        $_SESSION['voice_recording_berc3'] = $_POST['voice_recording_berc3'] ?? '';
        $_SESSION['on_video_berc3'] = $_POST['on_video_berc3'] ?? '';
        $_SESSION['photographs_berc3'] = $_POST['photographs_berc3'] ?? '';

        $_SESSION['participantName_berc3'] = $_POST['participantName_berc3'] ?? '';
        $_SESSION['participantSignature_berc3'] = $_POST['participantSignature_berc3'] ?? '';
        $_SESSION['participantDate_berc3'] = $_POST['participantDate_berc3'] ?? '';
        $_SESSION['consentTakerName_berc3'] = $_POST['consentTakerName_berc3'] ?? '';
        $_SESSION['consentTakerSignature_berc3'] = $_POST['consentTakerSignature_berc3'] ?? '';
        $_SESSION['consentTakerDate_berc3'] = $_POST['consentTakerDate_berc3'] ?? '';
        $_SESSION['witnessName_berc3'] = $_POST['witnessName_berc3'] ?? '';
        $_SESSION['witnessSignature_berc3'] = $_POST['witnessSignature_berc3'] ?? '';
        $_SESSION['witnessDate_berc3'] = $_POST['witnessDate_berc3'] ?? '';

        // Insert or update draft in the database
        if ($draft) {
            // Update existing draft
            $query = "UPDATE berc3_draft SET 
                projectName_berc3 = '{$_SESSION['projectName_berc3']}',
                projectDescription_berc3 = '{$_SESSION['projectDescription_berc3']}',
                projectPurpose_berc3 = '{$_SESSION['projectPurpose_berc3']}',
                projectRole_berc3 = '{$_SESSION['projectRole_berc3']}',
                projectRisk_berc3 = '{$_SESSION['projectRisk_berc3']}',
                projectParticipation_berc3 = '{$_SESSION['projectParticipation_berc3']}',
                researcherName_berc3 = '{$_SESSION['researcherName_berc3']}',
                researcherContact_berc3 = '{$_SESSION['researcherContact_berc3']}',
                confidentiality_berc3 = '{$_SESSION['confidentiality_berc3']}',
                explained_project_berc3 = '{$_SESSION['explained_project_berc3']}',
                understand_project_berc3 = '{$_SESSION['understand_project_berc3']}',
                questions_about_project_berc3 = '{$_SESSION['questions_about_project_berc3']}',
                question_answer_berc3 = '{$_SESSION['question_answer_berc3']}',
                stop_participation_berc3 = '{$_SESSION['stop_participation_berc3']}',
                ok_to_participate_berc3 = '{$_SESSION['ok_to_participate_berc3']}',
                voice_recording_berc3 = '{$_SESSION['voice_recording_berc3']}',
                on_video_berc3 = '{$_SESSION['on_video_berc3']}',
                photographs_berc3 = '{$_SESSION['photographs_berc3']}',
                participantName_berc3 = '{$_SESSION['participantName_berc3']}',
                participantSignature_berc3 = '{$_SESSION['participantSignature_berc3']}',
                participantDate_berc3 = '{$_SESSION['participantDate_berc3']}',
                consentTakerName_berc3 = '{$_SESSION['consentTakerName_berc3']}',
                consentTakerSignature_berc3 = '{$_SESSION['consentTakerSignature_berc3']}',
                consentTakerDate_berc3 = '{$_SESSION['consentTakerDate_berc3']}',
                witnessName_berc3 = '{$_SESSION['witnessName_berc3']}',
                witnessSignature_berc3 = '{$_SESSION['witnessSignature_berc3']}',
                witnessDate_berc3 = '{$_SESSION['witnessDate_berc3']}'
                WHERE user_id = '$user_id'";
        } else {
            // Insert new draft
            $query = "INSERT INTO berc3_draft (user_id, projectName_berc3, projectDescription_berc3, projectPurpose_berc3, projectRole_berc3, 
                projectRisk_berc3, projectParticipation_berc3, researcherName_berc3, researcherContact_berc3, 
                confidentiality_berc3, explained_project_berc3, understand_project_berc3, questions_about_project_berc3, 
                question_answer_berc3, stop_participation_berc3, ok_to_participate_berc3, voice_recording_berc3, 
                on_video_berc3, photographs_berc3,
                participantName_berc3, participantSignature_berc3, participantDate_berc3,
                consentTakerName_berc3, consentTakerSignature_berc3, consentTakerDate_berc3,
                witnessName_berc3, witnessSignature_berc3, witnessDate_berc3) 
                VALUES ('$user_id', '{$_SESSION['projectName_berc3']}', '{$_SESSION['projectDescription_berc3']}', '{$_SESSION['projectPurpose_berc3']}', '{$_SESSION['projectRole_berc3']}', '{$_SESSION['projectRisk_berc3']}', '{$_SESSION['projectParticipation_berc3']}', '{$_SESSION['researcherName_berc3']}', '{$_SESSION['researcherContact_berc3']}', '{$_SESSION['confidentiality_berc3']}', '{$_SESSION['explained_project_berc3']}', '{$_SESSION['understand_project_berc3']}', '{$_SESSION['questions_about_project_berc3']}', '{$_SESSION['question_answer_berc3']}', '{$_SESSION['stop_participation_berc3']}', '{$_SESSION['ok_to_participate_berc3']}', '{$_SESSION['voice_recording_berc3']}', '{$_SESSION['on_video_berc3']}', '{$_SESSION['photographs_berc3']}', '{$_SESSION['participantName_berc3']}', '{$_SESSION['participantSignature_berc3']}', '{$_SESSION['participantDate_berc3']}', '{$_SESSION['consentTakerName_berc3']}', '{$_SESSION['consentTakerSignature_berc3']}', '{$_SESSION['consentTakerDate_berc3']}', '{$_SESSION['witnessName_berc3']}', '{$_SESSION['witnessSignature_berc3']}', '{$_SESSION['witnessDate_berc3']}')";
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

        // If the "Next" button is pressed, redirect to the next page
        if (isset($_POST['next'])) {
            header("Location: Berc5.php");
        }
    } else {
        // Populate form with existing draft values if no form submission
            $_SESSION['projectName_berc3'] = $draft['projectName_berc3'] ?? '';
            $_SESSION['projectDescription_berc3'] = $draft['projectDescription_berc3'] ?? '';
            $_SESSION['projectPurpose_berc3'] = $draft['projectPurpose_berc3'] ?? '';
            $_SESSION['projectRole_berc3'] = $draft['projectRole_berc3'] ?? '';
            $_SESSION['projectRisk_berc3'] = $draft['projectRisk_berc3'] ?? '';
            $_SESSION['projectParticipation_berc3'] = $draft['projectParticipation_berc3'] ?? '';
            $_SESSION['researcherName_berc3'] = $draft['researcherName_berc3'] ?? '';
            $_SESSION['researcherContact_berc3'] = $draft['researcherContact_berc3'] ?? '';
            $_SESSION['confidentiality_berc3'] = $draft['confidentiality_berc3'] ?? '';
            $_SESSION['explained_project_berc3'] = $draft['explained_project_berc3'] ?? '';
            $_SESSION['understand_project_berc3'] = $draft['understand_project_berc3'] ?? '';
            $_SESSION['questions_about_project_berc3'] = $draft['questions_about_project_berc3'] ?? '';
            $_SESSION['question_answer_berc3'] = $draft['question_answer_berc3'] ?? '';
            $_SESSION['stop_participation_berc3'] = $draft['stop_participation_berc3'] ?? '';
            $_SESSION['ok_to_participate_berc3'] = $draft['ok_to_participate_berc3'] ?? '';
            $_SESSION['voice_recording_berc3'] = $draft['voice_recording_berc3'] ?? '';
            $_SESSION['on_video_berc3'] = $draft['on_video_berc3'] ?? '';
            $_SESSION['photographs_berc3'] = $draft['photographs_berc3'] ?? '';
            $_SESSION['participantName_berc3'] = $draft['participantName_berc3'] ?? '';
            $_SESSION['participantSignature_berc3'] = $draft['participantSignature_berc3'] ?? '';
            $_SESSION['participantDate_berc3'] = $draft['participantDate_berc3'] ?? '';
            $_SESSION['consentTakerName_berc3'] = $draft['consentTakerName_berc3'] ?? '';
            $_SESSION['consentTakerSignature_berc3'] = $draft['consentTakerSignature_berc3'] ?? '';
            $_SESSION['consentTakerDate_berc3'] = $draft['consentTakerDate_berc3'] ?? '';
            $_SESSION['witnessName_berc3'] = $draft['witnessName_berc3'] ?? '';
            $_SESSION['witnessSignature_berc3'] = $draft['witnessSignature_berc3'] ?? '';
            $_SESSION['witnessDate_berc3'] = $draft['witnessDate_berc3'] ?? '';
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assent Form</title>
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

        /* Label Styling */
        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
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
            display: inline-flex;
            align-items: center;
            margin-top: 10px;
        }

        .radio-group input[type="radio"] {
            margin-right: 5px;
             display: flex;
            align-items: center;
            text-align: center;
        }

        .radio-group label {
            margin-left: 5px;
            margin-right: 20px;
            text-align: flex;
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

        .section h3 {
            font-size: 16px;
        }

        .section i {
            font-size: 12px;
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
            font-size: 12px;
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
                <li><a class="active">BERC3</a></li>
                <li><a href="Berc5.php">BERC5</a></li>
               
            </ul>
        </nav>
    <div class="container">
        <div class="header">
            <img src="image/Uitm.png" alt="University Logo">
            <h3>Universiti Teknologi MARA</h3>
            <h5>13500 Permatang Pauh</h5>
            <h6>Tel: 04-382 2888 | Faks: 04-382 2776</h6>
            <h4>Assent Form</h4>
            <p><i>Borang Persetujuan Menyertai Projek</i></p>
        </div>

        <!-- Assent Form -->
        <form id="myForm" method="post">
            <p>Your parent/legally authorized representative (LAR) has given permission for you to be in a project called [state name of project here]. We would like to explain it to you, so that you can decide if you want to be in it. If you don’t understand, please ask questions. You can choose to be in the study, or not to be in the study, or to take more time to decide.</p>
            <p><i>Ibu bapa / wakil sah anda (LAR) telah memberi izin untuk anda menyertai projek yang bertajuk (nyatakan nama projek penyelidikan di sini). Kami ingin memberi penerangan mengenai projek tersebut, supaya anda boleh membuat keputusan sendiri sama ada ingin menyertai projek tersebut ataupun tidak. Ada boleh tanya soalan sekiranya tidak faham. Anda boleh memilih sama ada untuk menyertai projek tersebut, atau tidak. Anda juga boleh mengambil lebih masa sebelum membuat keputusan.</i></p>

            <div class="section">
                <h3>Assent Form Details<br><i>Butiran Borang Persetujuan</i></h3>

                <!-- Statement 1 -->
                <label for="projectName"><strong>Project Name:</strong><br><i>Nama Projek:</i></label>
                <input type="text" id="projectName_berc3" name="projectName_berc3" value="<?php echo htmlspecialchars($_SESSION['projectName_berc3']); ?>">
                <br>
                <br>

                <!-- Statement 2 -->
                <label for="projectDescription"><strong>What is the project about?</strong><br><i>Projek ini mengenai apa?</i></label>
                <textarea id="projectDescription_berc3" name="projectDescription_berc3" rows="6" placeholder="Briefly describe the project" required><?php echo htmlspecialchars
                ($_SESSION['projectDescription_berc3']); ?></textarea>
                <br>
                <br>

                <!-- Statement 3 -->
                <label for="projectPurpose"><strong>Why do I need to be in this project?</strong><br><i>Mengapa saya patut menyertai projek ini?</i></label>
                <textarea id="projectPurpose_berc3" name="projectPurpose_berc3" rows="6" placeholder="Briefly describe the purpose of the project" required><?php echo htmlspecialchars($_SESSION['projectPurpose_berc3']); ?></textarea>
                <br>
                <br>

                <!-- Statement 4 -->
                <label for="projectRole"><strong>What should I do in this project?</strong><br><i>Apa yang perlu saya lakukan dalam projek ini?</i></label>
                <textarea id="projectRole_berc3" name="projectRole_berc3" rows="6" placeholder="Briefly explain the minor’s role in the project" required><?php echo htmlspecialchars($_SESSION['projectRole_berc3']); ?></textarea>
                <br>
                <br>

                <!-- Statement 5 -->
                <label for="projectRisk"><strong>What will happen to me in the project?</strong><br><i>Apa yang akan berlaku kepada saya dalam projek ini?</i></label>
                <textarea id="projectRisk_berc3" name="projectRisk_berc3" rows="6" placeholder="Briefly explain the risk" required><?php echo htmlspecialchars($_SESSION['projectRisk_berc3']); ?></textarea>
                <br>
                <br>

                <!-- Statement 6 -->
                <label for="projectParticipation_berc3"><strong></hr>Do I have to be in the project?</strong><br><i>Adakah saya perlu menyertai projek ini?</i>
                    <hr>You don’t have to be in the project if you don’t want to. If you are in the project, you can stop at any time without making anyone upset. If you want to be in the project, please write your name below. Please make sure that you understand what has been explained to you.
                    <p><i>Anda tidak perlu menyertai projek ini jika anda tidak mahu. Sekiranya anda menyertai projek ini, anda boleh berhenti pada bila-bila masa tanpa membuat sesiapa marah. Jika anda ingin menyertai projek ini, sila tulis nama anda di bawah. Sila pastikan bahawa anda faham apa yang telah dijelaskan kepada anda.</i></label>
                <textarea id="projectParticipation_berc3" name="projectParticipation_berc3" required><?php echo htmlspecialchars($_SESSION['projectParticipation_berc3']); ?></textarea>
                <br>
                <br>
                <br>

                <!-- Statement 7 -->
                <label for="researcherReference"><strong></hr>Who can I talk to about this project?</strong><br><i>Dengan siapa boleh saya bercakap mengenai projek ini?</i>
                    <hr>If you want to ask anything, you can call me anytime.<br><i>Jika anda mempunyai apa-apa soalan, anda boleh menghubungi saya:</i></label>
                 <!-- Name -->
                <div class="text">
                        <label for="researcherName_berc3"><b>Name of Researcher:</b><br><i>Nama Penyelidik:</i></label>
                        <input type="text" id="researcherName_berc3" name="researcherName_berc3" style="width: 70%" value="<?php echo htmlspecialchars($_SESSION['researcherName_berc3']); ?>">
                </div>
                <br>
                <!-- Contact No. -->
                <div class="text">
                        <label for="researcherContact_berc3"><b>Contact Number:</b><br><i>Nombor Telefon:</i></label>
                        <input type="text" id="researcherContact_berc3" name="researcherContact_berc3" style="width: 50%" value="<?php echo htmlspecialchars($_SESSION['researcherContact_berc3']); ?>">
                </div>
                <br>
                <br>
                <br>

                <!-- Statement 8 -->
                <label for="confidentiality_berc3"><strong></hr>Will anyone know about what I say or do in the project?</strong><br><i>Adakah orang lain akan tahu tentang apa yang saya katakan atau lakukan dalam projek ini?</i><hr>Briefly explain the anonymity and confidentiality of research participation.<br><i>Terangkan secara ringkas mengenai kerahsiaan penyertaan penyelidikan.</i></label>
                <textarea id="confidentiality_berc3"  name="confidentiality_berc3" rows="6" required><?php echo htmlspecialchars($_SESSION['confidentiality_berc3']); ?></textarea></textarea>
                <br>
                <br>

                <!-- Assent Questions Table -->
                <h4></hr>ASSENT QUESTIONS<br><i>Soalan Persetujuan</i><hr></h4>
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                    <thead>
                        <tr>
                            <th style="padding: 10px; border: 0px solid #000;"></th>
                            <th style="padding: 10px; border: 0px solid #000;"><i>Assent Questions</i></th>
                            <th style="padding: 10px; border: 1px solid #000;">Yes</th>
                            <th style="padding: 10px; border: 1px solid #000;">No</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Question 1 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">1.</td>
                            <td style="padding: 10px; border: 1px solid #000;">Has somebody explained this project to you?<br><i>Sudahkah projek ini dijelaskan kepada anda?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="explained_project_berc3" value="Yes" <?php echo ($_SESSION['explained_project_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="explained_project_berc3" value="No" <?php echo ($_SESSION['explained_project_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                        <!-- Question 2 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">2.</td>
                            <td style="padding: 10px; border: 1px solid #000;">Do you understand what this project is about?<br><i>Adakah anda memahami projek ini?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="understand_project_berc3" value="Yes" <?php echo ($_SESSION['understand_project_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="understand_project_berc3" value="No" <?php echo ($_SESSION['understand_project_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                        <!-- Question 3 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">3.</td>
                            <td style="padding: 10px; border: 1px solid #000;">Do you have any questions about the project?<br><i>Adakah anda mempunyai apa-apa soalan mengenai projek ini?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="questions_about_project_berc3" value="Yes" <?php echo ($_SESSION['questions_about_project_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="questions_about_project_berc3" value="No" <?php echo ($_SESSION['questions_about_project_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                         <!-- Question 4 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">4.</td>
                            <td style="padding: 10px; border: 1px solid #000;"> If you have asked a question, do you understand the answer?<br><i>Jika anda telah bertanya, adakah anda memahami jawapannya?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="question_answer_berc3" value="Yes" <?php echo ($_SESSION['question_answer_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="question_answer_berc3" value="No" <?php echo ($_SESSION['question_answer_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                         <!-- Question 5 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">5.</td>
                            <td style="padding: 10px; border: 1px solid #000;">Do you understand it’s ok to stop taking part at any time?<br>
                                <i>Adakah anda faham bahawa anda boleh berhenti daripada projek ini pada bila-bila masa?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="stop_participation_berc3" value="Yes" <?php echo ($_SESSION['stop_participation_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="stop_participation_berc3" value="No" <?php echo ($_SESSION['stop_participation_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                         <!-- Question 6 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">6.</td>
                            <td style="padding: 10px; border: 1px solid #000;">Are you okay to take part?<br><i>Adakah anda selesa untuk mengambil bahagian dalam projek ini?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="ok_to_participate_berc3" value="Yes" <?php echo ($_SESSION['ok_to_participate_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="ok_to_participate_berc3" value="No" <?php echo ($_SESSION['ok_to_participate_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                         <!-- Question 7 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">7.</td>
                            <td style="padding: 10px; border: 1px solid #000;">Are you okay for your voice to be recorded?<br><i>Adakah anda selesa sekiranya suara anda direkodkan?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="voice_recording_berc3" value="Yes" <?php echo ($_SESSION['voice_recording_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="voice_recording_berc3" value="No" <?php echo ($_SESSION['voice_recording_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                         <!-- Question 8 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">8.</td>
                            <td style="padding: 10px; border: 1px solid #000;">Are you okay to be on video?<br><i>Adakah anda selesa sekiranya berada dalam video?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="on_video_berc3" value="Yes" <?php echo ($_SESSION['on_video_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="on_video_berc3" value="No" <?php echo ($_SESSION['on_video_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                         <!-- Question 9 -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid #000;">9.</td>
                            <td style="padding: 10px; border: 1px solid #000;">Are you okay to have photographs taken?<br><i>Adakah anda selesa sekiranya gambar anda diambil?</i></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="photographs_berc3" value="Yes" <?php echo ($_SESSION['photographs_berc3'] == 'Yes') ? 'checked' : ''; ?>></td>
                            <td style="padding: 10px; border: 1px solid #000;"><input type="radio" name="photographs_berc3" value="No" <?php echo ($_SESSION['photographs_berc3'] == 'No') ? 'checked' : ''; ?>></td>
                        </tr>
                     </tbody>
                </table>
                <br>
                <br>


            <!-- Signatures -->
        <table>
            <tbody>
                <tr>
                <!-- Participant -->
                    <td>
                        <!-- Name -->
                        <label for="participantName_berc3"><b>Name of Participant:</b><br><i>Nama Peserta:</i></label>
                        <input type="text" id="participantName_berc3" name="participantName_berc3" value="<?php echo htmlspecialchars($_SESSION['participantName_berc3']); ?>" required>
                        
                        <!-- Signature Box -->
                        <p><strong>Signature:<br><i>Tandatangan:</i></strong></p>
                        <!-- Agree to Terms Checkbox -->
                    <div class="checkbox-group">
                        <label><input type="checkbox" id="participantSignature_berc3" name="participantSignature_berc3" <?php echo (isset($_SESSION['participantSignature_berc3']) && $_SESSION['participantSignature_berc3'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.
                        <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                    </div>

                     <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="participantDate_berc3" id="participantDate_berc3" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['participantDate_berc3']); ?>">
                    </td>

                <!-- Consent Taker -->
                    <td>
                    <!-- Name -->
                        <label for="consentTakerName_berc3"><b>Name of Consent Taker</b><br><i>Nama Pengambil Persetujuan</i></label>
                        <input type="text" id="consentTakerName_berc3" name="consentTakerName_berc3" value="<?php echo htmlspecialchars($_SESSION['consentTakerName_berc3']); ?>" required>
                        
                        <!-- Signature Box -->
                        <p><strong>Signature:<br><i>Tandatangan:</i></strong></p>
                        <!-- Agree to Terms Checkbox -->
                    <div class="checkbox-group">
                        <label><input type="checkbox" id="consentTakerSignature_berc3" name="consentTakerSignature_berc3" <?php echo (isset($_SESSION['consentTakerSignature_berc3']) && $_SESSION['consentTakerSignature_berc3'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.
                        <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                    </div>

                     <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="consentTakerDate_berc3" id="consentTakerDate_berc3" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['consentTakerDate_berc3']); ?>">
                    </td>

                     <p><i>(In instances where the minor is unable to read, or where the research covers sensitive issues, a witness should attest in the section below)</i></p>

                <!-- Witness -->
                    <td>
                    <!-- Name -->
                        <label for="witnessName_berc3"><b>Name of Witness</b><br><i>Nama saksi</i></label>
                        <input type="text" id="witnessName_berc3" name="witnessName_berc3" value="<?php echo htmlspecialchars($_SESSION['witnessName_berc3']); ?>" required>
                        
                        <!-- Signature Box -->
                        <p><strong>Signature:<br><i>Tandatangan:</i></strong></p>
                        <!-- Agree to Terms Checkbox -->
                    <div class="checkbox-group">
                        <label><input type="checkbox" id="witnessSignature_berc3" name="witnessSignature_berc3" <?php echo (isset($_SESSION['witnessSignature_berc3']) && $_SESSION['witnessSignature_berc3'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.
                        <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                    </div>

                     <!-- Date -->
                        <p><b>Date:</b><br><i>Tarikh:</i></p>
                        <input type="date" name="witnessDate_berc3" id="witnessDate_berc3" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['witnessDate_berc3']); ?>">
                    </td>
                </tr>
            </tbody>
        </table><br>
        <div class="button-container">
            <!-- Back button -->
            <button class="back-button" type="button" name="back" onclick="location.href='Berc2.php'">Back</button>
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
