-- Select DB
USE `ponzu0529_tools`;

-- Create Table
DROP TABLE IF EXISTS `user_account_access_token`;
CREATE TABLE IF NOT EXISTS `user_account_access_token` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_account_id` int(16) NOT NULL,
  `access_token` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);

-- Transcate Table
TRUNCATE TABLE `user_account_access_token`;

-- Insert Data
INSERT INTO `user_account_access_token`
  (`user_account_id`, `access_token`, `created_at`, `updated_at`)
VALUES
  ('2', 'old_access_token', '2000-01-01 00:00:00', now())
  ,('2', 'test_access_token', now(), now())
;
