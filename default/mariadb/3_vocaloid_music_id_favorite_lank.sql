-- Select DB
USE `ponzu0529_tools`;

-- Create Table
DROP TABLE IF EXISTS `vocaloid_music_id_favorite_lank`;
CREATE TABLE IF NOT EXISTS `vocaloid_music_id_favorite_lank` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `music_id` int(16) NOT NULL,
  `favorite_lank` int(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);

-- Transcate Table
TRUNCATE TABLE `vocaloid_music_id_favorite_lank`;

-- Insert Data
INSERT INTO `vocaloid_music_id_favorite_lank`
  (`music_id`, `favorite_lank`, `created_at`, `updated_at`)
VALUES
  (1, 3, now(), now())
  ,(2, 5, now(), now())
  ,(3, 1, now(), now())
  ,(4, -1, now(), now())
  ,(5, 0, now(), now())
;
