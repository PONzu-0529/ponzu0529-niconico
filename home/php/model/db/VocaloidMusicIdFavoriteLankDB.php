<?php

require_once __DIR__ . '/DBBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


class VocaloidMusicIdFavoriteLankDB
{
  public static function get_favorite_lank_by_music_id(int $music_id): ResponseStyle
  {
    $mysqli = DBBase::get_db_connection();

    $str_music_id = strval($music_id);

    $sql_result = $mysqli->query(
      "
        SELECT
          `favorite_lank`
        FROM
          `vocaloid_music_id_favorite_lank`
        WHERE
          `music_id` = $str_music_id
        ;
      "
    );

    $db_result = $sql_result->fetch_assoc();

    if (isset($db_result)) {
      return new ResponseStyle(
        ResponseStatusOption::SUCCESS,
        $db_result['favorite_lank']
      );
    } else {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        'Failure SQL Result.'
      );
    }
  }


  public static function insert_data(VocaloidMusicIdFavoriteLankStyle $data): void
  {
    $mysqli = DBBase::get_db_connection();

    $music_id = $data->get_music_id();
    $str_music_id = strval($music_id);
    $favorite_lank = $data->get_favorite_lank();
    $str_favorite_lank = strval($favorite_lank);

    $mysqli->query(
      "
        INSERT INTO `vocaloid_music_id_favorite_lank`
          (`music_id`, `favorite_lank`, `created_at`, `updated_at`)
        VALUES
          ($str_music_id, '$str_favorite_lank', now(), now())
        ;
      "
    );
  }


  public static function update_data(int $id, VocaloidMusicIdFavoriteLankStyle $data): void
  {
    $mysqli = DBBase::get_db_connection();

    $str_id = strval($id);
    $music_id = $data->get_music_id();
    $str_music_id = strval($music_id);
    $favorite_lank = $data->get_favorite_lank();
    $str_favorite_lank = strval($favorite_lank);

    $mysqli->query(
      "
        UPDATE
          `vocaloid_music_id_favorite_lank`
        SET
          `music_id` = $str_music_id,
          `favorite_lank` = $str_favorite_lank,
          `updated_at` = now()
        WHERE
          `id` = $str_id
        ;
      "
    );
  }


  public static function delete_data(int $id): void
  {
    $mysqli = DBBase::get_db_connection();

    $str_id = strval($id);

    $mysqli->query(
      "
        DELETE FROM
          `vocaloid_music_id_favorite_lank`
        WHERE
          `id` = $str_id
        ;
      "
    );
  }
}


class VocaloidMusicIdFavoriteLankStyle
{
  private int $id;
  private int $music_id;
  private int $favorite_lank;

  public function __construct(int $id, int $music_id, int $favorite_lank)
  {
    $this->id = $id;
    $this->music_id = $music_id;
    $this->favorite_lank = $favorite_lank;
  }

  public function get_id(): int
  {
    return $this->id;
  }
  public function get_music_id(): int
  {
    return $this->music_id;
  }
  public function get_favorite_lank(): int
  {
    return $this->favorite_lank;
  }
}
