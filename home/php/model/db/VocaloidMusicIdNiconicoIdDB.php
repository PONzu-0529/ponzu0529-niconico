<?php

require_once __DIR__ . '/DBBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


class VocaloidMusicIdNiconicoIdDB extends DBBase
{
  public function get_vocaloid_music_id_niconico_id(): ResponseStyle
  {
    $music_list = [];

    $sql_result = $this->mysqli->query(
      "
        SELECT
          `music_id`,
          `niconico_id`
        FROM
          `vocaloid_music_id_niconico_id`
        ;
      "
    );

    $db_result = $sql_result->fetch_all(MYSQLI_ASSOC);

    foreach ($db_result as $music) {
      $music_list[intval($music['music_id'])] = [
        'niconico_id' => $music['niconico_id']
      ];
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $music_list
    );
  }
}
