CREATE DATABASE IF NOT EXISTS `bercuitm` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bercuitm`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `project_evaluations`;
DROP TABLE IF EXISTS `reviewer_exemption`;
DROP TABLE IF EXISTS `reviewer_application`;
DROP TABLE IF EXISTS `assigned_reviews`;
DROP TABLE IF EXISTS `rejected_exemption`;
DROP TABLE IF EXISTS `coordinator_exemption`;
DROP TABLE IF EXISTS `approved_exemption`;
DROP TABLE IF EXISTS `rejected_application`;
DROP TABLE IF EXISTS `coordinator_application`;
DROP TABLE IF EXISTS `approved_application`;
DROP TABLE IF EXISTS `berc5_draftt`;
DROP TABLE IF EXISTS `berc5ex`;
DROP TABLE IF EXISTS `berc5_draft`;
DROP TABLE IF EXISTS `berc5`;
DROP TABLE IF EXISTS `berc4_draft`;
DROP TABLE IF EXISTS `berc4`;
DROP TABLE IF EXISTS `berc3_draft`;
DROP TABLE IF EXISTS `berc3`;
DROP TABLE IF EXISTS `berc2_draft`;
DROP TABLE IF EXISTS `berc2`;
DROP TABLE IF EXISTS `berc1_draft`;
DROP TABLE IF EXISTS `berc1`;
DROP TABLE IF EXISTS `secretariat`;
DROP TABLE IF EXISTS `reviewer`;
DROP TABLE IF EXISTS `coordinator`;
DROP TABLE IF EXISTS `researcher`;
DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_admin_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `researcher` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staffID` VARCHAR(50) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `reset_token` VARCHAR(255) DEFAULT NULL,
  `token_expiry` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_researcher_staffid` (`staffID`),
  UNIQUE KEY `uq_researcher_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `reviewer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staffID` VARCHAR(50) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `reset_token` VARCHAR(255) DEFAULT NULL,
  `token_expiry` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_reviewer_staffid` (`staffID`),
  UNIQUE KEY `uq_reviewer_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `secretariat` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staffID` VARCHAR(50) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `reset_token` VARCHAR(255) DEFAULT NULL,
  `token_expiry` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_secretariat_staffid` (`staffID`),
  UNIQUE KEY `uq_secretariat_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `coordinator` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staffID` VARCHAR(50) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `reset_token` VARCHAR(255) DEFAULT NULL,
  `token_expiry` DATETIME DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_coordinator_staffid` (`staffID`),
  UNIQUE KEY `uq_coordinator_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `berc1` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `part_a_supervisor_name` TEXT,
  `department_address` TEXT,
  `contact_info` TEXT,
  `researcher_level` VARCHAR(100) DEFAULT NULL,
  `ethics_approval` TEXT,
  `research_funding` TEXT,
  `research_methods` TEXT,
  `background` LONGTEXT,
  `problem_statement` LONGTEXT,
  `rujukan` LONGTEXT,
  `research_objectives` LONGTEXT,
  `expected_benefits` LONGTEXT,
  `research_dates` TEXT,
  `data_collection_date` TEXT,
  `research_location` TEXT,
  `research_design` LONGTEXT,
  `inclusion_criteria` LONGTEXT,
  `exclusion_criteria` LONGTEXT,
  `sample_size` TEXT,
  `calculation` TEXT,
  `calculation_upload` TEXT,
  `flowchart` TEXT,
  `statistical_analysis` LONGTEXT,
  `grant_source` TEXT,
  `grant_approval_date` TEXT,
  `total_allocation` TEXT,
  `grant_duration` TEXT,
  `grant_others` TEXT,
  `applicant_name` TEXT,
  `applicant_staff_id` TEXT,
  `applicant_position` TEXT,
  `applicant_affiliation` TEXT,
  `applicant_office_phone` TEXT,
  `applicant_mobile_phone` TEXT,
  `applicant_email` TEXT,
  `applicant_signature` TEXT,
  `applicant_date` TEXT,
  `supervisor_name` TEXT,
  `supervisor_staff_id` TEXT,
  `supervisor_position` TEXT,
  `supervisor_affiliation` TEXT,
  `supervisor_office_phone` TEXT,
  `supervisor_mobile_phone` TEXT,
  `supervisor_email` TEXT,
  `supervisor_signature` TEXT,
  `supervisor_date` TEXT,
  `co_researcher_name` TEXT,
  `co_researcher_staff_id` TEXT,
  `co_researcher_position` TEXT,
  `co_researcher_affiliation` TEXT,
  `co_researcher_office_phone` TEXT,
  `co_researcher_mobile_phone` TEXT,
  `co_researcher_email` TEXT,
  `co_researcher_signature` TEXT,
  `co_researcher_date` TEXT,
  `is_children_under_18` VARCHAR(20) DEFAULT NULL,
  `is_vulnerable_group` VARCHAR(20) DEFAULT NULL,
  `is_terminal_care` VARCHAR(20) DEFAULT NULL,
  `is_unable_to_give_consent` VARCHAR(20) DEFAULT NULL,
  `is_emolument` VARCHAR(20) DEFAULT NULL,
  `children_under_18_description` LONGTEXT,
  `vulnerable_group_description` LONGTEXT,
  `terminal_care_description` LONGTEXT,
  `unable_to_give_consent_description` LONGTEXT,
  `emolument_description` LONGTEXT,
  `data_discomfort` VARCHAR(20) DEFAULT NULL,
  `undeclared_measures` VARCHAR(20) DEFAULT NULL,
  `data_availability` VARCHAR(20) DEFAULT NULL,
  `data_discomfort_description` LONGTEXT,
  `undeclared_measures_description` LONGTEXT,
  `data_availability_description` LONGTEXT,
  `collects_biological_samples` VARCHAR(20) DEFAULT NULL,
  `can_identify_participants` VARCHAR(20) DEFAULT NULL,
  `is_invasive_method` VARCHAR(20) DEFAULT NULL,
  `involves_vigorous_tests` VARCHAR(20) DEFAULT NULL,
  `is_non_athlete_or_chronic` VARCHAR(20) DEFAULT NULL,
  `involves_maximal_exercise` VARCHAR(20) DEFAULT NULL,
  `involves_procedure_or_medication` VARCHAR(20) DEFAULT NULL,
  `involves_unapproved_indication` VARCHAR(20) DEFAULT NULL,
  `consent_from_others` VARCHAR(20) DEFAULT NULL,
  `risk_if_withdraw` VARCHAR(20) DEFAULT NULL,
  `stores_samples` VARCHAR(20) DEFAULT NULL,
  `analyses_sample_other_purpose` VARCHAR(20) DEFAULT NULL,
  `consent_for_other_purpose` VARCHAR(20) DEFAULT NULL,
  `biological_samples_type` TEXT,
  `biological_samples_description` LONGTEXT,
  `identify_participants_description` LONGTEXT,
  `invasive_method_description` LONGTEXT,
  `vigorous_tests_description` LONGTEXT,
  `non_athletes_chronic_illness_description` LONGTEXT,
  `maximal_exercise_description` LONGTEXT,
  `procedure_medication_description` LONGTEXT,
  `unapproved_indication_description` LONGTEXT,
  `consent_other_than_participants_description` LONGTEXT,
  `risk_withdrawal_description` LONGTEXT,
  `store_samples_future_research_description` LONGTEXT,
  `analyse_sample_other_purpose_description` LONGTEXT,
  `consent_for_other_purpose_description` LONGTEXT,
  `other_ethical_issues` VARCHAR(20) DEFAULT NULL,
  `other_ethical_issues_description` LONGTEXT,
  `presented_proposal` VARCHAR(20) DEFAULT NULL,
  `completed_berc1` VARCHAR(20) DEFAULT NULL,
  `completed_berc2_or_3` VARCHAR(20) DEFAULT NULL,
  `supervisor_checked` VARCHAR(20) DEFAULT NULL,
  `signed_by_all_researchers` VARCHAR(20) DEFAULT NULL,
  `endorsed_by_committee` VARCHAR(20) DEFAULT NULL,
  `additional_comments` LONGTEXT,
  `Applicants_Signature_F` TEXT,
  `Applicants_Date_F` TEXT,
  `Supervisors_Signature` TEXT,
  `Supervisors_Date` TEXT,
  `Risk` VARCHAR(100) DEFAULT NULL,
  `Coordinator_Signature_G` TEXT,
  `Official_stamp_G` TEXT,
  `Coordinator_Date` TEXT,
  `submission_date` TEXT,
  `status` VARCHAR(100) NOT NULL DEFAULT 'Pending',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_berc1_user` (`user_id`),
  KEY `idx_berc1_title` (`research_title`(191)),
  CONSTRAINT `fk_berc1_researcher` FOREIGN KEY (`user_id`) REFERENCES `researcher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `berc1_draft` LIKE `berc1`;
