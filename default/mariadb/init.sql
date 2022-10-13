-- Set Character
SET CHARACTER_SET_CLIENT = utf8;
SET CHARACTER_SET_CONNECTION = utf8;

-- Create DB
CREATE DATABASE IF NOT EXISTS `ponzu0529_tools` CHARACTER SET utf8;
USE `ponzu0529_tools`;

-- Create Table `line_notify_access_tokens`
DROP TABLE IF EXISTS `line_notify_access_tokens`;
CREATE TABLE IF NOT EXISTS `line_notify_access_tokens` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(64) NOT NULL,
  `access_token` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);

-- Transcate Table `line_notify_access_tokens`
TRUNCATE TABLE `line_notify_access_tokens`;

-- Insert Data into `line_notify_access_tokens`
INSERT INTO `line_notify_access_tokens`
  (`type`, `access_token`, `created_at`, `updated_at`)
VALUES
  ('log', 'LOG_LINE_ACCESS_TOKEN', now(), now())
  ,('alert', 'ALERT_LINE_ACCESS_TOKEN', now(), now())
  ,('error', 'ERROR_LINE_ACCESS_TOKEN', now(), now())
  ,('success', 'SUCCESS_LINE_ACCESS_TOKEN', now(), now())
;
