<?php

require_once __DIR__ . '/ServiceTestBase.php';

require_once __DIR__ . '/../../common/Utils.php';

require_once __DIR__ . '/../../service/VocaloidMusicService.php';
require_once __DIR__ . '/../../model/data/VocaloidMusicListDataMock.php';


class VocaloidMusicServiceTest extends ServiceTestBase
{
  const SERVICE_NAME = 'VocaloidMusicServiceTest';


  public function get_all_data(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Start Service Test.'
    ));

    $service_response = VocaloidMusicListDataMock::get_all_data();

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

    $service_response = VocaloidMusicListDataMock::get_data_without_skip();

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
