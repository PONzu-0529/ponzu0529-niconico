<?php

require_once __DIR__ . '/../common/ResponseStyle.php';

require_once __DIR__ . '/../model/data/VocaloidMusicListData.php';

require_once __DIR__ . '/../service/LoggingService.php';


class VocaloidMusicService
{
  const SERVICE_NAME = 'VocaloidMusicService';


  public static function get_all_data(): ResponseStyle
  {
    static::record('Start Service.');

    $data_response = VocaloidMusicListData::get_all_data();

    if ($data_response->get_status() !== ResponseStatusOption::SUCCESS) {
      $response_message = strval($data_response->get_data());

      static::record_error($response_message);

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        $response_message
      );
    }

    static::record('Finish Service.');

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $data_response->get_data()
    );
  }


  public static function get_data_without_skip(): ResponseStyle
  {
    static::record('Start Service.');

    $data_response = VocaloidMusicListData::get_data_without_skip();

    if ($data_response->get_status() !== ResponseStatusOption::SUCCESS) {
      $response_message = strval($data_response->get_data());

      static::record_error($response_message);

      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        $response_message
      );
    }

    static::record('Finish Service.');

    return new ResponseStyle(
      ResponseStatusOption::SUCCESS,
      $data_response->get_data()
    );
  }


  private static function record(string $log): void
  {
    LoggingService::record(static::SERVICE_NAME, $log);
  }


  private static function record_error(string $log): void
  {
    LoggingService::record_error(static::SERVICE_NAME, $log);
  }
}
