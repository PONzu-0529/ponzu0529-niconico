<?php

require_once __DIR__ . '/../../common/ResponseStyle.php';

require_once __DIR__ . '/../db/VocaloidMusicsDB.php';
require_once __DIR__ . '/../db/VocaloidMusicIdNiconicoIdDB.php';
require_once __DIR__ . '/../db/VocaloidMusicIdFavoriteLankDB.php';


class VocaloidMusicListData
{
  protected array $vocaloid_music_list_data;

  private VocaloidMusicsDB $vocaloid_musics_db;
  private VocaloidMusicIdNiconicoIdDB $vocaloid_music_id_niconico_id_db;
  private VocaloidMusicIdFavoriteLankDB $vocaloid_music_id_favorite_lank_db;


  public function __construct()
  {
    $this->init();
    $this->set_all_data();
  }


  public function get_all_data(): ResponseStyle
  {
    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $this->vocaloid_music_list_data
    );
  }


  public function get_data_without_skip(): ResponseStyle
  {
    $list = [];

    foreach ($this->vocaloid_music_list_data as $data) {
      $music = new VocaloidMusic(
        $data->get_id(),
        $data->get_video_id(),
        $data->get_title(),
        $data->get_description(),
        $data->get_vocal_id_list(),
        $data->get_creater_id_list(),
        $data->get_favorite_lank()
      );

      if ($music->get_favorite_lank() !== VocaloidMusicFavoriteLankType::SKIP) {
        array_push($list, $music);
      }
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $list
    );
  }


  private function init(): void
  {
    $this->vocaloid_music_list_data = [];

    $this->vocaloid_musics_db = new VocaloidMusicsDB();
    $this->vocaloid_music_id_niconico_id_db = new VocaloidMusicIdNiconicoIdDB();
    $this->vocaloid_music_id_favorite_lank_db = new VocaloidMusicIdFavoriteLankDB();
  }


  private function set_all_data(): void
  {
    $music_list = $this->get_vocaloid_music_list();
    $music_id_niconico_id = $this->get_vocaloid_music_id_niconico_id();
    $music_id_favorite_lank = $this->get_vocaloid_music_id_favorite_lank();

    foreach ($music_list as $music) {
      $id = $music['id'];
      $title = $music['title'];
      $niconico_id = $music_id_niconico_id[$id]['niconico_id'];
      $favorite_lank = $music_id_favorite_lank[$id]['favorite_lank'];

      array_push(
        $this->vocaloid_music_list_data,
        new VocaloidMusic(
          $id,
          $niconico_id,
          $title,
          '',
          [],
          [],
          $favorite_lank
        )
      );
    }
  }


  private function get_vocaloid_music_list(): array
  {
    $vocaloid_musics_db_response = $this->vocaloid_musics_db->get_vocaloid_music_list();

    if ($vocaloid_musics_db_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return [];
    }

    return $vocaloid_musics_db_response->get_data();
  }


  private function get_vocaloid_music_id_niconico_id(): array
  {
    $vocaloid_music_id_niconico_id_db_response = $this->vocaloid_music_id_niconico_id_db->get_vocaloid_music_id_niconico_id();

    if ($vocaloid_music_id_niconico_id_db_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return [];
    }

    return $vocaloid_music_id_niconico_id_db_response->get_data();
  }


  private function get_vocaloid_music_id_favorite_lank(): array
  {
    $vocaloid_music_id_favorite_lank_db_response = $this->vocaloid_music_id_favorite_lank_db->get_vocaloid_music_id_favorite_lank();

    if ($vocaloid_music_id_favorite_lank_db_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return [];
    }

    return $vocaloid_music_id_favorite_lank_db_response->get_data();
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
