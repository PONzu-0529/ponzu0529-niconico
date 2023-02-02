-- Select DB
USE `ponzu0529_devtools`;

-- Create Table
DROP TABLE IF EXISTS `vocaloid_musics`;
CREATE TABLE IF NOT EXISTS `vocaloid_musics` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);

-- Transcate Table
TRUNCATE TABLE `vocaloid_musics`;

-- Insert Data
INSERT INTO `vocaloid_musics`
  (`title`, `created_at`, `updated_at`)
VALUES
  ('Test Music Title 1', now(), now())
  ,('Test Music Title 2', now(), now())
  ,('Test Music Title 3', now(), now())
  ,('Test Music Title 4', now(), now())
  ,('Test Music Title 5', now(), now())
;