ALTER TABLE `berc1_draft`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT,
  ADD COLUMN `saved_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

CREATE TABLE `berc2` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `projectTitle_berc2` TEXT,
  `projectDescription_berc2` LONGTEXT,
  `projectPurpose_berc2` LONGTEXT,
  `projectProcedure_berc2` LONGTEXT,
  `projectParticipation_berc2` LONGTEXT,
  `projectBenefit_berc2` LONGTEXT,
  `projectRisk_berc2` LONGTEXT,
  `projectConfidential_berc2` LONGTEXT,
  `participantName_berc2` TEXT,
  `participantSignature_berc2` TEXT,
  `participantIC_berc2` TEXT,
  `participantDate_berc2` TEXT,
  `witnessName_berc2` TEXT,
  `witnessSignature_berc2` TEXT,
  `witnessIC_berc2` TEXT,
  `witnessDate_berc2` TEXT,
  `consentTakerName_berc2` TEXT,
  `consentTakerSignature_berc2` TEXT,
  `consentTakerIC_berc2` TEXT,
  `consentTakerDate_berc2` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_berc2_user` (`user_id`),
  CONSTRAINT `fk_berc2_researcher` FOREIGN KEY (`user_id`) REFERENCES `researcher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `berc2_draft` LIKE `berc2`;
ALTER TABLE `berc2_draft`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT,
  ADD COLUMN `saved_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

