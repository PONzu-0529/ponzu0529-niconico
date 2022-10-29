<?php

require_once __DIR__ . '/DBBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


class VocaloidMusicIdNiconicoIdDB
{
  public static function get_niconico_id_by_music_id(int $music_id): ResponseStyle
  {
    $mysqli = DBBase::get_db_connection();

    $str_music_id = strval($music_id);

    $sql_result = $mysqli->query(
      "
        SELECT
          `niconico_id`
        FROM
          `vocaloid_music_id_niconico_id`
        WHERE
          `music_id` = $str_music_id
        ;
      "
    );

    $db_result = $sql_result->fetch_assoc();

    if (isset($db_result)) {
      return new ResponseStyle(
        ResponseStatusOption::SUCCESS,
        $db_result['niconico_id']
      );
    } else {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        'Failure SQL Result.'
      );
    }
  }


  public static function insert_data(VocaloidMusicIdNiconicoIdStyle $data): int
  {
    $mysqli = DBBase::get_db_connection();

    $music_id = $data->get_music_id();
    $str_music_id = strval($music_id);
    $niconico_id = $data->get_niconico_id();

    $mysqli->query(
      "
        INSERT INTO `vocaloid_music_id_niconico_id`
          (`music_id`, `niconico_id`, `created_at`, `updated_at`)
        VALUES
          ($str_music_id, '$niconico_id', now(), now())
        ;
      "
    );

    return $mysqli->insert_id;
  }


  public static function update_data_by_music_id(int $music_id, VocaloidMusicIdNiconicoIdStyle $data): void
  {
    $mysqli = DBBase::get_db_connection();

    $str_music_id = strval($music_id);
    $niconico_id = $data->get_niconico_id();

    $mysqli->query(
      "
        UPDATE
          `vocaloid_music_id_niconico_id`
        SET
          `niconico_id` = '$niconico_id',
          `updated_at` = now()
        WHERE
          `music_id` = '$str_music_id'
        ;
      "
    );
  }


  public static function delete_data_by_music_id(int $music_id): void
  {
    $mysqli = DBBase::get_db_connection();

    $str_music_id = strval($music_id);

    $mysqli->query(
      "
        DELETE FROM
          `vocaloid_music_id_niconico_id`
        WHERE
          `music_id` = $str_music_id
        ;
      "
    );
  }
}


class VocaloidMusicIdNiconicoIdStyle
{
  private int $id;
  private int $music_id;
  private string $niconico_id;

  public function __construct(int $id, int $music_id, string $niconico_id)
  {
    $this->id = $id;
    $this->music_id = $music_id;
    $this->niconico_id = $niconico_id;
  }

  public function get_id(): int
  {
    return $this->id;
  }
  public function get_music_id(): int
  {
    return $this->music_id;
  }
  public function get_niconico_id(): string
  {
    return $this->niconico_id;
  }
}
