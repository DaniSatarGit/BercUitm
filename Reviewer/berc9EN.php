<?php
// Include the database connection
include '../config.php';

// Fetch data from `berc4` table
$sql = "SELECT research_title, researcher_name, supervisor_name, dept_address FROM berc4 ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        $data = [
            'research_title' => 'N/A',
            'researcher_name' => 'N/A',
            'supervisor_name' => 'N/A',
            'dept_address' => 'N/A'
        ];
        echo "<p>No data found in the table.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Error preparing the SQL statement.</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Project Evaluation Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f3f4f6; font-family: Arial, sans-serif; }
        .container { margin-top: 30px; max-width: 900px; }
        .card { margin-bottom: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .card-header { background-color: #007bff; color: white; font-weight: bold; }
        .btn-submit { background-color: #4B0082; color: white; width: 100%; font-weight: bold; border: none; }
        .btn-submit:hover { background-color: #3B0070; }
        .error { border-color: #dc3545 !important; }
    </style>
</head>
<body>

<div class="container">
    <!-- Research Project Evaluation Form -->
    <form id="evaluationForm" action="submitBerc9EN.php" method="POST">
        <!-- Part A: Details of Researcher -->
        <div class="card">
            <div class="card-header">Part A: Brief Details of Project Reviewed</div>
            <div class="card-body">
                <div class="row mb-3">
                    <label for="title_project" class="col-md-4 col-form-label"><b>Title of Project</b> / <i>Tajuk Projek:</i></label>
                    <div class="col-md-8">
                        <input type="text" id="title_project" name="title_project" class="form-control" readonly
                               value="<?= htmlspecialchars($data['research_title']); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="researcher_name" class="col-md-4 col-form-label"><b>Name of Researcher</b> / <i>Nama Penyelidik:</i></label>
                    <div class="col-md-8">
                        <input type="text" id="researcher_name" name="researcher_name" class="form-control" readonly
                               value="<?= htmlspecialchars($data['researcher_name']); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="supervisor_name" class="col-md-4 col-form-label"><b>Name of Supervisor</b> / <i>Nama Penyelia:</i></label>
                    <div class="col-md-8">
                        <input type="text" id="supervisor_name" name="supervisor_name" class="form-control" readonly
                               value="<?= htmlspecialchars($data['supervisor_name']); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="dept_address" class="col-md-4 col-form-label"><b>Department Address</b> / <i>Alamat Jabatan:</i></label>
                    <div class="col-md-8">
                        <textarea id="dept_address" name="dept_address" class="form-control" readonly><?= htmlspecialchars($data['dept_address']); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section A: Research Methods Summary -->
        <div class="card">
            <div class="card-header">Section A: Research Methods Summary</div>
            <div class="card-body">
                <p>(Tick all that apply)</p>
                <div class="row mb-2">
                    <label class="col-md-4"><b>Research Methods</b> / <i>Kaedah Penyelidikan:</i></label>
                    <div class="col-md-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research_methods[]" value="Systematic Review" id="systematic_checkbox">
                            <label class="form-check-label" for="systematic_checkbox">Systematic Review / <i>Kajian Sistematik</s></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research_methods[]" value="Video / Film Analysis" id="videop_checkbox">
                            <label class="form-check-label" for="video_checkbox">Video,Film Analysis  /    <i>Analisis Video,Filem</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research_methods[]" value="Content Analysis" id="content_analysis_checkbox">
                            <label class="form-check-label" for="content_analysis_checkbox">Content Analysis / <i>Analisis Kandungan</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research_methods[]" value="Concept Paper" id="concept_paper_checkbox">
                            <label class="form-check-label" for="concept_paper">Concept Paper / <i>Kertas Konsep</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research_methods[]" value="Analisis Data Sekunder" id="secondary_data_analysis_checkbox">
                            <label class="form-check-label" for="secondary_data_analysis_checkbox">Secondary Data Analysis / <i>Analisis Data Sekunder</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research_methods[]" value="Maximal Exercise Intensity" id="maximal_exercise_checkbox">
                            <label class="form-check-label" for="maximal_exercise_checkbox">Maximal Exercise Intensity / <i>Intensiti Latihan Maksimum</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research_methods[]" value="Submaximal Exercise Intensity" id="submaximal_exercise_checkbox">
                            <label class="form-check-label" for="submaximal_exercise_checkbox">Submaximal Exercise Intensity / <i>Intensiti Latihan Submaksimum</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="research_methods[]" value="Quality Assurance" id="quality_assurance_checkbox">
                            <label class="form-check-label" for="quality_assurance_checkbox">Quality Assurance / <i>Jaminan Kualiti</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="others_checkbox_A" name="research_methods[]" value="Others Method" onclick="toggleCommentAreaA()">
                            <label class="form-check-label" for="others_checkbox_A">Others. Specify / <i>Lain-lain (Nyatakan):</i></label>
                            <textarea id="others_comment_A" name="others_comment_A" class="form-control comment-area" placeholder="Please specify here..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Structure for Section B: Subjects -->
        <div class="card">
            <div class="card-header">Section B: Participants</div>
            <div class="card-body">
                <div class="row mb-2">
                    <label class="col-md-4"><b>Subjects</b> / <i>Subjek:</i></label>
                    <div class="col-md-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="Children" id="children_checkbox">
                            <label class="form-check-label" for="children_checkbox">Children / <i>Kanak-kanak</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="Vulnerable" id="vulnerable_checkbox">
                            <label class="form-check-label" for="vulnerable_checkbox">Vulnerable / <i>Terdedah</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="Healthy" id="healthy_checkbox">
                            <label class="form-check-label" for="healthy_checkbox">Healthy</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="Trained Person" id="trained_person_checkbox">
                            <label class="form-check-label" for="trained_person_checkbox">Trained Person / <i>Individu Terlatih</i></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="others_checkbox_B" name="subjects[]" value="Others Subject" onclick="toggleCommentAreaB()">
                            <label class="form-check-label" for="others_checkbox_B">Others. Specify / <i>Lain-lain (Nyatakan):</i></label>
                            <textarea id="others_comment_B" name="others_comment_B" class="form-control comment-area" placeholder="Please specify here..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section C: BERC Forms -->
        <div class="card">
            <div class="card-header">Section C: BERC Forms (tick all that apply)</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Form Section</th>
                            <th>Yes / No</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Title</td>
                            <td>
                                <input type="radio" name="title" value="yes" onclick="toggleComment('title_comment', false)"> Yes
                                <input type="radio" name="title" value="no" onclick="toggleComment('title_comment', true)"> No
                            </td>
                            <td><textarea id="title_comment" name="title_comment" class="form-control comment-area" placeholder="Enter comments here..."></textarea></td>
                        </tr>
                        <tr>
                            <td>Methodology</td>
                            <td>
                                <input type="radio" name="methodology" value="yes" onclick="toggleComment('methodology_comment', false)"> Yes
                                <input type="radio" name="methodology" value="no" onclick="toggleComment('methodology_comment', true)"> No
                            </td>
                            <td><textarea id="methodology_comment" name="methodology_comment" class="form-control comment-area" placeholder="Enter comments here..."></textarea></td>
                        </tr>
                        <tr>
                            <td>Objectives</td>
                            <td>
                                <input type="radio" name="objectives" value="yes" onclick="toggleComment('objectives_comment', false)"> Yes
                                <input type="radio" name="objectives" value="no" onclick="toggleComment('objectives_comment', true)"> No
                            </td>
                            <td><textarea id="objectives_comment" name="objectives_comment" class="form-control comment-area" placeholder="Enter comments here..."></textarea></td>
                        </tr>
                        <tr>
                            <td>Justification of Research</td>
                            <td>
                                <input type="radio" name="justification" value="yes" onclick="toggleComment('justification_comment', false)"> Yes
                                <input type="radio" name="justification" value="no" onclick="toggleComment('justification_comment', true)"> No
                            </td>
                            <td><textarea id="justification_comment" name="justification_comment" class="form-control comment-area" placeholder="Enter comments here..."></textarea></td>
                        </tr>
                        <tr>
                            <td>Expected Benefits</td>
                            <td>
                                <input type="radio" name="benefits" value="yes" onclick="toggleComment('benefits_comment', false)"> Yes
                                <input type="radio" name="benefits" value="no" onclick="toggleComment('benefits_comment', true)"> No
                            </td>
                            <td><textarea id="benefits_comment" name="benefits_comment" class="form-control comment-area" placeholder="Enter comments here..."></textarea></td>
                        </tr>
                        <tr>
                            <td>Possible Risks</td>
                            <td>
                                <input type="radio" name="risks" value="yes" onclick="toggleComment('data_collection_date_comment', false)"> Yes
                                <input type="radio" name="risks" value="no" onclick="toggleComment('data_collection_date_comment', true)"> No
                            </td>
                            <td><textarea id="risks_comment" name="risks_comment" class="form-control comment-area" placeholder="Enter comments here..."></textarea></td>
                        </tr>
                        <tr>
                            <td>Justification for Exemption</td>
                            <td>
                                <input type="radio" name="exemption" value="yes" onclick="toggleComment('project_location_comment', false)"> Yes
                                <input type="radio" name="exemption" value="no" onclick="toggleComment('project_location_comment', true)"> No
                            </td>
                            <td><textarea id="exemption_comment" name="exemption_comment" class="form-control comment-area" placeholder="Enter comments here..."></textarea></td>
                        </tr>
                        <tr>
                            <td>Others: Supporting documents/Proposal</td>
                            <td>
                                <input type="radio" name="supporting" value="yes" onclick="toggleComment('supporting_comment', false)"> Yes
                                <input type="radio" name="supporting" value="no" onclick="toggleComment('statistical_analysis_comment', true)"> No
                            </td>
                            <td><textarea id="supporting_comment" name="supporting_comment" class="form-control comment-area" placeholder="Enter comments here..."></textarea></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Decision Section -->
        <div class="card">
            <div class="card-header">BERC Member Decision</div>
            <div class="card-body">
                <!-- Radio option for minimal approval without changes -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="decision" id="minimal_approve" value="approve_without_changes" onclick="hideConditionalSections()">
                    <label class="form-check-label" for="minimal_approve">Minimal risk research. Recommend to approve without changes.</label>
                </div>

                <!-- Radio option for minimal approval with changes -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="decision" id="minimal_approve_changes" value="approve_with_changes" onclick="toggleConditionsGroup()">
                    <label class="form-check-label" for="minimal_approve_changes">Minimal risk research. Recommend to approve with changes</label>
                </div>

                <!-- Conditional section for modification types, shown only if "approve with changes" is selected -->
                <div id="conditions-group" class="ml-4" style="display:none;">
                    <label class="form-check-label"><input type="radio" name="modifications" id="minor_modifications" value="minor_modifications"> Minor modifications</label><br>
                    <label class="form-check-label"><input type="radio" name="modifications" id="major_modifications" value="major_modifications"> Major modifications</label>
                </div>

                <!-- Additional radio options for different decision types -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="decision" id="more_risks" value="more_than_minimal_risk" onclick="hideConditionalSections()">
                    <label class="form-check-label" for="more_risks">More than minimal risk research</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="decision" id="return_without_review" value="return_without_review" onclick="hideConditionalSections()">
                    <label class="form-check-label" for="return_without_review">Return without review due to major grammatical errors</label>
                </div>

                <!-- Comments section that appears conditionally -->
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="decision" id="checkbox_comment" onclick="toggleCommentAreaDecision()">
                    <label class="form-check-label" for="checkbox_comment">Comments if any:</label>
                    <textarea id="comment_decision" name="comment_decision" class="form-control comment-area" placeholder="Please specify here..."></textarea>
                </div>
                
                <br>
                <label for="date_submitted" class="col-form-label"><b>Date:</b></label>
                <input type="date" name="date_submitted" id="date_submitted" class="form-control mb-3">
            </div>
        </div>

        <div class="text-center">
            <button type="button" onclick="submitForm()" class="btn btn-submit">Submit</button>
        </div>
    </form>
</div>

<script>
function submitForm() {
    const isValid = validateForm();
    if (isValid) {
        document.getElementById('evaluationForm').submit(); // Submit only if validation passes
    }
}

function validateForm() {
    let isValid = true;
    const errorElements = []; // Store elements with errors for highlighting

    // Helper function to mark an element as error
    function markError(element) {
        element.classList.add("error");
        errorElements.push(element);
        isValid = false;
    }

    // Clear all previous error highlights
    document.querySelectorAll(".error").forEach(el => el.classList.remove("error"));

    // 1. Validate Section C (Radio buttons and comments)
    const sectionFields = [
        { name: "title", label: "Title" },
        { name: "background", label: "Background" },
        { name: "problem_statement", label: "Problem Statement" },
        { name: "objectives", label: "Objectives" },
        { name: "expected_benefits", label: "Expected Benefits" },
        { name: "research_dates", label: "Research Dates" },
        { name: "data_collection_date", label: "Data Collection Date" },
        { name: "project_location", label: "Project Location" },
        { name: "experimental_design", label: "Experimental Design" },
        { name: "criteria", label: "Inclusion & Exclusion Criteria" },
        { name: "sample_size", label: "Sample Size" },
        { name: "flow_chart", label: "Flow Chart" },
        { name: "statistical_analysis", label: "Statistical Analysis" }
    ];

    sectionFields.forEach(({ name, label }) => {
        const radios = document.getElementsByName(name);
        const comment = document.getElementById(`${name}_comment`);
        const isSelected = Array.from(radios).some(radio => radio.checked);

        if (!isSelected) {
            alert(`Please select Yes or No for ${label}`);
            markError(radios[0].closest(".card"));
        } else if (radios[1].checked && comment && !comment.value.trim()) {
            alert(`Please provide comments for ${label}`);
            markError(comment);
        }
    });

    // 2. Validate Section A: Research Methods
    const researchMethods = document.querySelectorAll('input[name="research_methods[]"]');
    const hasMethod = Array.from(researchMethods).some(checkbox => checkbox.checked);
    if (!hasMethod) {
        alert("Please select at least one research method in Section A.");
        markError(document.querySelector(".research_methods")); // Assuming class is on the container of research methods
    }

    const othersCheckboxA = document.getElementById("others_checkbox_A");
    const othersCommentA = document.getElementById("others_comment_A");
    if (othersCheckboxA.checked && !othersCommentA.value.trim()) {
        alert("Please specify details in the 'Others' comment section in Section A.");
        markError(othersCommentA);
    }

    // 3. Validate Section B: Subjects
    const subjects = document.querySelectorAll('input[name="subjects[]"]');
    const hasSubject = Array.from(subjects).some(checkbox => checkbox.checked);
    if (!hasSubject) {
        alert("Please select at least one subject in Section B.");
        markError(document.querySelector(".subjects")); // Assuming class is on the container of subjects
    }

    const othersCheckboxB = document.getElementById("others_checkbox_B");
    const othersCommentB = document.getElementById("others_comment_B");
    if (othersCheckboxB.checked && !othersCommentB.value.trim()) {
        alert("Please specify details in the 'Others' comment section in Section B.");
        markError(othersCommentB);
    }

    // 4. Validate BERC Member Decision
    const decisionRadios = document.getElementsByName("decision");
    const isDecisionSelected = Array.from(decisionRadios).some(radio => radio.checked);
    if (!isDecisionSelected) {
        alert("Please select a BERC Member Decision.");
        markError(document.querySelector(".decision")); // Assuming class on container
    }

    // 5. Validate BERC Forms (BERC2, BERC3, BERC5)
    ["berc2", "berc3", "berc5"].forEach(formName => {
        const formRadios = document.getElementsByName(formName);
        const isFormSelected = Array.from(formRadios).some(radio => radio.checked);
        if (!isFormSelected) {
            alert(`Please select Complete or Incomplete for ${formName.toUpperCase()}`);
            markError(document.querySelector(`.${formName}`)); // Assuming class on container
        }
    });

    return isValid; // Return true only if all validations pass
}

// Toggle the visibility of conditional comment fields based on selection
function toggleComment(commentId, show) {
    const commentBox = document.getElementById(commentId);
    commentBox.style.display = show ? "block" : "none";
    if (!show) commentBox.value = ""; // Clear comment if hidden
}
</script>

</body>
</html>
