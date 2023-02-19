<?php

require_once __DIR__ . '/../../common/ResponseStyle.php';

require_once __DIR__ . '/../db/VocaloidMusicsDB.php';
require_once __DIR__ . '/../db/VocaloidMusicIdNiconicoIdDB.php';
require_once __DIR__ . '/../db/VocaloidMusicIdFavoriteLankDB.php';


class VocaloidMusicListData
{
  public static function get_all_data(): ResponseStyle
  {
    $music_list = [];

    $all_music_response = VocaloidMusicsDB::get_all_music();

    if ($all_music_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        $all_music_response->get_data()
      );
    }

    foreach ($all_music_response->get_data() as $music) {
      $music_id = (int)$music->get_id();
      $title = (string)$music->get_title();

      $niconico_id_by_music_id_response = VocaloidMusicIdNiconicoIdDB::get_niconico_id_by_music_id($music_id);

      if ($niconico_id_by_music_id_response->get_status() !== ResponseStatusOption::SUCCESS) {
        return new ResponseStyle(
          ResponseStatusOption::FAILURE,
          $niconico_id_by_music_id_response->get_data()
        );
      }

      $niconico_id = (string)$niconico_id_by_music_id_response->get_data();

      $favorite_lank_by_music_id_response = VocaloidMusicIdFavoriteLankDB::get_favorite_lank_by_music_id($music_id);

      if ($favorite_lank_by_music_id_response->get_status() !== ResponseStatusOption::SUCCESS) {
        return new ResponseStyle(
          ResponseStatusOption::FAILURE,
          $favorite_lank_by_music_id_response->get_data()
        );
      }

      $favorite_lank = (int)$favorite_lank_by_music_id_response->get_data();

      // Result
      $vocaloid_music = new VocaloidMusic(
        $music_id,
        $niconico_id,
        $title,
        '',
        [],
        [],
        $favorite_lank
      );

      array_push(
        $music_list,
        $vocaloid_music->get_all_data()
      );
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $music_list
    );
  }


  public static function get_data_without_skip(): ResponseStyle
  {
    $music_list = [];

    $all_data_response = static::get_all_data();

    if ($all_data_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        $all_data_response->get_data()
      );
    }

    foreach ($all_data_response->get_data() as $music) {
      if ($music['favorite_lank'] !== VocaloidMusicFavoriteLankType::SKIP) {
        array_push($music_list, $music);
      }
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $music_list
    );
  }


  public static function insert_music(VocaloidMusic $music): ResponseStyle
  {
    $music_id = VocaloidMusicsDB::insert_music(new VocaloidMusicsStyle(-1, $music->get_title()));
    VocaloidMusicIdNiconicoIdDB::insert_data(new VocaloidMusicIdNiconicoIdStyle(-1, $music_id, $music->get_video_id()));
    VocaloidMusicIdFavoriteLankDB::insert_data(new VocaloidMusicIdFavoriteLankStyle(-1, $music_id, $music->get_favorite_lank()));

    return new ResponseStyle(ResponseStatusOption::SUCCESS, ['id' => $music_id]);
  }


  public static function update_music(int $id, VocaloidMusic $music): ResponseStyle
  {
    VocaloidMusicsDB::update_music($id, new VocaloidMusicsStyle($id, $music->get_title()));
    VocaloidMusicIdNiconicoIdDB::update_data_by_music_id($id, new VocaloidMusicIdNiconicoIdStyle(-1, $id, $music->get_video_id()));
    VocaloidMusicIdFavoriteLankDB::update_data_by_music_id($id, new VocaloidMusicIdFavoriteLankStyle(-1, $id, $music->get_favorite_lank()));

    return new ResponseStyle(ResponseStatusOption::SUCCESS);
  }


  public static function delete_music(int $id): ResponseStyle
  {
    VocaloidMusicsDB::delete_music($id);
    VocaloidMusicIdNiconicoIdDB::delete_data_by_music_id($id);
    VocaloidMusicIdFavoriteLankDB::delete_data_by_music_id($id);

    return new ResponseStyle(ResponseStatusOption::SUCCESS);
  }
}


class VocaloidMusic
{
  private int $id;
  private string $video_id;
  private string $title;
  private string $description;
  private array $vocal_id_list;
  private array $creater_id_list;
  private int $favorite_lank;


  public function __construct(
    int $id = -1,
    string $video_id,
    string $title,
    string $description = '',
    array $vocal_id_list = [],
    array $creater_id_list = [],
    int $favorite_lank = VocaloidMusicFavoriteLankType::UNDEFINED
  ) {
    $this->id = $id;
    $this->video_id = $video_id;
    $this->title = $title;
    $this->description = $description;
    $this->vocal_id_list = $vocal_id_list;
    $this->creater_id_list = $creater_id_list;
    $this->favorite_lank = $favorite_lank;
  }


  // Getter
  public function get_id(): int
  {
    return $this->id;
  }
  public function get_video_id(): string
  {
    return $this->video_id;
  }
  public function get_title(): string
  {
    return $this->title;
  }
  public function get_description(): string
  {
    return $this->description;
  }
  public function get_vocal_id_list(): array
  {
    return $this->vocal_id_list;
  }
  public function get_creater_id_list(): array
  {
    return $this->creater_id_list;
  }
  public function get_favorite_lank(): int
  {
    return $this->favorite_lank;
  }

  public function get_all_data(): array
  {
    return [
      'id' => $this->get_id(),
      'video_id' => $this->get_video_id(),
      'title' => $this->get_title(),
      'description' => $this->get_description(),
      'vocal_id_list' => $this->get_vocal_id_list(),
      'creater_id_list' => $this->get_creater_id_list(),
      'favorite_lank' => $this->get_favorite_lank()
    ];
  }
}


class VocaloidMusicFavoriteLankType
{
  const AWESOME = 5;
  const GOOD = 4;
  const NORMAL = 3;
  const DISLIKE = 2;
  const POOR = 1;
  const UNDEFINED = 0;
  const SKIP = -1;
}
