<?php

require_once __DIR__ . '/DBBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


class VocaloidMusicsDB
{
  public static function get_all_music(): ResponseStyle
  {
    $music_list = [];
    $mysqli = DBBase::get_db_connection();

    $sql_result = $mysqli->query(
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
        new VocaloidMusicsStyle(
          intval($music['id']),
          $music['title']
        )
      );
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $music_list
    );
  }


  public static function insert_music(VocaloidMusicsStyle $music): int
  {
    $mysqli = DBBase::get_db_connection();

    $title = $music->get_title();

    $mysqli->query(
      "
        INSERT INTO `vocaloid_musics`
          (`title`, `created_at`, `updated_at`)
        VALUES
          ('$title', now(), now())
        ;
      "
    );

    return $mysqli->insert_id;
  }


  public static function update_music(int $id, VocaloidMusicsStyle $music): void
  {
    $mysqli = DBBase::get_db_connection();

    $str_id = strval($id);
    $title = $music->get_title();

    $mysqli->query(
      "
        UPDATE
          `vocaloid_musics`
        SET
          `title` = '$title',
          `updated_at` = now()
        WHERE
          `id` = $str_id
        ;
      "
    );
  }


  public static function delete_music(int $id): void
  {
    $mysqli = DBBase::get_db_connection();

    $str_id = strval($id);

    $mysqli->query(
      "
        DELETE FROM
          `vocaloid_musics`
        WHERE
          `id` = $str_id
        ;
      "
    );
  }
}


class VocaloidMusicsStyle
{
  private int $id;
  private string $title;

  public function __construct(int $id, string $title)
  {
    $this->id = $id;
    $this->title = $title;
  }

  public function get_id(): int
  {
    return $this->id;
  }
  public function get_title(): string
  {
    return $this->title;
  }
}