CREATE TABLE `berc3` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `projectName_berc3` TEXT,
  `projectDescription_berc3` LONGTEXT,
  `projectPurpose_berc3` LONGTEXT,
  `projectRole_berc3` LONGTEXT,
  `projectRisk_berc3` LONGTEXT,
  `projectParticipation_berc3` LONGTEXT,
  `researcherName_berc3` TEXT,
  `researcherContact_berc3` TEXT,
  `confidentiality_berc3` LONGTEXT,
  `explained_project_berc3` VARCHAR(20) DEFAULT NULL,
  `understand_project_berc3` VARCHAR(20) DEFAULT NULL,
  `questions_about_project_berc3` VARCHAR(20) DEFAULT NULL,
  `question_answer_berc3` VARCHAR(20) DEFAULT NULL,
  `stop_participation_berc3` VARCHAR(20) DEFAULT NULL,
  `ok_to_participate_berc3` VARCHAR(20) DEFAULT NULL,
  `voice_recording_berc3` VARCHAR(20) DEFAULT NULL,
  `on_video_berc3` VARCHAR(20) DEFAULT NULL,
  `photographs_berc3` VARCHAR(20) DEFAULT NULL,
  `participantName_berc3` TEXT,
  `participantSignature_berc3` TEXT,
  `participantDate_berc3` TEXT,
  `consentTakerName_berc3` TEXT,
  `consentTakerSignature_berc3` TEXT,
  `consentTakerDate_berc3` TEXT,
  `witnessName_berc3` TEXT,
  `witnessSignature_berc3` TEXT,
  `witnessDate_berc3` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_berc3_user` (`user_id`),
  CONSTRAINT `fk_berc3_researcher` FOREIGN KEY (`user_id`) REFERENCES `researcher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `berc3_draft` LIKE `berc3`;
