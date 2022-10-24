<?php

require_once __DIR__ . '/ServiceTestBase.php';

require_once __DIR__ . '/../../common/Utils.php';

require_once __DIR__ . '/../../service/VocaloidMusicService.php';
require_once __DIR__ . '/../../model/data/VocaloidMusicListDataMock.php';


class VocaloidMusicServiceTest extends ServiceTestBase
{
  const SERVICE_NAME = 'VocaloidMusicServiceTest';

  private VocaloidMusicService $vocaloid_music_service;


  public function __construct()
  {
    parent::__construct();

    $this->vocaloid_music_service = new VocaloidMusicService();
    $this->vocaloid_music_service->set_mock_data(new VocaloidMusicListDataMock());
  }


  public function get_all_data(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service Test.'
    ));

    $service_response = $this->vocaloid_music_service->get_all_data();

    if ($service_response->get_status() !== ResponseStatusOption::SUCCESS) {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        strval($service_response->get_data())
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        strval($service_response->get_data())
      );
    }

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Finish Service Test.'
    ));

    return $service_response;
  }


  public function get_data_without_skip(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service Test.'
    ));

    $service_response = $this->vocaloid_music_service->get_data_without_skip();

    if ($service_response->get_status() !== ResponseStatusOption::SUCCESS) {
      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        strval($service_response->get_data())
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        strval($service_response->get_data())
      );
    }

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Finish Service Test.'
    ));

    return $service_response;
  }
}
