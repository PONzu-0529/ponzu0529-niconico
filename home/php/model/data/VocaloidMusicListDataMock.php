<?php

require_once __DIR__ . '/VocaloidMusicListData.php';


class VocaloidMusicListDataMock extends VocaloidMusicListData
{
  public function __construct()
  {
    parent::__construct();

    $this->vocaloid_music_list_data = [
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
}