ALTER TABLE `berc3_draft`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT,
  ADD COLUMN `saved_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

CREATE TABLE `berc4` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `supervisor_name` TEXT,
  `dept_address` LONGTEXT,
  `contact_info` TEXT,
  `study_level` VARCHAR(100) DEFAULT NULL,
  `research_just` LONGTEXT,
  `research_obj` LONGTEXT,
  `research_method` LONGTEXT,
  `research_signif` LONGTEXT,
  `research_risks` LONGTEXT,
  `ethical_exempt_just` LONGTEXT,
  `app_name` TEXT,
  `app_id` TEXT,
  `app_position` TEXT,
  `app_affiliation` TEXT,
  `app_office` TEXT,
  `app_mobile` TEXT,
  `app_email` TEXT,
  `app_date` TEXT,
  `app_signature` TEXT,
  `cb_signature` TEXT,
  `cb_stamp` TEXT,
  `sv_name` TEXT,
  `sv_id` TEXT,
  `sv_position` TEXT,
  `sv_affiliation` TEXT,
  `sv_office` TEXT,
  `sv_mobile` TEXT,
  `sv_email` TEXT,
  `sv_signature` TEXT,
  `sv_date` TEXT,
  `cores_name` TEXT,
  `cores_id` TEXT,
  `cores_position` TEXT,
  `cores_affiliation` TEXT,
  `cores_office` TEXT,
  `cores_mobile` TEXT,
  `cores_email` TEXT,
  `cores_signature` TEXT,
  `cores_date` TEXT,
  `submission_date` TEXT,
  `status` VARCHAR(100) NOT NULL DEFAULT 'Pending',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_berc4_user` (`user_id`),
  KEY `idx_berc4_title` (`research_title`(191)),
  CONSTRAINT `fk_berc4_researcher` FOREIGN KEY (`user_id`) REFERENCES `researcher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `berc4_draft` LIKE `berc4`;
ALTER TABLE `berc4_draft`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT,
  ADD COLUMN `saved_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

CREATE TABLE `berc5` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `fberc1_berc5` VARCHAR(20) DEFAULT NULL,
  `fberc2_berc5` VARCHAR(20) DEFAULT NULL,
  `fberc3_berc5` VARCHAR(20) DEFAULT NULL,
  `fberc4_berc5` VARCHAR(20) DEFAULT NULL,
  `fberc5_berc5` VARCHAR(20) DEFAULT NULL,
  `form_signed_berc5` VARCHAR(20) DEFAULT NULL,
  `approved_by_faculty_berc5` VARCHAR(20) DEFAULT NULL,
  `supervisor_checked_berc5` VARCHAR(20) DEFAULT NULL,
  `additional_comments_berc5` LONGTEXT,
  `decision_berc5` VARCHAR(100) DEFAULT NULL,
  `applicant_signature_berc5` TEXT,
  `applicant_date_berc5` TEXT,
  `supervisor_signature_berc5` TEXT,
  `supervisor_date_berc5` TEXT,
  `submission_date_berc5` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_berc5_user` (`user_id`),
  CONSTRAINT `fk_berc5_researcher` FOREIGN KEY (`user_id`) REFERENCES `researcher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `berc5_draft` LIKE `berc5`;
