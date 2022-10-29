-- Select DB
USE `ponzu0529_tools`;

-- Create Table
DROP TABLE IF EXISTS `vocaloid_music_id_niconico_id`;
CREATE TABLE IF NOT EXISTS `vocaloid_music_id_niconico_id` (
  `id` int(16) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `music_id` int(16) NOT NULL,
  `niconico_id` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
);

-- Transcate Table
TRUNCATE TABLE `vocaloid_music_id_niconico_id`;

-- Insert Data
INSERT INTO `vocaloid_music_id_niconico_id`
  (`music_id`, `niconico_id`, `created_at`, `updated_at`)
VALUES
  (1, 'NICONICO_ID_1', now(), now())
  ,(2, 'NICONICO_ID_2', now(), now())
  ,(3, 'NICONICO_ID_3', now(), now())
  ,(4, 'NICONICO_ID_4', now(), now())
  ,(5, 'NICONICO_ID_5', now(), now())
;
