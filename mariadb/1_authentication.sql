-- Create Table
DROP TABLE IF EXISTS `authentication`;

CREATE TABLE IF NOT EXISTS `authentication` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(16) NOT NULL,
  `function_id` varchar(64) NOT NULL,
  `authentication_level` varchar(64) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
);

-- Transcate Table
TRUNCATE TABLE `authentication`;

-- Insert Data