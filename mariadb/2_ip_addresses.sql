-- Create Table
DROP TABLE IF EXISTS `ip_addresses`;

CREATE TABLE IF NOT EXISTS `ip_addresses` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ip_address` varchar(64) NOT NULL,
  `memo` varchar(64),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
);

-- Transcate Table
TRUNCATE TABLE `ip_addresses`;

-- Insert Data
INSERT INTO
  `ip_addresses` (`ip_address`, `memo`, `created_at`, `updated_at`)
VALUES
  ('127.0.0.1', 'local', now(), now());