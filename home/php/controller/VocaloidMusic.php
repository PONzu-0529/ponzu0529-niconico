<?php

require_once __DIR__ . '/Base.php';

require_once __DIR__ . '/../service/AuthService.php';
require_once __DIR__ . '/../service/LoggingService.php';
require_once __DIR__ . '/../service/VocaloidMusicService.php';


class VocaloidMusicController extends ControllerBase
{
  private const SERVICE_NAME = 'VocaloidMusicController';
  private const ALLOW_VERSION_LIST = ['v1'];


  public function GetMusicList(): ControllerResponseStyle
  {
    return $this->common_response('get_all_data');
  }


  public function GetMusicListWithoutSkip(): ControllerResponseStyle
  {
    return $this->common_response('get_data_without_skip');
  }


  public function InsertMusic(): ControllerResponseStyle
  {
    return $this->common_response('insert_music');
  }


  public function UpdateMusic(): ControllerResponseStyle
  {
    return $this->common_response('update_music');
  }


  public function DeleteMusic(): ControllerResponseStyle
  {
    return $this->common_response('delete_music');
  }


  private function common_response(string $function_name)
  {
    static::record_start();

    // Validate Host
    if (!$this->check_allow_remote_ip_address()) {
      return static::return_error('This IP Address is not Accepted.');
    }

    // Validate Version
    if (!$this->check_version(static::ALLOW_VERSION_LIST)) {
      return static::return_error("Version $this->version is not accepted.");
    }

    // Validate Body AccessToken
    if (!$this->check_body('accessToken')) {
      return static::return_error('Parameter "accessToken" is not set.');
    }

    $access_token = $this->body['accessToken'];

    // id
    if (in_array($function_name, ['update_music', 'delete_music'], true)) {
      if (!$this->check_body('id')) {
        return static::return_error('Parameter "id" is not set.');
      }

      $id = $this->body['id'];
    }

    // video_id
    if (in_array($function_name, ['insert_music', 'update_music'], true)) {
      if (!$this->check_body('video_id')) {
        return static::return_error('Parameter "video_id" is not set.');
      }

      $video_id = $this->body['video_id'];
    }

    // title
    if (in_array($function_name, ['insert_music', 'update_music'], true)) {
      if (!$this->check_body('title')) {
        return static::return_error('Parameter "title" is not set.');
      }

      $title = $this->body['title'];
    }

    // favorite_lank
    if (in_array($function_name, ['insert_music', 'update_music'], true)) {
      if (!$this->check_body('favorite_lank')) {
        return static::return_error('Parameter "favorite_lank" is not set.');
      }

      $favorite_lank = $this->body['favorite_lank'];
    }

    // Check AccessToken
    $check_access_token_response = AuthService::check_access_token($access_token);

    if ($check_access_token_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return static::return_error(strval($check_access_token_response->get_data()));
    }

    // Call Function
    switch ($function_name) {
      case 'insert_music':
        $get_all_data_response = VocaloidMusicService::$function_name(
          new VocaloidMusic(
            -1,
            $video_id,
            $title,
            '',
            [],
            [],
            $favorite_lank
          )
        );
        break;

      case 'update_music':
        $get_all_data_response = VocaloidMusicService::$function_name(
          $id,
          new VocaloidMusic(
            -1,
            $video_id,
            $title,
            '',
            [],
            [],
            $favorite_lank
          )
        );
        break;

      case 'delete_music':
        $get_all_data_response = VocaloidMusicService::$function_name($id);
        break;

      default:
        $get_all_data_response = VocaloidMusicService::$function_name();
        break;
    }

    if ($get_all_data_response->get_status() !== ResponseStatusOption::SUCCESS) {
      return static::return_error(strval($get_all_data_response->get_data()));
    }

    static::record_finish();

    return new ControllerResponseStyle(
      ControllerResponseStatusOption::SUCCESS,
      $get_all_data_response->get_data()
    );
  }


  private static function return_error(string $error_message): ControllerResponseStyle
  {
    static::record_error($error_message);

    return new ControllerResponseStyle(
      ControllerResponseStatusOption::FAILURE,
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
