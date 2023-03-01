-- Select DB
USE `ponzu0529_devtools`;

-- Create Table
DROP TABLE IF EXISTS `ip_address`;
CREATE TABLE IF NOT EXISTS `ip_address` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ip` varchar(64) NOT NULL,
  `control` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);

-- Transcate Table
TRUNCATE TABLE `ip_address`;

-- Insert Data
INSERT INTO `ip_address`
  (`ip`, `control`, `created_at`, `updated_at`)
VALUES
  ('127.0.0.1', 'allow', now(), now())
;
