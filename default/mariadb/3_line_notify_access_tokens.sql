-- Select DB
USE `ponzu0529_tools`;

-- Create Table
DROP TABLE IF EXISTS `line_notify_access_tokens`;
CREATE TABLE IF NOT EXISTS `line_notify_access_tokens` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(64) NOT NULL,
  `access_token` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);

-- Transcate Table
TRUNCATE TABLE `line_notify_access_tokens`;

-- Insert Data
INSERT INTO `line_notify_access_tokens`
  (`type`, `access_token`, `created_at`, `updated_at`)
VALUES
  ('log', 'LOG_LINE_ACCESS_TOKEN', now(), now())
  ,('alert', 'ALERT_LINE_ACCESS_TOKEN', now(), now())
  ,('error', 'ERROR_LINE_ACCESS_TOKEN', now(), now())
  ,('success', 'SUCCESS_LINE_ACCESS_TOKEN', now(), now())
;
