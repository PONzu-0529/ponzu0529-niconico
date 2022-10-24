<?php

require_once __DIR__ . '/ServiceBase.php';

require_once __DIR__ . '/../common/ResponseStyle.php';

require_once __DIR__ . '/../model/data/VocaloidMusicListData.php';
require_once __DIR__ . '/../model/data/VocaloidMusicListDataMock.php';


class VocaloidMusicService extends ServiceBase
{
  const SERVICE_NAME = 'VocaloidMusicService';

  private VocaloidMusicListData $vocaloid_music_list_data;


  public function __construct()
  {
    parent::__construct();

    $this->vocaloid_music_list_data = new VocaloidMusicListData();
  }


  public function set_mock_data(VocaloidMusicListDataMock $vocaloid_music_list_data_mock): void
  {
    $this->vocaloid_music_list_data = $vocaloid_music_list_data_mock;
  }


  public function get_all_data(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      "Start Service."
    ));

    $data_response = $this->vocaloid_music_list_data->get_all_data();

    if ($data_response->get_status() !== ResponseStatusOption::SUCCESS) {
      $response_message = strval($data_response->get_data());

      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        $response_message
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        $response_message
      );
    }

    $debug_info = debug_backtrace();
    $first_debug_info = array_shift($debug_info);
    $function_name = $first_debug_info['function'];

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Finish Service "' . Utils::change_camel_case($function_name) . '".'
    ));

    return new ResponseStyle(
      ServiceResultOption::SUCCESS,
      $data_response->get_data()
    );
  }


  public function get_data_without_skip(): ResponseStyle
  {
    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      "Start Service."
    ));

    $data_response = $this->vocaloid_music_list_data->get_data_without_skip();

    if ($data_response->get_status() !== ResponseStatusOption::SUCCESS) {
      $response_message = strval($data_response->get_data());

      $this->logging_service->record_log(new LogStyle(
        $this::SERVICE_NAME,
        LogTypeOption::ERROR,
        $response_message
      ));

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        $response_message
      );
    }

    $debug_info = debug_backtrace();
    $first_debug_info = array_shift($debug_info);
    $function_name = $first_debug_info['function'];

    $this->logging_service->record_log(new LogStyle(
      $this::SERVICE_NAME,
      LogTypeOption::LOG,
      'Finish Service "' . Utils::change_camel_case($function_name) . '".'
    ));

    return new ResponseStyle(
      ServiceResultOption::SUCCESS,
      $data_response->get_data()
    );
  }
}
