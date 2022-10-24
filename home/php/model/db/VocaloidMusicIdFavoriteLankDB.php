<?php

require_once __DIR__ . '/DBBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


class VocaloidMusicIdFavoriteLankDB extends DBBase
{
  public function get_vocaloid_music_id_favorite_lank(): ResponseStyle
  {
    $music_list = [];

    $sql_result = $this->mysqli->query(
      "
        SELECT
          `music_id`,
          `favorite_lank`
        FROM
          `vocaloid_music_id_favorite_lank`
        ;
      "
    );

    $db_result = $sql_result->fetch_all(MYSQLI_ASSOC);

    foreach ($db_result as $music) {
      $music_list[intval($music['music_id'])] = [
        'favorite_lank' => $music['favorite_lank']
      ];
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $music_list
    );
  }
}
