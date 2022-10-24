<?php

require_once __DIR__ . '/DBBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


class VocaloidMusicsDB extends DBBase
{
  public function get_vocaloid_music_list(): ResponseStyle
  {
    $music_list = [];

    $sql_result = $this->mysqli->query(
      "
        SELECT
          `id`,
          `title`
        FROM
          `vocaloid_musics`
        ;
      "
    );

    $db_result = $sql_result->fetch_all(MYSQLI_ASSOC);

    foreach ($db_result as $music) {
      array_push(
        $music_list,
        [
          'id' => intval($music['id']),
          'title' => $music['title']
        ]
      );
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $music_list
    );
  }
}
