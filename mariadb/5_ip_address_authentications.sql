-- Create Table
DROP TABLE IF EXISTS `ip_address_authentications`;

CREATE TABLE IF NOT EXISTS `ip_address_authentications` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `function_id` varchar(64) NOT NULL,
  `ip_addresse_id` int(16) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
);

-- Transcate Table
TRUNCATE TABLE `ip_address_authentications`;

-- Insert Data
INSERT INTO
  `ip_address_authentications` (
    `function_id`,
    `ip_addresse_id`,
    `created_at`,
    `updated_at`
  )
VALUES
  ('COMMAND_LOG', 1, now(), now());