<?php

require_once __DIR__ . '/ApiTestBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';
require_once __DIR__ . '/../../common/Utils.php';

require_once __DIR__ . '/../../service/LoggingService.php';


class VocaloidMusicApiTest
{
  private const SERVICE_NAME = 'VocaloidMusicApiTest';


  public static function get_music_list(): ResponseStyle
  {
    $host = ApiTestBase::get_host();

    return static::common_api_test(
      "$host/api/v1/vocaloid-music/get-music-list",
      [
        'accessToken' => 'test_access_token'
      ]
    );
  }


  public static function get_data_without_skip(): ResponseStyle
  {
    $host = ApiTestBase::get_host();

    return static::common_api_test(
      "$host/api/v1/vocaloid-music/get-music-list-without-skip",
      [
        'accessToken' => 'test_access_token'
      ]
    );
  }


  public static function insert_music(): ResponseStyle
  {
    $host = ApiTestBase::get_host();

    return static::common_api_test(
      "$host/api/v1/vocaloid-music/insert-music",
      [
        'accessToken' => 'test_access_token',
        'title' => 'API Test Insert Title',
        'video_id' => 'API_TEST_INSERT_VIDEO_ID',
        'favorite_lank' => '0'
      ]
    );
  }


  public static function update_music(): ResponseStyle
  {
    $host = ApiTestBase::get_host();

    return static::common_api_test(
      "$host/api/v1/vocaloid-music/update-music",
      [
        'accessToken' => 'test_access_token',
        'id' => '3',
        'title' => 'API Test Update Title',
        'video_id' => 'API_TEST_UPDATE_VIDEO_ID',
        'favorite_lank' => '2'
      ]
    );
  }


  public static function delete_music(): ResponseStyle
  {
    $host = ApiTestBase::get_host();

    return static::common_api_test(
      "$host/api/v1/vocaloid-music/delete-music",
      [
        'accessToken' => 'test_access_token',
        'id' => '4'
      ]
    );
  }


  public static function common_api_test(string $url, array $body = []): ResponseStyle
  {
    static::record_start();

    $api_call_test_response = ApiTestBase::post_api_call_test(
      new ApiCallTestOption($url, $body)
    );

    if ($api_call_test_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return static::return_error(strval($api_call_test_response->get_data()));
    }

    $compare_response_style_response = Utils::compare_response_style_only_status(
      $api_call_test_response,
      new ResponseStyle(
        ResponseStatusOption::SUCCESS
      )
    );

    if ($compare_response_style_response->get_status() !== ResponseStatusOption::SUCCESS) {
      static::record_error(strval($compare_response_style_response->get_data()));
    } else {
      static::record(strval($compare_response_style_response->get_data()));
    }

    static::record_finish();

    return $compare_response_style_response;
  }


  private static function return_error(string $error_message): ResponseStyle
  {
    static::record_error($error_message);

    return new ResponseStyle(
      ResponseStatusOption::FAILURE,
      $error_message
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


  private static function record_start(): void
  {
    static::record('Start Controller.');
  }


  private static function record_finish(): void
  {
    static::record('Finish Controller.');
  }
}
