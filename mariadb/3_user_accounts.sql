-- Select DB
USE `ponzu0529_devtools`;

-- Create Table
DROP TABLE IF EXISTS `user_accounts`;
CREATE TABLE IF NOT EXISTS `user_accounts` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);

-- Transcate Table
TRUNCATE TABLE `user_accounts`;

-- Insert Data
INSERT INTO `user_accounts`
  (`name`, `email`, `password_hash`, `created_at`, `updated_at`)
VALUES
  ('test_user', 'test@tools.ponzu0529.com', '10a6e6cc8311a3e2bcc09bf6c199adecd5dd59408c343e926b129c4914f3cb01', now(), now()) -- test_password
  ,('access_token_test_user', 'access_token_test@tools.ponzu0529.com', 'test_access_token', now(), now())
;
