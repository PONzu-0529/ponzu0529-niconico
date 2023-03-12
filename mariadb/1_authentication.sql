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
INSERT INTO
  `authentication` (
    `user_id`,
    `function_id`,
    `authentication_level`,
    `created_at`,
    `updated_at`
  )
VALUES
  ('1', 'MYLIST_ASSISTANT', 'VIEW', now(), now()),
  ('1', 'MYLIST_ASSISTANT', 'EDIT', now(), now()),
  (
    '1',
    'MYLIST_ASSISTANT',
    'MASTER_EDIT',
    now(),
    now()
  ),
  ('2', 'MYLIST_ASSISTANT', 'VIEW', now(), now()),
  ('2', 'MYLIST_ASSISTANT', 'EDIT', now(), now()),
  ('3', 'MYLIST_ASSISTANT', 'VIEW', now(), now());