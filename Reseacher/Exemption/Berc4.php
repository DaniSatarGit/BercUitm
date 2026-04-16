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
$query = "SELECT * FROM berc4_draft WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$draft = $result->fetch_assoc();


// Jika borang dihantar untuk simpan sebagai draf, gunakan nilai yang diserahkan dari $_POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['save_draft']) || isset($_POST['next']))) {
    // Gunakan nilai borang yang dihantar untuk mengisi semula borang
    $_SESSION['research_title'] = $_POST['research_title'] ?? '';
    $_SESSION['researcher_name'] = $_POST['researcher_name'] ?? '';
    $_SESSION['supervisor_name'] = $_POST['supervisor_name'] ?? '';
    $_SESSION['dept_address'] = $_POST['dept_address'] ?? '';
    $_SESSION['contact_info'] = $_POST['contact_info'] ?? '';
    $_SESSION['study_level'] = $_POST['study_level'] ?? '';
    $_SESSION['research_just'] = $_POST['research_just'] ?? '';
    $_SESSION['research_obj'] = $_POST['research_obj'] ?? '';
    $_SESSION['research_method'] = $_POST['research_method'] ?? '';
    $_SESSION['research_signif'] = $_POST['research_signif'] ?? '';
    $_SESSION['research_risks'] = $_POST['research_risks'] ?? '';
    $_SESSION['ethical_exempt_just'] = $_POST['ethical_exempt_just'] ?? [];  // Simpan sebagai array
    $_SESSION['app_name'] = $_POST['app_name'] ?? '';
    $_SESSION['app_id'] = $_POST['app_id'] ?? '';
    $_SESSION['app_position'] = $_POST['app_position'] ?? '';
    $_SESSION['app_affiliation'] = $_POST['app_affiliation'] ?? '';
    $_SESSION['app_office'] = $_POST['app_office'] ?? '';
    $_SESSION['app_mobile'] = $_POST['app_mobile'] ?? '';
    $_SESSION['app_email'] = $_POST['app_email'] ?? '';
    $_SESSION['app_date'] = $_POST['app_date'] ?? '';
    $_SESSION['app_signature'] = $_POST['app_signature'] ?? '';
    $_SESSION['cb_signature'] = $_POST['cb_signature'] ?? '';
    $_SESSION['cb_stamp'] = $_POST['cb_stamp'] ?? '';
    $_SESSION['sv_name'] = $_POST['sv_name'] ?? '';
    $_SESSION['sv_id'] = $_POST['sv_id'] ?? '';
    $_SESSION['sv_position'] = $_POST['sv_position'] ?? '';
    $_SESSION['sv_affiliation'] = $_POST['sv_affiliation'] ?? '';
    $_SESSION['sv_office'] = $_POST['sv_office'] ?? '';
    $_SESSION['sv_mobile'] = $_POST['sv_mobile'] ?? '';
    $_SESSION['sv_email'] = $_POST['sv_email'] ?? '';
    $_SESSION['sv_signature'] = $_POST['sv_signature'] ?? '';
    $_SESSION['sv_date'] = $_POST['sv_date'] ?? '';
    $_SESSION['cores_name'] = $_POST['cores_name'] ?? '';
    $_SESSION['cores_id'] = $_POST['cores_id'] ?? '';
    $_SESSION['cores_position'] = $_POST['cores_position'] ?? '';
    $_SESSION['cores_affiliation'] = $_POST['cores_affiliation'] ?? '';
    $_SESSION['cores_office'] = $_POST['cores_office'] ?? '';
    $_SESSION['cores_mobile'] = $_POST['cores_mobile'] ?? '';
    $_SESSION['cores_email'] = $_POST['cores_email'] ?? '';
    $_SESSION['cores_signature'] = $_POST['cores_signature'] ?? '';
    $_SESSION['cores_date'] = $_POST['cores_date'] ?? '';
    $_SESSION['submission_date'] = $_POST['submission_date'] ?? '';
    
    // Insert or update draft in the database
    if ($draft) {
        // Update existing draft
        $query = "UPDATE berc4_draft SET
            research_title = '{$_SESSION['research_title']}', researcher_name = '{$_SESSION['researcher_name']}', supervisor_name = '{$_SESSION['supervisor_name']}',
            dept_address = '{$_SESSION['dept_address']}', contact_info = '{$_SESSION['contact_info']}', study_level = '{$_SESSION['study_level']}',
            research_just = '{$_SESSION['research_just']}', research_obj = '{$_SESSION['research_obj']}', research_method = '{$_SESSION['research_method']}',
            research_signif = '{$_SESSION['research_signif']}', research_risks = '{$_SESSION['research_risks']}', ethical_exempt_just = '" . implode(",", $_SESSION['ethical_exempt_just']) . "',
            app_name = '{$_SESSION['app_name']}', app_id = '{$_SESSION['app_id']}', app_position = '{$_SESSION['app_position']}', app_affiliation = '{$_SESSION['app_affiliation']}',
            app_office = '{$_SESSION['app_office']}', app_mobile = '{$_SESSION['app_mobile']}', app_email = '{$_SESSION['app_email']}', app_date = '{$_SESSION['app_date']}',
            app_signature = '{$_SESSION['app_signature']}', cb_signature = '{$_SESSION['cb_signature']}', cb_stamp = '{$_SESSION['cb_stamp']}',
            sv_name = '{$_SESSION['sv_name']}', sv_id = '{$_SESSION['sv_id']}', sv_position = '{$_SESSION['sv_position']}', sv_affiliation = '{$_SESSION['sv_affiliation']}',
            sv_office = '{$_SESSION['sv_office']}', sv_mobile = '{$_SESSION['sv_mobile']}', sv_email = '{$_SESSION['sv_email']}', sv_signature = '{$_SESSION['sv_signature']}', sv_date = '{$_SESSION['sv_date']}',
            cores_name = '{$_SESSION['cores_name']}', cores_id = '{$_SESSION['cores_id']}', cores_position = '{$_SESSION['cores_position']}', cores_affiliation = '{$_SESSION['cores_affiliation']}',
            cores_office = '{$_SESSION['cores_office']}', cores_mobile = '{$_SESSION['cores_mobile']}', cores_email = '{$_SESSION['cores_email']}', cores_signature = '{$_SESSION['cores_signature']}',
            cores_date = '{$_SESSION['cores_date']}', submission_date = '{$_SESSION['submission_date']}', saved_at = NOW()
            WHERE user_id = '$user_id'";
    } else {
        // Insert new draft
        $query = "INSERT INTO berc4_draft (user_id, research_title, researcher_name, supervisor_name, dept_address, contact_info, study_level,
            research_just, research_obj, research_method, research_signif, research_risks, ethical_exempt_just, app_name, app_id,
            app_position, app_affiliation, app_office, app_mobile, app_email, app_date,
            app_signature, cb_signature, cb_stamp, sv_name, sv_id, sv_position, sv_affiliation, sv_office, sv_mobile, sv_email, 
            sv_signature, sv_date, cores_name, cores_id, cores_position, cores_affiliation, cores_office, cores_mobile, cores_email, 
            cores_signature, cores_date, submission_date)
            VALUES ('$user_id', '{$_SESSION['research_title']}', '{$_SESSION['researcher_name']}', '{$_SESSION['supervisor_name']}', '{$_SESSION['dept_address']}', '{$_SESSION['contact_info']}',
            '{$_SESSION['study_level']}', '{$_SESSION['research_just']}', '{$_SESSION['research_obj']}', '{$_SESSION['research_method']}', '{$_SESSION['research_signif']}', '{$_SESSION['research_risks']}',
            '" . implode(",", $_SESSION['ethical_exempt_just']) . "', '{$_SESSION['app_name']}', '{$_SESSION['app_id']}', '{$_SESSION['app_position']}', '{$_SESSION['app_affiliation']}', '{$_SESSION['app_office']}', '{$_SESSION['app_mobile']}', '{$_SESSION['app_email']}', '{$_SESSION['app_date']}',
            '{$_SESSION['app_signature']}', '{$_SESSION['cb_signature']}', '{$_SESSION['cb_stamp']}', '{$_SESSION['sv_name']}', '{$_SESSION['sv_id']}', '{$_SESSION['sv_position']}', '{$_SESSION['sv_affiliation']}', '{$_SESSION['sv_office']}', '{$_SESSION['sv_mobile']}',
            '{$_SESSION['sv_email']}', '{$_SESSION['sv_signature']}', '{$_SESSION['sv_date']}', '{$_SESSION['cores_name']}', '{$_SESSION['cores_id']}', '{$_SESSION['cores_position']}', '{$_SESSION['cores_affiliation']}', '{$_SESSION['cores_office']}',
            '{$_SESSION['cores_mobile']}', '{$_SESSION['cores_email']}', '{$_SESSION['cores_signature']}', '{$_SESSION['cores_date']}', '{$_SESSION['submission_date']}')";
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
            header("Location: Berc5.php");
            exit();
        }
} else {
    // Populate the form with the draft values if no submission
    $_SESSION['research_title'] = $draft['research_title'] ?? '';
    $_SESSION['researcher_name'] = $draft['researcher_name'] ?? '';
    $_SESSION['supervisor_name'] = $draft['supervisor_name'] ?? '';
    $_SESSION['dept_address'] = $draft['dept_address'] ?? '';
    $_SESSION['contact_info'] = $draft['contact_info'] ?? '';
    $_SESSION['study_level'] = $draft['study_level'] ?? '';
    $_SESSION['research_just'] = $draft['research_just'] ?? '';
    $_SESSION['research_obj'] = $draft['research_obj'] ?? '';
    $_SESSION['research_method'] = $draft['research_method'] ?? '';
    $_SESSION['research_signif'] = $draft['research_signif'] ?? '';
    $_SESSION['research_risks'] = $draft['research_risks'] ?? '';
    $_SESSION['ethical_exempt_just'] = explode(",", $draft['ethical_exempt_just'] ?? '');  // Convert string to array
    $_SESSION['app_name'] = $draft['app_name'] ?? '';
    $_SESSION['app_id'] = $draft['app_id'] ?? '';
    $_SESSION['app_position'] = $draft['app_position'] ?? '';
    $_SESSION['app_affiliation'] = $draft['app_affiliation'] ?? '';
    $_SESSION['app_office'] = $draft['app_office'] ?? '';
    $_SESSION['app_mobile'] = $draft['app_mobile'] ?? '';
    $_SESSION['app_email'] = $draft['app_email'] ?? '';
    $_SESSION['app_date'] = $draft['app_date'] ?? '';
    $_SESSION['app_signature'] = $draft['app_signature'] ?? '';
    $_SESSION['cb_signature'] = $draft['cb_signature'] ?? '';
    $_SESSION['cb_stamp'] = $draft['cb_stamp'] ?? '';
    $_SESSION['sv_name'] = $draft['sv_name'] ?? '';
    $_SESSION['sv_id'] = $draft['sv_id'] ?? '';
    $_SESSION['sv_position'] = $draft['sv_position'] ?? '';
    $_SESSION['sv_affiliation'] = $draft['sv_affiliation'] ?? '';
    $_SESSION['sv_office'] = $draft['sv_office'] ?? '';
    $_SESSION['sv_mobile'] = $draft['sv_mobile'] ?? '';
    $_SESSION['sv_email'] = $draft['sv_email'] ?? '';
    $_SESSION['sv_signature'] = $draft['sv_signature'] ?? '';
    $_SESSION['sv_date'] = $draft['sv_date'] ?? '';
    $_SESSION['cores_name'] = $draft['cores_name'] ?? '';
    $_SESSION['cores_id'] = $draft['cores_id'] ?? '';
    $_SESSION['cores_position'] = $draft['cores_position'] ?? '';
    $_SESSION['cores_affiliation'] = $draft['cores_affiliation'] ?? '';
    $_SESSION['cores_office'] = $draft['cores_office'] ?? '';
    $_SESSION['cores_mobile'] = $draft['cores_mobile'] ?? '';
    $_SESSION['cores_email'] = $draft['cores_email'] ?? '';
    $_SESSION['cores_signature'] = $draft['cores_signature'] ?? '';
    $_SESSION['cores_date'] = $draft['cores_date'] ?? '';
    $_SESSION['submission_date'] = $draft['submission_date'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethics Approval Application Form</title>
    <link rel="stylesheet" href="berc4.css">
</head>
<body>
        <nav>
            <ul>
                <li><a href="../ReseacherPage.php" style="font-weight: bold;">HOME</a></li>
                <li><a class="active">BERC4</a></li>
                <li><a href="Berc5.php">BERC5</a></li>
            </ul>
        </nav>
    <div class="container">
        <div class="header">
            <img src="image/Uitm.png" alt="University Logo">
            <h3>Universiti Teknologi MARA</h3>
            <h5>13500 Permatang Pauh</h5>
            <h6>Tel: 04-382 2888 | Faks: 04-382 2776</h6>
            <h4>Application for Exemption from Ethical Review</h4>
            <p><i>Permohonan Pengeculian daripada Semakan Etika</i></p>
        </div>

        <p>Please attach a copy of the Research Proposal.
        <br><i>Sila lampirkan salinan kertas cadangan penyelidikan.</i></p>

        <form id="myForm" method="post">
        <!-- Part A: Details of Researcher -->
        <div class="section">
            <h3>Part A: Details of Researcher<br><i>Bahagian A: Maklumat Penyelidik</i></h3>
            
            <!-- Title -->
            <label for="research_title"><b>Title of Research Project:</b><br><i>Tajuk Penyelidikan:</i></label>
            <input type="text" id="research_title" name="research_title" value="<?php echo htmlspecialchars($_SESSION['research_title']); ?>" required>
            <br><br>

            <!-- Researcher Name -->
            <label for="researcher_name"><b>Name of Researcher:</b><br><i>Nama Penyelidik:</i></label>
            <input type="text" id="researcher_name" name="researcher_name" value="<?php echo htmlspecialchars($_SESSION['researcher_name']); ?>" required>
            <br><br>

            <!-- Supervisor Name -->
            <label for="supervisor_name"><b>Name of Supervisor:</b><br><i>Nama Penyelia:</i></label>
            <input type="text" id="supervisor_name" name="supervisor_name" value="<?php echo htmlspecialchars($_SESSION['supervisor_name']); ?>" required>
            <br><br>

            <!-- Department Address -->
            <label for="dept_address"><b>Address of Department/Institute:</b><br><i>Alamat Jabatan/Institut:</i></label>
            <textarea id="dept_address" name="dept_address" rows="4" required><?php echo htmlspecialchars($_SESSION['dept_address']); ?></textarea>
            <br><br>

            <!-- Contact Info -->
            <label for="contact_info"><b>Contact No/Email:</b><br><i>No. Telefon/Emel:</i></label>
            <input type="text" id="contact_info" name="contact_info" value="<?php echo htmlspecialchars($_SESSION['contact_info']); ?>" required>
            <br><br>

            <!-- Researcher Level -->
            <label><b>Level of Study:</b></label>
            <div class="radio-group">
                <label>
                    <input type="radio" id="researcher_level_undergraduate" name="study_level" value="undergraduate" <?php echo ($_SESSION['study_level'] == 'undergraduate') ? 'checked' : ''; ?> required>
                    Undergraduate / <i>Sarjana Muda</i>
                </label>
                <label>
                    <input type="radio" id="researcher_level_postgraduate" name="study_level" value="postgraduate" <?php echo ($_SESSION['study_level'] == 'postgraduate') ? 'checked' : ''; ?>>
                    Postgraduate by Coursework / <i>Pasca Siswazah Kerja Kursus</i>
                </label>
            </div>
            <br><br>
        </div>

        <!-- Part B: Research Details -->
        <div class="section">
            <h3>Part B: Research Details<br><i>Bahagian B: Maklumat Penyelidikan</i></h3>
            <p><b>Executive Summary</b><br>(Please include research justification, objectives, research methodology, significance, risks)</p>
            <p><i><b>Ringkasan Eksekutif</b><br>(Sila masukkan justifikasi, objektif, metodologi, kepentingan dan risiko penyelidikan)</i></p>
            <br>

            <!-- Research Justification -->
            <label for="research_just"><b>1. Research Justification</b><br><i>Justifikasi Penyelidikan</i></label>
            <textarea id="research_just" name="research_just" rows="6" placeholder="A brief explanation of the problem to be studied..." required><?php echo htmlspecialchars($_SESSION['research_just']); ?></textarea>
            <br><br>

            <!-- Research Objectives -->
            <label for="research_obj"><b>2. Research Objectives</b><br><i>Penyataan Objektif</i></label>
            <textarea id="research_obj" name="research_obj" rows="4" required><?php echo htmlspecialchars($_SESSION['research_obj']); ?></textarea>
            <br><br>

            <!-- Research Methodology -->
            <label for="research_method"><b>3. Research Methodology (including sample size, if applicable)</b><br><i>Metodologi Penyelidikan (termasuk saiz sampel, sekiranya ada)</i></label>
            <textarea id="research_method" name="research_method" rows="4" required><?php echo htmlspecialchars($_SESSION['research_method']); ?></textarea>
            <br><br>

            <!-- Research Significance -->
            <label for="research_signif"><b>4. Research Significance</b><br><i>Kepentingan Penyelidikan</i></label>
            <textarea id="research_signif" name="research_signif" rows="4" required><?php echo htmlspecialchars($_SESSION['research_signif']); ?></textarea>
            <br><br>

            <!-- Research Risks -->
            <label for="research_risks"><b>5. Research Risks</b><br><i>Risiko Penyelidikan</i></label>
            <textarea id="research_risks" name="research_risks" rows="4" required><?php echo htmlspecialchars($_SESSION['research_risks']); ?></textarea>
            <br><br>
        </div>
               
        <!-- Part C: Justification from Ethical Review -->
        <div class="section">
            <h3>Part C : Justification for Exemption from Ethical Review<br><i>Bahagian C: Justifikasi Pengecualian daripada Semakan Etika</i></h3>

            <!-- Research Methods Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 10px; background-color: #007bff; color: white;">
                            Please tick where applicable, can be more than one<br>
                            <i>tandakan yang berkenaan, boleh melebihi daripada satu</i>
                        </th>
                        <th style="text-align: center; padding: 10px; background-color: #007bff; color: white;">Select</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Option 1 -->
                    <tr>
                        <td style="padding: 15px;">
                            This research does not involve human participants, human tissues and/or biological samples.
                            <br><i>Penyelidikan ini tidak melibatkan peserta manusia, tisu manusia dan/atau sampel biologi.</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="involving-human" 
                        <?php echo (in_array('involving-human', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 2 -->
                    <tr>
                        <td style="padding: 15px;">
                            This research does not collect sensitive* and identifiable secondary data of an individual.
                            <br><i>Penyelidikan ini tidak mengumpul data sekunder yang sensitif * dan yang dapat dikenal pasti identiti individu.</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="collect-data" 
                        <?php echo (in_array('collect-data', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 3 -->
                    <tr>
                        <td style="padding: 15px;">
                            This research involves content analysis / textual analysis / meta-analysis. (E.g.: non-identifiable data lawfully collected, public/private records, published/unpublished reports, and documents available in libraries, repositories, archives, websites.)
                            <br><i>Penyelidikan ini melibatkan analisa kandungan / teks / meta-analisis. (Contoh: pengumpulan data yang tidak akan dapat dikenal pasti identiti diperolehi secara sah daripada rekod awam / swasta, laporan yang diterbitkan / tidak diterbitkan, dan dokumen yang terdapat di perpustakaan, repositori, arkib, laman web)</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="analysis-study" 
                        <?php echo (in_array('analysis-study', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 4 -->
                    <tr>
                        <td style="padding: 15px;">
                            Case study / doctrinal study / policy study that utilizes a qualitative approach that does not involve human participants / sensitive* / identifiable data of an individual.
                            <br><i>Kajian kes / kajian doktrin / kajian dasar yang menggunakan pendekatan kualitatif serta tidak melibatkan peserta manusia / data sensitif * / data yang dapat dikenal pasti identiti individu.</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="case-study" 
                        <?php echo (in_array('case-study', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 5 -->
                    <tr>
                        <td style="padding: 15px;">
                            Concept paper which synthesizes knowledge from the previous study on a particular topic and presents it in a new context with the aims to fill knowledge gaps. This research does not involve human participants and does not collect sensitive* and identifiable data of an individual.
                            <br><i>Kertas konsep yang mensintesis pengetahuan dari hasil kajian lampau mengenai topik tertentu dan membentangkannya dalam konteks baru dengan tujuan merapatkan jurang pengetahuan. Penyelidikan ini tidak melibatkan peserta manusia dan tidak mengumpulkan data sensitif * dan / data yang dapat dikenal pasti identiti individu.</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="observation" 
                        <?php echo (in_array('observation', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 6 -->
                    <tr>
                        <td style="padding: 15px;">
                            Market survey, opinion poll / online vote, and consumer acceptability tests that do not collect sensitive* and identifiable data of an individual.
                            <br><i>Tinjauan pasaran, persepsi / undian dalam talian, dan ujian penerimaan pengguna yang tidak mengumpulkan data sensitif * dan / data yang dapat dikenal pasti identiti individu.</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="survey-study" 
                        <?php echo (in_array('survey-study', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 7 -->
                    <tr>
                        <td style="padding: 15px;">
                            Observational studies based on video recording obtained from public domains that do not collect sensitive* and identifiable data of an individual.
                            <br><i>Kajian pemerhatian berdasarkan rakaman video yang diperolehi daripada domain awam yang tidak mengumpulkan data sensitif * dan / data yang dapat dikenal pasti identiti individu.</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="observation-study" 
                        <?php echo (in_array('observation-study', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 8 -->
                    <tr>
                        <td style="padding: 15px;">
                            Filming of documentary / documentation of cultural / traditional practices that have obtained prior approval from the relevant parties / authorities and does not collect sensitive* and identifiable data of an individual. (*random video/photo).
                            <br><i>Penggambaran dokumentari / dokumentasi amalan budaya / tradisi yang telah mendapat persetujuan daripada pihak berkenaan / berkuasa dan tidak mengumpulkan data sensitif * dan / data yang dapat dikenal pasti identiti individu.</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="documentation-study" 
                        <?php echo (in_array('documentation-study', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 9 -->
                    <tr>
                        <td style="padding: 15px;">
                            Activities for quality assurance purposes (e.g. clinical audit, communication audit, compliance audit) related to the evaluation of public service programs, public health surveillance, educational evaluation.
                            <br><i>Aktiviti untuk tujuan jaminan kualiti (contoh: audit klinikal, komunikasi, pematuhan) yang berkaitan dengan penilaian program perkhidmatan awam, surveilan kesihatan awam, penilaian pendidikan.</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="quality-assurance-study" 
                        <?php echo (in_array('quality-assurance-study', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>

                    <!-- Option 10 -->
                    <tr>
                        <td style="padding: 15px;">
                            Others (provide details): 
                            <br><i>Lain-lain (nyatakan butiran):</i>
                        </td>
                        <td style="padding: 30px;">
                        <input type="checkbox" name="ethical_exempt_just[]" value="other-method" 
                        <?php echo (in_array('other-method', $_SESSION['ethical_exempt_just'] ?? [])) ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                </tbody>
            </table>

                <!-- Sensitive References -->
                <table style="width: 100%; border-collapse: collapse; border: 0px solid #000;">
                    <tr>
                        <td style="padding: 10px; border: 0.5px solid #000;">
                            <p>*Sensitive refers to the following (but not limited to):<br><i>* Sensitif merujuk kepada yang berikut (tidak terhad kepada):</i></p>
                            <p style="margin: 0; line-height: 1.5; text-indent: 0px;">1. Corruption</p>
                                <p style="margin: 0; line-height: 1.5; text-indent: 16px;"><i>Rasuah</i></p><br>
                            <p style="margin: 0; line-height: 1.5; text-indent: 0px;">2. Fraud or cyber fraud</p>
                                <p style="margin: 0; line-height: 1.5; text-indent: 16px;"><i>Penipuan atau penipuan siber</i></p><br>
                            <p style="margin: 0; line-height: 1.5; text-indent: 0px;">3. Specific-entity review</p>
                                <p style="margin: 0; line-height: 1.5; text-indent: 16px;"><i>Ulasan entiti khusus</i></p><br>
                            <p style="margin: 0; line-height: 1.5; text-indent: 0px;">4. Vulnerable group</p>
                                <p style="margin: 0; line-height: 1.5; text-indent: 16px;"><i>Kumpulan rentan</i></p></td>
                    </tr>
                </table>
            </div>

        <!-- Part D: Agreement to conduct the research project. -->
        <div class="section">
            <h3>Part D: Agreement to Conduct the Research Project.<br><i>Bahagian D: Pengesahan Persetujuan Menjalankan Penyelidikan</i></h3>
            <p>Must be completed and signed by all members of the research group.<br><i>Mesti dilengkapkan dan ditandatangani oleh semua ahli kumpulan penyelidikan.</i></p>

            <!-- Table for Applicant -->
            <h4>1. Applicant (to be filled by Undergraduate/Post Graduate by Coursework Student only)<br><i>Pemohon (untuk dilengkapkan oleh Pelajar Siswazah / Pasca-siswazah Kerja Kursus sahaja)</i></h4>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #000;">
                <!-- Name -->
                <tr>
                    <td style="padding: 10px; width: 30%; border: 1px solid #000;"><b>Name:</b><br><i>Nama:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="app_name" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['app_name'] ?? ''); ?>"></td>
                </tr>
                <!-- Staff ID/Student ID -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Staff ID/Student ID:</b><br><i>No. Staf/No. Pelajar:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="app_id" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['app_id'] ?? ''); ?>"></td>
                </tr>
                <!-- Position/Specialisation -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Position/Specialisation:</b><br><i>Jawatan/Kepakaran:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="app_position" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['app_position'] ?? ''); ?>"></td>
                </tr>
                <!-- Affiliation -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Affiliation:</b><br><i>Jabatan:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="app_affiliation" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['app_affiliation'] ?? ''); ?>"></td>
                </tr>
                <!-- Office -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Office:</b><br><i>Telefon pejabat:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="app_office" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['app_office'] ?? ''); ?>"></td>
                </tr>
                <!-- Mobile phone -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Mobile phone:</b><br><i>Telefon bimbit:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="app_mobile" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['app_mobile'] ?? ''); ?>"></td>
                </tr>
                <!-- Email -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Email:</b><br><i>Emel:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="email" name="app_email" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['app_email'] ?? ''); ?>"></td>
                </tr>
                <!-- Signature -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Signature:</b><br><i>Tandatangan:</i></td>
                    <td>
                        <label for="app_signature"><b>Signature of Applicant:</b><br><i>Tandatangan Peserta:</i></label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" id="app_signature" name="app_signature" <?php echo (isset($_SESSION['app_signature']) && $_SESSION['app_signature'] == 'on') ? 'checked' : ''; ?> required>
                                I have read and understood the terms and conditions of my participation.
                            </label>
                            <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                        </div>
                    </td>
                </tr>
                <!-- Date -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Date:</b><br><i>Tarikh:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="date" name="app_date" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['app_date'] ?? ''); ?>"></td>
                </tr>
            </table>

            <!-- Table for Supervisor -->
            <h4>2. Supervisor<br><i>Penyelia</i></h4>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #000;">
                <!-- Name -->
                <tr>
                    <td style="padding: 10px; width: 30%; border: 1px solid #000;"><b>Name:</b><br><i>Nama:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="sv_name" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['sv_name'] ?? ''); ?>"></td>
                </tr>
                <!-- Staff ID/Student ID -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Staff ID/Student ID:</b><br><i>No. Staf/No. Pelajar:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="sv_id" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['sv_id'] ?? ''); ?>"></td>
                </tr>
                <!-- Position/Specialisation -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Position/Specialisation:</b><br><i>Jawatan/Kepakaran:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="sv_position" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['sv_position'] ?? ''); ?>"></td>
                </tr>
                <!-- Affiliation -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Affiliation:</b><br><i>Jabatan:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="sv_affiliation" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['sv_affiliation'] ?? ''); ?>"></td>
                </tr>
                <!-- Office -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Office:</b><br><i>Telefon pejabat:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="sv_office" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['sv_office'] ?? ''); ?>"></td>
                </tr>
                <!-- Mobile phone -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Mobile phone:</b><br><i>Telefon bimbit:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="sv_mobile" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['sv_mobile'] ?? ''); ?>"></td>
                </tr>
                <!-- Email -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Email:</b><br><i>Emel:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="email" name="sv_email" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['sv_email'] ?? ''); ?>"></td>
                </tr>
                <!-- Signature -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Signature:</b><br><i>Tandatangan:</i></td>
                    <td>
                        <label for="sv_signature"><b>Signature of Supervisor:</b><br><i>Tandatangan Penyelia:</i></label>
                        <!-- Agree to Terms Checkbox -->
                        <div class="checkbox-group">
                            <label><input type="checkbox" id="sv_signature" name="sv_signature" <?php echo (isset($_SESSION['sv_signature']) && $_SESSION['sv_signature'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.</label>
                            <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                        </div>
                    </td>
                </tr>
                <!-- Date -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Date:</b><br><i>Tarikh:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="date" name="sv_date" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['sv_date'] ?? ''); ?>"></td>
                </tr>
            </table>
            <br>

            <!-- Table for Co-Researcher -->
            <h4>3. Co-Researcher<br><i>Penyelidik Bersama</i></h4>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #000;">
                <!-- Name -->
                <tr>
                    <td style="padding: 10px; width: 30%; border: 1px solid #000;"><b>Name:</b><br><i>Nama:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="cores_name" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['cores_name'] ?? ''); ?>"></td>
                </tr>
                <!-- Staff ID/Student ID -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Staff ID/Student ID:</b><br><i>No. Staf/No. Pelajar:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="cores_id" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['cores_id'] ?? ''); ?>"></td>
                </tr>
                <!-- Position/Specialisation -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Position/Specialisation:</b><br><i>Jawatan/Kepakaran:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="cores_position" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['cores_position'] ?? ''); ?>"></td>
                </tr>
                <!-- Affiliation -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Affiliation:</b><br><i>Jabatan:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="cores_affiliation" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['cores_affiliation'] ?? ''); ?>"></td>
                </tr>
                <!-- Office -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Office:</b><br><i>Telefon pejabat:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="cores_office" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['cores_office'] ?? ''); ?>"></td>
                </tr>
                <!-- Mobile phone -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Mobile phone:</b><br><i>Telefon bimbit:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="text" name="cores_mobile" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['cores_mobile'] ?? ''); ?>"></td>
                </tr>
                <!-- Email -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Email:</b><br><i>Emel:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="email" name="cores_email" style="width: 100%;" value="<?php echo htmlspecialchars($_SESSION['cores_email'] ?? ''); ?>"></td>
                </tr>
                <!-- Signature -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Signature:</b><br><i>Tandatangan:</i></td>
                    <td><label for="cores_signature"><b>Signature of Co-Researcher:</b><br><i>Tandatangan Penyelidik Bersama:</i></label>
                        <!-- Agree to Terms Checkbox -->
                        <div class="checkbox-group">
                            <label><input type="checkbox" id="cores_signature" name="cores_signature" <?php echo (isset($_SESSION['cores_signature']) && $_SESSION['cores_signature'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.</label>
                            <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
                        </div>
                    </td>
                </tr>
                <!-- Date -->
                <tr>
                    <td style="padding: 10px; border: 1px solid #000;"><b>Date:</b><br><i>Tarikh:</i></td>
                    <td style="padding: 10px; border: 1px solid #000;"><input type="date" name="cores_date" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['cores_date'] ?? ''); ?>"></td>
                </tr>
            </table>
                <i>(Add if necessary)</i>
            </div>
            <br>

             <!-- Part E: Verification from Department or Postgraduate Research Sub-Committee -->
            <div class="section">
                <h3>Part E: Verification from Department or Postgraduate Research Sub-Committee <br><i>Bahagian E: Pengesahan Jawatankuasa Penyelidikan Jabatan atau Pascasiswazah</i></h3>
                <p>The Department or Postgraduate Research Sub-Committee has reviewed the study protocol and recommends for exemption from ethical review.<br>
                    <i>Jawatankuasa Kecil Penyelidikan Jabatan atau Pascasiswazah telah mengkaji protokol kajian dan mengesyorkan untuk pengecualian daripada semakan etika.</i></p>
                <br><br>

           <!-- Signatures -->
        <table>
            <tbody>
        <tr>
        <!-- Coordinator Signature -->
            <td>        
                <!-- Signature Box -->
                <label for="cb_signature"><b>Signature Coordinator of Committee:</b><br><i>Tandatangan Koordinator Jawatankuasa:</i></label>
                <!-- Agree to Terms Checkbox -->
            <div class="checkbox-group">
                <label><input type="checkbox" id="cb_signature" name="cb_signature" <?php echo (isset($_SESSION['cb_signature']) && $_SESSION['cb_signature'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.</label>
                <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
            </div>
            </td></tr>

            <!-- Official Stamp Box -->
            <td>
                <label for="cb_stamp"><b>Official Stamp:</b><br><i>Cop Rasmi:</i></label>
                <!-- Agree to Terms Checkbox -->
            <div class="checkbox-group">
                <label><input type="checkbox" id="cb_stamp" name="cb_stamp" <?php echo (isset($_SESSION['cb_stamp']) && $_SESSION['cb_stamp'] == 'on') ? 'checked' : ''; ?> required>I have read and understood the terms and conditions of my participation.</label>
                <label><i>Saya telah membaca dan memahami semua syarat penyertaan penyelidikan ini.</i></label>
            </div>
            </td></tr>

            <!-- Date -->
            <td>
                <label for="submission_date"><b>Date:</b><br><i>Tarikh:</i></label>
                <input type="date" name="submission_date" id="submission_date" style="width: 50%;" value="<?php echo htmlspecialchars($_SESSION['submission_date'] ?? ''); ?>">
            </td>
        </tr>
    </tbody>
        </table><br>
        <div class="button-container">
            <!-- Save as Draft button -->
            <button type="submit" class="submit-button" id="saveAsDraft" name="save_draft">Save as Draft</button>
            <!-- Submit button -->
            <button type="submit" class="next-button" id="submitForm" name="next">Next</button>
        </div>
        </form>
    </div>
</body>
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
</html>