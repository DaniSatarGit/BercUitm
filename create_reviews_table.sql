-- Migration: create reviews table to store full reviewer submissions
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `project_evaluation_id` INT DEFAULT NULL,
  `application_id` INT DEFAULT NULL,
  `reviewer_application_id` INT DEFAULT NULL,
  `reviewer_id` INT DEFAULT NULL,
  `review_data` LONGTEXT,
  `decision` VARCHAR(100) DEFAULT NULL,
  `modifications` TEXT DEFAULT NULL,
  `pdf_filename` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_reviews_reviewer_app` (`reviewer_application_id`)
);

-- Optional: add foreign key if `reviewer_application` exists
-- ALTER TABLE `reviews`
--   ADD CONSTRAINT `fk_reviews_reviewer_application` FOREIGN KEY (`reviewer_application_id`) REFERENCES `reviewer_application` (`id`) ON DELETE SET NULL;