ALTER TABLE `berc5_draft`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT,
  ADD COLUMN `saved_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `submission_date_berc5`;

CREATE TABLE `berc5ex` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `fberc1_berc5` VARCHAR(20) DEFAULT NULL,
  `fberc2_berc5` VARCHAR(20) DEFAULT NULL,
  `fberc3_berc5` VARCHAR(20) DEFAULT NULL,
  `fberc4_berc5` VARCHAR(20) DEFAULT NULL,
  `fberc5_berc5` VARCHAR(20) DEFAULT NULL,
  `form_signed_berc5` VARCHAR(20) DEFAULT NULL,
  `approved_by_faculty_berc5` VARCHAR(20) DEFAULT NULL,
  `supervisor_checked_berc5` VARCHAR(20) DEFAULT NULL,
  `additional_comments_berc5` LONGTEXT,
  `decision_berc5` VARCHAR(100) DEFAULT NULL,
  `applicant_signature_berc5` TEXT,
  `applicant_date_berc5` TEXT,
  `supervisor_signature_berc5` TEXT,
  `supervisor_date_berc5` TEXT,
  `research_title` TEXT,
  `submission_date_berc5` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_berc5ex_user` (`user_id`),
  CONSTRAINT `fk_berc5ex_researcher` FOREIGN KEY (`user_id`) REFERENCES `researcher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `berc5_draftt` LIKE `berc5ex`;
ALTER TABLE `berc5_draftt`
  MODIFY `id` INT NOT NULL AUTO_INCREMENT,
  ADD COLUMN `saved_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `submission_date_berc5`;

CREATE TABLE `approved_application` (
  `id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `part_a_supervisor_name` TEXT,
  `department_address` LONGTEXT,
  `submission_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(100) DEFAULT 'approved',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `coordinator_application` (
  `id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `part_a_supervisor_name` TEXT,
  `department_address` LONGTEXT,
  `submission_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(100) DEFAULT 'Pending',
  `forwarded_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rejected_application` (
  `id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `part_a_supervisor_name` TEXT,
  `department_address` LONGTEXT,
  `submission_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(100) DEFAULT 'Rejected',
  `forwarded_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `approved_exemption` (
  `id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `supervisor_name` TEXT,
  `dept_address` LONGTEXT,
  `submission_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(100) DEFAULT 'approved',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `coordinator_exemption` (
  `id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `supervisor_name` TEXT,
  `dept_address` LONGTEXT,
  `submission_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(100) DEFAULT 'Pending',
  `forwarded_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rejected_exemption` (
  `id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `supervisor_name` TEXT,
  `dept_address` LONGTEXT,
  `submission_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(100) DEFAULT 'Rejected',
  `forwarded_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `assigned_reviews` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `research_title` VARCHAR(255) NOT NULL,
  `reviewer_id` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_assigned_reviews_title` (`research_title`),
  KEY `idx_assigned_reviews_reviewer` (`reviewer_id`),
  CONSTRAINT `fk_assigned_reviews_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `reviewer` (`staffID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `reviewer_application` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `application_id` INT NOT NULL,
  `reviewer_id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `part_a_supervisor_name` TEXT,
  `department_address` LONGTEXT,
  `status` VARCHAR(100) DEFAULT 'Pending',
  `assigned_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_reviewer_application_application` (`application_id`),
  KEY `idx_reviewer_application_reviewer` (`reviewer_id`),
  CONSTRAINT `fk_reviewer_application_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `reviewer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `reviewer_exemption` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `exemption_id` INT NOT NULL,
  `reviewer_id` INT NOT NULL,
  `research_title` TEXT,
  `researcher_name` TEXT,
  `supervisor_name` TEXT,
  `dept_address` LONGTEXT,
  `status` VARCHAR(100) DEFAULT 'Pending',
  `assigned_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_reviewer_exemption_exemption` (`exemption_id`),
  KEY `idx_reviewer_exemption_reviewer` (`reviewer_id`),
  CONSTRAINT `fk_reviewer_exemption_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `reviewer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `project_evaluations` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title_project` TEXT,
  `researcher_name` TEXT,
  `supervisor_name` TEXT,
  `faculty_state` TEXT,
  `date_submitted` TEXT,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin` (`username`, `password_hash`)
VALUES ('admin', '$2y$12$FzQBP84Mc9S6a0/t6fXTqOXnVHgqKZFqTktq/V7/U/HcfTAFjOUva');

SET FOREIGN_KEY_CHECKS = 1;
