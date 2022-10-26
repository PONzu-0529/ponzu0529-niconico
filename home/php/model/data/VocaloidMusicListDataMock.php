<?php

require_once __DIR__ . '/VocaloidMusicListData.php';


class VocaloidMusicListDataMock extends VocaloidMusicListData
{
  private array $vocaloid_music_list;


  public function __construct()
  {
    $this->vocaloid_music_list = [
      new VocaloidMusic(
        1, // id
        'VIDEO_ID_1', // video_id
        'Normal Music 1', // title
        '', // description
        [], // vocal_id_list
        [], // creater_id_list
        VocaloidMusicFavoriteLankType::NORMAL // favorite_lank
      ),
      new VocaloidMusic(
        2, // id
        'VIDEO_ID_2', // video_id
        'Normal Music 2', // title
        '', // description
        [], // vocal_id_list
        [], // creater_id_list
        VocaloidMusicFavoriteLankType::NORMAL // favorite_lank
      ),
      new VocaloidMusic(
        3, // id
        'VIDEO_ID_3', // video_id
        'Normal Music 3', // title
        '', // description
        [], // vocal_id_list
        [], // creater_id_list
        VocaloidMusicFavoriteLankType::NORMAL // favorite_lank
      ),
      new VocaloidMusic(
        4, // id
        'VIDEO_ID_4', // video_id
        'Skip Music 4', // title
        '', // description
        [], // vocal_id_list
        [], // creater_id_list
        VocaloidMusicFavoriteLankType::SKIP // favorite_lank
      )
    ];
  }


  public function get_vocaloid_music_list(): array
  {
    return $this->vocaloid_music_list;
  }


  public static function get_all_data(): ResponseStyle
  {
    $data = new static();
    $vocaloid_music_list = $data->get_vocaloid_music_list();

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $vocaloid_music_list
    );
  }


  public static function get_data_without_skip(): ResponseStyle
  {
    $music_list = [];

    $data = new static();
    $vocaloid_music_list = $data->get_vocaloid_music_list();

    foreach ($vocaloid_music_list as $music) {
      if ($music->get_favorite_lank() !== VocaloidMusicFavoriteLankType::SKIP) {
        array_push($music_list, $music);
      }
    }

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $music_list
    );
  }
}
